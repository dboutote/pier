<?php
/*
Plugin Name: Simple Tweets
Plugin URI:
Description: Easy, simple Twitter feed.
Author: darrinb
Version: 1.0
Author URI: http://darrinb.com
*/


/**
 * Simple_Tweets Class
 */
class Simple_Tweets {

	var $cb;
	private $options;

	/**
	 * Constructor
	 */
	public function __construct(){
		require('config.php');
		$this->options = $config_options;
	}


	/**
	 * Codebird Library
	 */
	public function setup_codebird ($options)
	{
		if( !class_exists('Codebird') ) {
			require('lib/codebird.php');
		}

		Codebird::setConsumerKey($options['api_key'], $options['api_secret']);

		$this->cb = Codebird::getInstance();
		$this->cb->setToken($options['access_token'], $options['access_token_secret']);

		// From Codebird documentation: For API methods returning multiple data (like statuses/home_timeline), you should cast the reply to array
		$this->cb->setReturnFormat( CODEBIRD_RETURNFORMAT_ARRAY );
	}


	/**
	 * Get tweets
	 *
	 * Unless override, checks transient cache before querying Twitter
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @uses Codebird::statuses_userTimeline()
	 * @uses
	 */
	public function get_tweets()
	{
		$options = $this->options;

		$transient_expire = HOUR_IN_SECONDS;
		$error_timeout = 5 * MINUTE_IN_SECONDS;
		$remaining_calls = 0;
		$reset_seconds = HOUR_IN_SECONDS;

		// set the number of tweets to pull' Twitter sets a max of 200
		$num_tweets = absint($options['num']);
     	$num_tweets = ( $num_tweets > 200 ) ? 200 : $num_tweets;


		// Validate options
		if( '' === $options['username']            ){ return __('Twitter username is not configured' ); }
		if( '' === $options['api_key']             ){ return __('Missing API key' ); }
		if( '' === $options['api_secret']          ){ return __('Missing API Secret key'); }
		if( '' === $options['access_token']        ){ return __('Missing Access token'); }
		if( '' === $options['access_token_secret'] ){ return __('Missing Access token secret'); }
		if( 0 === $num_tweets                      ){ return __('Number of tweets is not valid' ); }

		// init codebird class
		if ( !isset($this->cb) ) {
			$this->setup_codebird ($options);
		}

		// set transient name
		$transient_name = 'simpletweets_' . $options['username'] . '_' . $num_tweets;

		/**
		 * Overriding the transient cache
		 *
		 * Delete the current transient for the Twitter feed
		 * Delete the current transient for the Rate Limit Status
		 *
		 * @uses delete_transient()
		 * @uses get_transient()
		 * @uses set_transient()
		 * @uses Codebird::statuses_userTimeline()
		 */
		if( $options['update_cache'] ) {

			delete_transient($transient_name);
			delete_transient($transient_name.'_status');

			try {
				$twitter_data =  $this->cb->statuses_userTimeline(
					array(
						'screen_name' => $options['username'],
						'count' => $num_tweets,
						'exclude_replies' => $options['skip_replies'],
						'include_rts' => (!$options['skip_retweets'])
					)
				);
			} catch (Exception $e) {
				return __('Error retrieving tweets: ' . $e->getMessage() );
			}

			// if Twitter returns errors
			if (isset($twitter_data['errors'])) {
				return __('Twitter error: '.$twitter_data['errors'][0]['message']);
			}

		}

		/**
		 * If we're trying to use the transient cache
		 *
		 * @uses get_transient()
		 * @uses set_transient()
		 */
		if( '' === $options['update_cache'] ) {

			// Get transient
			$twitter_data = get_transient($transient_name);
			$twitter_status = get_transient($transient_name.'_status');

			/**
			 * If there's nothing in transient cache or it expired, get current Rate Limit Status
			 * @see https://dev.twitter.com/docs/rate-limiting/1.1
			 */
			if( !$twitter_status || !$twitter_data ) {
				try {
					$twitter_status = $this->cb->application_rateLimitStatus();
					set_transient($transient_name."_status", $twitter_status, $error_timeout);
				} catch (Exception $e) {
					return __('Error retrieving Rate Limit Status: ' . $e->getMessage() );
				}
			}

			// if the transient is empty, try to get new tweets
			if( false === $twitter_data ) {

				// $twitter_status could be false (no transient) or null ( $this->cb->application_rateLimitStatus() )
				if( isset($twitter_status['resources']['statuses']['/statuses/user_timeline']['remaining'] ) ){
					$remaining_calls = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['remaining'];
				}
				if( isset($twitter_status['resources']['statuses']['/statuses/user_timeline']['reset']) ){
					$reset_seconds = (int)$twitter_status['resources']['statuses']['/statuses/user_timeline']['reset']-time();
				}

				// if there's only a few calls left, set the expiration for the transient
				if( $remaining_calls <= 10 && $reset_seconds > 0 ) {
					$transient_expire = $reset_seconds;
					$error_timeout = $reset_seconds;
				}

				// grab the tweets
				try {
					$twitter_data =  $this->cb->statuses_userTimeline(
						array(
							'screen_name' => $options['username'],
							'count' => $num_tweets,
							'exclude_replies' => $options['skip_replies'],
							'include_rts' => (!$options['skip_retweets'])
						)
					);
				} catch (Exception $e) {
					return __('Error retrieving tweets: ' . $e->getMessage() );
				}

				// if Twitter returned something other than an error array, store it with the transient expiration
				if( !isset($twitter_data['errors']) & !empty($twitter_data) ) {
					set_transient($transient_name, $twitter_data, $transient_expire);
				} else {
					// else store it with the error expiration
					set_transient($transient_name, $twitter_data, $error_timeout);

					if (isset($twitter_data['errors'])) {
						return __('Twitter error: '.$twitter_data['errors'][0]['message']);
					}
				}

			} else {
				// If Twitter errors are stored in cache
				if (isset($twitter_data['errors'])) {
					return __('Twitter cache error: '.$twitter_data['errors'][0]['message']);
				}
			}

			// if Twitter didn't return errors or tweets
			if( empty($twitter_data)) {
				return __( 'No public tweets' );
			}

			// if Twitter returns errors
			if (isset($twitter_data['errors'])) {
				return __('Twitter error: '.$twitter_data['errors'][0]['message']);
			}

		}


		// if there's no Twitter data, return
		if( !is_array($twitter_data) || empty($twitter_data) || count($twitter_data) < 1 ) {
			return __('No public tweets');
		}

		// Begin building the feed
		$link_target = ' target="_blank" ';
		$out = '';
		$i = 0;
		$user_url = '';


		foreach($twitter_data as $tweet) {
			if (!is_array($tweet)) {
				continue;
			}

			// check the # of items
			if( $i >= $num_tweets ){
				break;
			}

			$msg = ( isset($tweet['text']) ) ? $tweet['text'] : '';

			// recover the original tweet used in retweets
			if( !isset($tweet['retweeted_status']) ) {
				$tweet['retweeted_status'] = array();
			}

			if( count($tweet['retweeted_status']) > 0 ) {
				$msg = 'RT @'.$tweet['retweeted_status']['user']['screen_name'].': '.$tweet['retweeted_status']['text'];

				if( $options['thumbnail_retweets'] ) {
					$tweet = $tweet['retweeted_status'];
				}
			}

			if( '' === $msg ) {
				continue;
			}

			if($options['encode_utf8']) {
				$msg = utf8_encode($msg);
			}


			// if we're showing links in the tweet
			if ($options['links_in_tweet']) {

				// match protocol://address/path/file.extension?some=variable&another=asf%
				$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);

				// match www.something.domain/path/file.extension?some=variable&another=asf%
				$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);

				// match name@address
				$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);

