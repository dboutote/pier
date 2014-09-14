<?php
/**
 * Additional Information for Venues - A tie-in for Events Calendar
 *
 * Does not do any saving of Lat/Long.  It adds venue[Lat] & venue[Long] to the $_POST array and lets Events Calendar
 * handle the saving.
 *
 * Applicable action hooks aren't available to add to fields directly to the meta boxes EC creates.
 *
 */

class MetaBox_EventInfo {

	private $meta_config_args;
	const POST_TYPE = 'tribe_events';

	/**
	 * The constructor
	 *
	 * @access  public
	 * @since   1.0
	 * @return  void
 	 */
	public function __construct()
	{
		add_action( 'init', array($this, 'register_scripts') );
		add_action( 'admin_enqueue_scripts', array($this, 'add_scripts_backend'), 101 );
		
		add_action( 'add_meta_boxes', array($this,'create_metabox') );
		add_action( 'save_post_'.self::POST_TYPE, array($this,'save_meta'), 0, 3 );
		add_filter( 'include_feat_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_promos_dont_show_list', array($this, 'check_post_type'), 0,2);	
		add_action( 'wp_ajax_setup_venue_info', array($this, 'get_venue_info') );		
	}
	
	
	/**
	 * Get Venue Meta Info 
	 */
	 
