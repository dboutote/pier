<?php
/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );

/**
 * Team Profiles
 *
 * Create a Team page in WordPress using custom post types, taxonomies
 *
 * @package WordPress
 * @author	darrinb
 * @since	1.0
 *
 */
if ( !class_exists('DBDB_ContactForm') ):

class DBDB_ContactForm
{

	/**
	 * The constructor
	 *
	 * Initialize & hook into WP
	 *
	 * @access  public
	 * @since   1.0
	 * @return  void
 	 */
	public function __construct()
	{
		add_action( 'init', array($this, 'register_scripts') );
		add_action( 'wp_enqueue_scripts', array($this, 'add_scripts_frontend'), 101 );
		add_shortcode( 'db_contact_form', array($this, 'get_contact_form') );
		add_action( 'wp_ajax_setup_pub_contact', array($this, 'process_contact_form_jax') );
		add_action( 'wp_ajax_nopriv_setup_pub_contact', array($this, 'process_contact_form_jax') );
	}


	/**
	 * Register scripts in the front end
	 *
	 * @access  public
	 * @since   1.0
	 * @uses wp_register_script()
	 * @return  void
	 */
	public static function register_scripts()
	{
		wp_register_script( 'jquery.validate', CF_JS_URL  . '/jquery.validate.min.js', array( 'jquery' ), '1.11.1', true );
		wp_register_script( 'jquery.validate-additional', CF_JS_URL  . '/additional-methods.min.js', array( 'jquery', 'jquery.validate' ), '1.11.1', true );
		wp_register_script( 'jquery.inputmask', CF_JS_URL  . '/jquery.inputmask.bundle.min.js', array( 'jquery' ), '2.5.0',  true );
		wp_register_script( 'cform_scripts', CF_JS_URL  . '/script.js', array( 'jquery', 'jquery.validate','jquery.validate-additional', 'jquery-ui-position',  ), 1.0, true );
	}


	/**
	 * Load scripts in the front end
	 *
	 * @access  public
	 * @since   1.0
	 * @uses wp_enqueue_script()
	 * @uses wp_localize_script()
	 */
	public static function add_scripts_frontend()
	{
		wp_enqueue_script('cform_scripts');

		wp_localize_script(
			'cform_scripts',
			'cformJax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);

		return;
	}


	/**
	 * Process the form with AJAX
	 *
	 * @access public
	 * @since 1.0
	  * @param boolean $ajax
	  * @uses process_contact_form()
	 */
	public function process_contact_form_jax()
	{
		$this->process_contact_form($ajax = true);
	}

	/**
	 * Handle Processing of the Contact Form
	 *
	 * @access private
	 * @since 1.0
	 * @param boolean $ajax
	 * @return object  $response
	 */
	private function process_contact_form($ajax = false)
	{
		$raw_data = $_POST;
		$user_errors = array();
		$response = array();
		$notice = '';

		// sanitize the data
		$data = $this->sanitize_data_array($raw_data);

		// if a bot field is filled in, just return
		if('' !== $data['pctob'] ){ return; }

		// check all required fields
		$required_fields = array(
			'pcname' => __("Please enter a name 2"),
			'pcemail' => __("Please enter an email address"),
			'pcmessage' => __("Please enter a message")
		);

		$user_errors = $this->check_required_fields($required_fields, $data);

		extract($data);

		// check if the email address is valid
		if( empty($user_errors) ) {
			if ( !is_email($pcemail) )  {
				$user_errors['bad_email'] = __('Hmm, that email doesn\'t look right.');
			}
		}

		// if there are user errors
		if( !empty($user_errors) ){
			$error_notices = '';
			foreach( $user_errors as $k => $v ) {
				$error_notices .= $v . '<br />';
			}
			$notice = $error_notices;
			$response['code'] = '-1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}

		// if there are no user errors
		if( empty($user_errors) ){
			// send message to admin
			$this->send_note($data);
			$notice = 'Thank you for your note!';
			$response['code'] = '1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}


		die('0');

		return;

	}


	/**
	 * Notify Site Admin
	 *
	 * Sends an email to the designated admin email
	 *
	 * @access protected
	 * @since 1.0
	 *
	 * @param array $args
	 */
	protected function send_note($args)
	{
		$defaults = array(
			'pcname' => '',
			'pcemail' => '',
			'pcmessage' => '',
			'to' => get_option('admin_email'),
			'subject' => 'New note from ' . get_bloginfo('name'),
			'message' => ''
		);

		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );

		$message = $pcmessage;

		if( '' !== $message ) {
			return @wp_mail( $to, $subject, $message );
		}
	}


	/**
	 * Retrieve the Contact Form
	 *
	 * @access public
	 * @since 1.0
	 *
	 */
	public function get_contact_form()
	{
		ob_start();

		global $post;
		$action_link = get_permalink($post->ID) . '#abtcontact';

		include CF_TPL_DIR . '/tpl_contactform.php';

		// Save output
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}


	/**
	 * Clean/sanitize data arrays
	 *
	 * Strips HTML, whitespace
	 * @access public
	 * @since 1.0
	 * @param string|array $submited_data
	 * @uses wp_kses()
	 * @return string|array $submited_data
	 */
	public static function sanitize_data_array($submited_data)
	{
		$in = array(&$submited_data);
		while ( list($k,$v) = each($in) ) {
			foreach ( $v as $key => $val ) {
				if ( !is_array($val) ) {
					$in[$k][$key] = trim(stripslashes($val));
					$in[$k][$key] = wp_kses($in[$k][$key], $allowed_html=array());
					$in[$k][$key] = esc_attr($in[$k][$key]);
					$in[$k][$key] = trim($in[$k][$key]);

					continue;
				};
				if ( is_array($val) ) {
					$in[$k][$key] = array_filter($val);
				};
				$in[] =& $in[$k][$key];
			};
		};

		unset($in);
		return $submited_data;
	}


	/**
	 * Checks an array of input values against an array of required values
	 *
	 * @access public
	 * @since 1.0
	 * returns array $errors
	 */
	public static function check_required_fields($required_fields='', $data='')
	{
		$errors = array();
		if(!$required_fields)
			$errors['required_fields'] = 'required fields not provided';

		if(!$data)
			$errors['data'] = 'data values not provided';

		// compare required with actual keys
		foreach ($required_fields as $k => $v) {
			if( !isset($data[$k]) || '' === $data[$k]  ) {
				$errors[$k] = __( $v );
			}
		};

		return $errors;
	}


	/**
	 * Grab the $_GET or $_POST parameter
	 *
	 * @access public
	 * @since 1.0
	 * @param string $param
	 * @param string $default
	 * @return string $param || $default
	 */
	public static function get_param($param, $default= '')
	{
		return (isset($_POST[$param])?$_POST[$param]:(isset($_GET[$param])?$_GET[$param]:$default));
	}


}

endif;