				// match #trendingtopics ( https://twitter.com/hashtag/FREE?src=hash )
				$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/hashtag/\2?src=hash" class="twitter-link" '.$link_target.'>#\2</a>', $msg);
			}

			// Find Replies in Tweets
			if( $options['twitter_users']) {
				$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$link_target.">@$2</a>$3 ", $msg);
			}

			$out .= '<div class="tweet"><p>';

			if( $options['thumbnail'] && '' !== $tweet['user']['profile_image_url_https'] ) {
				$out .= '<img src="'.$tweet['user']['profile_image_url_https'].'" />';
			}
			$out .= $msg . '</p>';

			// show timestamp of tweet
			if($options['show_timestamp']) {
				$time_string = $this->get_time_string( $tweet['created_at'], $options['date_format'] );

				if ($options['created_link']) {
					$status_link = 'http://twitter.com/'.$options['username'].'/status/'.$tweet['id_str'];
					$time_string = '<a href="'.$status_link.'" '.$link_target.' class="status-link">'. $time_string . '</a>';
				}

				$out .= $time_string;
			}

			$out .= '</div><!-- /.tweet -->';

			$i++;
		}

		return $out;
	}


	/**
	 * Get human-readable timestamp
	 *
	 * Display "yesterday", "today", or date
	 *
	 * @param string $created_at UTC timestamp of tweet creation
	 */
	protected function get_time_string( $created_at, $date_format = 'n/j/y' )
	{
		// Tweet creation
		$tweet_time = new DateTime($created_at);
		$tweet_time->setTimezone(new DateTimeZone('America/Chicago'));
		$tweet_time_formatted = $tweet_time->format($date_format);

		// Today's date
		$today = new DateTime();
		$today->setTimezone(new DateTimeZone('America/Chicago'));
		$today_formatted = $today->format($date_format);

		// Yesterday
		$yesterday = clone $today;
		$yesterday->modify('-1 day');
		$yesteday_formatted = $yesterday->format($date_format);

		// Time string
		$time_string = $tweet_time_formatted;
		if( $tweet_time_formatted === $today_formatted ){
			$time_string = 'Today';
		}
		if( $tweet_time_formatted === $yesteday_formatted ){
			$time_string = 'Yesterday';
		}

		return $time_string;

	}

} // class SimpleTweets


// Get Simple Tweet feed
function get_simple_tweets() {

	$st = new Simple_Tweets();

	return $st->get_tweets();
}