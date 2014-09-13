<?php
/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );


/**
 * Include Restaurants
 *
 * Allows an author to indicate if restaurants should appear on a page.
 *
 */

class MetaBox_LandingPage {

	private $meta_config_args;
	private $dont_show_in = array('cpt_promotion', 'tribe_events', 'cpt_advertisement');

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
		add_action( 'save_post_page',      array($this,'save_meta'), 0, 3 );
		add_action( 'wp_ajax_setup_type_taxonomies', array($this, 'get_type_taxonomies') );
	}
	
	
	public function get_type_taxonomies()
	{
		$raw_data = $_POST;
		$user_errors = array();
		$response = array();
		$notice = '';
		
		
		$post_types = get_post_types();		
		$selected_type = $_POST['post_type'];
		
		if( !in_array($selected_type, $post_types ) ){
			$response['code'] = '-1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}
		
		$tax_types = get_object_taxonomies($selected_type);
		
		if( empty($tax_types) ){
			$response['code'] = '-1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}
		
		$tax_terms = get_terms($tax_types, array('hide_empty'=>false));
		
		if( empty($tax_terms) ){
			$response['code'] = '-1';
			$response['notice'] = $notice;
			die(json_encode($response));
		}
			
		$notice .= '<option value="">-- '. __( 'Select Category' ).' --</option>';
		foreach($tax_terms as $term ){
			$notice .= '<option value="'.$term->taxonomy . ':' .$term->slug.'">'.$term->name.'</option>';
		}
				
		$response['code'] = '1';
		$response['notice'] = $notice;
		die(json_encode($response));
			
		debug($tax_types);
		debug($tax_terms);
		wp_die(__METHOD__);
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
		wp_register_script( 'lp_scripts', LP_JS_URL  . '/script.js', array( 'jquery' ), 1.0, true );
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
		wp_enqueue_script('lp_scripts');

		wp_localize_script(
			'lp_scripts',
			'lpJax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);

		return;
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
		$basename = 'show-restaurants';
		$post_type_name = 'post';

		$post_types = get_post_types();
		$post_type = get_post_type();

		if( $post_type ){
			$post_type_name = strtolower( get_post_type_object( $post_type )->labels->singular_name );
		}

		$meta_fields = array(
			'restaurants_include' => array(
				'name' => 'restaurants_include',
				'type' => 'checkbox',
				'default' => '',
				'title' => sprintf( __( 'Check here to include restaurants in this %s.', 'navypier' ), $post_type_name ),
				'description' => __('')
			),
			'entries_title' => array(
				'name' => 'entries_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Entries Box Title'),
				'description' => __('Enter an optional title.')
			),
			'show_type' => array(
				'name' => 'show_type',
				'type' => 'checkbox',
				'default' => '',
				'title' => __('Select Post Type'),
				'description' => __('Select which post type will appear on this page.')
			),
			'show_tax' => array(
				'name' => 'show_tax',
				'type' => 'checkbox',
				'default' => '',
				'title' => __('Select Category'),
				'description' => __('Select which category of entries will appear on this page.')
			),
			'restaurant_number' => array(
				'name' => 'restaurant_number',
				'type' => 'text',
				'default' => '3',
				'title' => __('Number of Events'),
				'description' => __('Enter the number of featured events to display. Enter "all" to display all.')
			)
		);

		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Landing Page Setting' ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'Use these settings to display a list of  entries to display on this %s.', 'navypier' ), $post_type_name ),
			'content_types' => $post_types,
			'meta_box_position' => 'side',
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
		if('page' !== get_post_type()){
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
	 * Determine if the current post type should show this meta box
	 *
	 * @access public
	 * @since 1.0
	 *
	 */
	protected function show_in_posttype( $post_type )
	{
		if( !$post_type || '' === $post_type ){
			return false;
		}

		if ( in_array( $post_type, apply_filters( 'include_feat_events_dont_show_list', $this->dont_show_in, $post_type ) ) ){
			return false;
		}

		return true;
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

		// get configuration args
		$args = $this->get_meta_box_args();
		extract($args);
		
		
		$post_types = get_post_types(array('public'=>true, '_builtin'=>false), 'objects');
		foreach ($post_types as $type ) {
			$query_var = ( ''!= $type->query_var ) ? $type->query_var : $type->name ;
			$type_array[$query_var] = $type->labels->singular_name;			
		}
	
		$output = '<p>' . $meta_box_description . '</p>';
		foreach( $meta_fields as $meta_field ) {

			$meta_field_value = get_post_meta($post->ID, '_'.$meta_field['name'], true);

			if( '' === $meta_field_value ) {
				$meta_field_value = $meta_field['default'];
			}

			wp_nonce_field( plugin_basename(__CLASS__), $meta_field['name'].'_noncename' );

			if ( 'restaurants_include' === $meta_field['name']) {
				$checked = ('feat_events_include_y' === $meta_field_value) ? ' checked="checked"' : ' ' ;
				$output .= '<p><label for="'.$meta_field['name'].'">';
				$output .= '<input class="checkbox" type="checkbox" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="feat_events_include_y"' . $checked . '/> <span class="desc">'.$meta_field['title'].'</span></label></p>';
			}

			if ( 'entries_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if( 'show_type' === $meta_field['name'] ) {
				
				// sort alphabetically
				asort($type_array);
		
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<select name="'.$meta_field['name'].'" style="width:99%;">';
				$output .= '<option value="">-- '. __( 'Select Post Type' ).' --</option>';
				foreach( $type_array as $ptype => $pname ){
					$output .= '<option id="'.$meta_field['name'].'_'.$ptype.'" class="checkbox" value="'.$ptype.'"'.selected($ptype,$meta_field_value, false ).' />'.__($pname).'</option>';
				}
				$output .= '</select>';
				$output .= $meta_field['description'].'<br /></p>';
			}

			if( 'show_tax' === $meta_field['name'] ) {
				$style = ' style="display:none;"';
				$select_options = '';
				if('' !== $meta_field_value){
					$style = '';
					$meta_tax = explode(':', $meta_field_value);
					$selected_tax = $meta_tax[0];
					$selected_term = $meta_tax[1];
					debug($selected_term);
					$tax_terms = get_terms($selected_tax, array('hide_empty'=>false));
					foreach($tax_terms as $term ){
						debug($term->slug);
						$select_options .= '<option value="'.$term->taxonomy . ':' .$term->slug.'"'.selected($term->slug,$selected_term, false ).'>'.$term->name.'</option>';
					}
				}
				$output .= '<div id="taxplaceholder"'.$style.'>';
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<select name="'.$meta_field['name'].'" style="width:99%;">';
				$output .= '<option value="">-- '. __( 'Select Category' ).' --</option>';
				$output .= $select_options;
				$output .= '</select>';
				$output .= $meta_field['description'].'<br /></p>';				
				$output .= '</div>';
			}

			if ( 'feat_events_number' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="3" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
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

		if( 'page' !== $post->post_type ){
			return $post_id;
		};

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
		$args = $this->get_meta_box_args();
		extract($args);

		foreach($meta_fields as $meta_field) {

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