	 public function get_venue_info()
	 {
		$raw_data = $_POST;
		$user_errors = array();
		$response = array();
		$notice = '';
		
		$venue_id = absint($_POST['post_id']);
		if( !$venue_id || $venue_id < 1 ){
			$response['code'] = '-1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}
		
		$venue_meta = get_post_custom($venue_id);
		$_VenueLat = ( isset($venue_meta['_VenueLat'][0]) && '' !== $venue_meta['_VenueLat'][0]) ? $venue_meta['_VenueLat'][0] : '';
		$_VenueLong = ( isset($venue_meta['_VenueLong'][0]) && '' !== $venue_meta['_VenueLong'][0]) ? $venue_meta['_VenueLong'][0] : '';
		
		$response['code'] = '1';
		$response['notice'] = $notice;
		$response['_VenueLat'] = $_VenueLat;
		$response['_VenueLong'] = $_VenueLong;
		die(json_encode($response));
		
	 }
	
	/**
	 * Register scripts in the backend
	 *
	 * @access  public
	 * @since   1.0
	 * @uses wp_register_script()
	 * @return  void
	 */
	public static function register_scripts()
	{
		wp_register_script( 'npem_scripts', NPEM_JS_URL  . '/script.js', array( 'jquery' ), 1.0, true );
	}

	
	/**
	 * Load scripts in the backend
	 *
	 * @access  public
	 * @since   1.0
	 * @uses wp_enqueue_script()
	 * @uses wp_localize_script()
	 */
	public static function add_scripts_backend($hook)
	{
		wp_enqueue_script('npem_scripts');

		wp_localize_script(
			'npem_scripts',
			'npem_scriptsJax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);

		return;
	}	
	
	/**
	 * Remove this post type from the Events meta box
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array $dont_show The array of post types to exclude
	 * @param string $post_type The post type to check against the $dont_show array
	 */
	public function check_post_type($dont_show, $post_type)
	{
		$dont_show[] = self::POST_TYPE;
		return $dont_show;
	}
	

	/**
	 * Configuration params for the Metabox
	 *
	 * @since 1.0
	 * @access protected
	 *
	 */
	protected function get_meta_box_args()
	{
		return $this->set_meta_box_args();
	}


	/**
	 * Configuration params for the Metabox
	 *
	 * @access protected
	 * @since 1.0
	 *
	 */
	protected function set_meta_box_args()
	{

		$basename = 'addleventinfo';
		$post_type = self::POST_TYPE;
		$post_types = array(self::POST_TYPE);

		if( $post_type ){
			$post_type_name =  get_post_type_object( $post_type )->labels->singular_name;
			$post_type_name_lower = strtolower($post_type_name);
		}
		
		$lat_desc = sprintf( __( 'Enter the latitude of this %s venue.', 'navypier' ), $post_type_name_lower );
		$long_desc = sprintf( __( 'Enter the longitude of this %s venue.', 'navypier' ), $post_type_name_lower );

		$meta_fields = array(
			'Lat' => array(
				'name' => 'Lat',
				'type' => 'text',
				'default' => '',
				'title' => __( 'Venue Latitude'),
				'description' => __( $lat_desc, 'navypier' )
			),
			'Long' => array(
				'name' => 'Long',
				'type' => 'text',
				'default' => '',
				'title' => __( 'Venue Longitude'),
				'description' => __( $long_desc, 'navypier' )
			),
			'tix_title' => array(
				'name' => 'tix_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Tickets Title'),
				'description' => __('Enter the link text for the tickets url. (e.g., "Buy Tickets").')
			),
			'tix_url' => array(
				'name' => 'tix_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Tickets URL'),
				'description' => __('Enter the url to purchase tickets (if applicable).')
			),
		);

		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => sprintf( __( 'Additional %s Info', 'navypier' ), $post_type_name ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'Use these settings to add additional info for this %s.', 'navypier' ), $post_type_name, $post_type_name ),
			'content_types' => $post_types,
			'meta_box_position' => 'advanced',
			'meta_box_priority' => 'high',
			'meta_fields' => $meta_fields
		);

		return $args;
	}


	/**
	 * Create the metabox
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @uses add_meta_box()
	 */
	public function create_metabox()
	{
		$post_type = get_post_type();
		$allowed_post_types = array('tribe_events', 'tribe_venue');

		if( !in_array($post_type, $allowed_post_types ) ){
			return;
		}

		$args = $this->get_meta_box_args();
		extract($args);

		if ( function_exists('add_meta_box') ) {
			foreach ($content_types as $content_type) {
				add_meta_box($meta_box_id, $meta_box_title, array($this, 'inner_metabox'), $content_type, $meta_box_position );
			}
		}
	}


	/**
	 * Print the inner HTML of the metabox
	 *
	 * @access public
	 * @since 1.0
	 *
	 */
	public function inner_metabox()
	{
		global $post;

		if('tribe_venue' === $post->post_type){
			$venue_id = $post->ID;
		} else {
			$venue_id = get_post_meta( $post->ID, '_EventVenueID', true );
		}

		// get configuration args
		$args = $this->get_meta_box_args();
		extract($args);

		$output = '<p>' . $meta_box_description . '</p>';
		
		foreach( $meta_fields as $meta_field ) {

			$meta_field_value = get_post_meta($post->ID, '_'.$meta_field['name'], true);

			if( '' === $meta_field_value ) {
				$meta_field_value = $meta_field['default'];
			}

			wp_nonce_field( plugin_basename(__CLASS__), $meta_field['name'].'_noncename' );

			if ( 'Lat' === $meta_field['name']) {
				$meta_field_value = get_post_meta($venue_id, '_Venue'.$meta_field['name'], true);

				if( '' === $meta_field_value ) {
					$meta_field_value = $meta_field['default'];
				}

				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="venue['.$meta_field['name'].']" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'Long' === $meta_field['name']) {
				$meta_field_value = get_post_meta($venue_id, '_Venue'.$meta_field['name'], true);

				if( '' === $meta_field_value ) {
					$meta_field_value = $meta_field['default'];
				}

				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="venue['.$meta_field['name'].']" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			// only show this for tribe_events post-type
			if ( 'tix_title' === $meta_field['name'] && 'tribe_events' === $post->post_type ) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			// only show this for tribe_events post-type
			if ( 'tix_url' === $meta_field['name'] && 'tribe_events' === $post->post_type ) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}


		}

		echo $output;

		return;

	}


	/**
	 * Process saving the metadata
	 *
	 * @access public
	 * @since 1.0
	 *
	 */
	 public function save_meta($post_id, $post, $update)
	 {

		// if there's no $post object it's a new post
		if( !$post && $post_id > 0 ) {
			$post = get_post($post_id);
		}

		if(!$post) {
			return $post_id;
		}

		if( 'auto-draft' === $post->post_status ){
			return $post_id;
		}

		// skip auto-running jobs
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if ( defined('DOING_AJAX') && DOING_AJAX ) return;
		if ( defined('DOING_CRON') && DOING_CRON ) return;

		// Don't save if the post is only an auto-revision.
		if ( 'revision' == $post->post_type ) {
			return $post_id;
		}

		// Get the post type object & check if the current user has permission to edit the entry.
		$post_type = get_post_type_object( $post->post_type );

		if ( $post_type && !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		// get configuration args
		$args = self::get_meta_box_args();
		extract($args);

		foreach($meta_fields as $meta_field) {

			if ( 'Lat' === $meta_field['name'] || 'Long' === $meta_field['name'] ) {
				continue;
			}

			// verify this came from the our screen and with proper authorization, (b/c save_post can be triggered at other times)
			if( !isset($_POST[$meta_field['name'].'_noncename']) || !wp_verify_nonce( $_POST[$meta_field['name'].'_noncename'], __CLASS__ ) ) {
				return $post_id;
			}

			// Ok, we're authenticated: we need to find and save the data
			$data = ( isset($_POST[$meta_field['name']]) ) ? $_POST[$meta_field['name']] : '';
			$data = ( is_array($data) ) ? array_filter($data) : trim($data);

			if ( '' != $data && '-1' != $data  ) {
				update_post_meta( $post->ID, '_'.$meta_field['name'], $data );
			} else {
				delete_post_meta( $post->ID, '_'.$meta_field['name'] );
			}

		}

		return $post_id;

	 }



}
