<?php
/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );

class CPT_Adverts
{
	private $meta_config_args;
	const POST_TYPE = 'cpt_advertisement';


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
		add_action( 'init', array($this, 'register_post_type'), 0 );
		add_action( 'save_post_'.self::POST_TYPE, array($this,'save_meta'), 0, 3 );
		add_filter( 'include_feat_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_promos_dont_show_list', array($this, 'check_post_type'), 0,2);
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
	 * Register post type
	 */
	public static function register_post_type()
	{
		$name = 'Advertisement';
		$plural     = $name . 's';

		// Labels
		$labels = array(
			'name'                 => _x( $plural, 'post type general name' ),
			'singular_name'        => _x( $name, 'post type singular name' ),
			'add_new'              => _x( 'Add New', strtolower( $name ) ),
			'menu_name'            => __( $plural ),
			'add_new_item'         => __( 'Add New ' . $name ),
			'edit_item'            => __( 'Edit ' . $name ),
			'new_item'             => __( 'New ' . $name ),
			'all_items'            => __( 'All ' . $plural ),
			'view_item'            => __( 'View ' . $name ),
			'search_items'         => __( 'Search ' . $plural ),
			'not_found'            => __( 'No ' . strtolower( $plural ) . ' found'),
			'not_found_in_trash'   => __( 'No ' . strtolower( $plural ) . ' found in Trash'),
		);

		// Register post type
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'                 => $labels,
				'public'                 => true,
				'exclude_from_search'    => false,
				'show_in_nav_menus'      => false,
				'menu_position'          => 20,
				'menu_icon'              => 'dashicons-awards',
				'capability_type'        => 'post',
				'capabilities'           => array(
					'edit_post'              => 'manage_categories',
					'edit_posts'             => 'manage_categories',
					'edit_others_posts'      => 'manage_categories',
					'publish_posts'          => 'manage_categories',
					'read_private_posts'     => 'manage_categories',
					'delete_post'            => 'manage_categories',
					'read_post'              => 'manage_categories'
				),
				'supports'               => array('title', 'editor', 'thumbnail', 'excerpt'),
				'register_meta_box_cb'   => array(__CLASS__, 'create_metabox' ),
				'taxonomies'             => array(),
				'has_archive'            => false,
				'rewrite'                => array('slug' => 'advertisements', 'with_front' => false)
			)
		);
	}


	/**
	 * Create the metabox
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @uses add_meta_box()
	 */
	public static function create_metabox()
	{
		$args = self::get_meta_box_args();
		extract($args);

		if ( function_exists('add_meta_box') ) {
			foreach ($content_types as $content_type) {
				add_meta_box($meta_box_id, $meta_box_title, array(__CLASS__, 'inner_metabox'), $content_type, $meta_box_position );
			}
		}
	}


	/**
	 * Configuration params for the Metabox
	 *
	 * @since 1.0
	 * @access protected
	 *
	 */
	protected static function get_meta_box_args()
	{
		return self::set_meta_box_args();
	}


	/**
	 * Configuration params for the Metabox
	 *
	 * @access protected
	 * @since 1.0
	 *
	 */
	protected static function set_meta_box_args()
	{
		$basename = 'advertisementinfo';
		$post_type = get_post_type();
		$post_types = array(self::POST_TYPE);
		$post_type_name = 'post';

		if( $post_type ){
			$post_type_name =  get_post_type_object( $post_type )->labels->singular_name;
			$post_type_name_lower = strtolower($post_type_name);
		}

		$meta_fields = array(
			'advertisement_url' => array(
				'name' => 'advertisement_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Ad URL'),
				'description' => __('Add an optional link for this ad. If left blank, just the ad\'s image will appear.')
			)
		);

		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => sprintf( __( 'Additional %s Info', 'navypier' ), $post_type_name ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'Use these settings to add additional info for this %s.', 'navypier' ), $post_type_name, $post_type_name ),
			'content_types' => $post_types,
			'meta_box_position' => 'side',
			'meta_box_priority' => 'high',
			'meta_fields' => $meta_fields
		);

		return $args;
	}


	/**
	 * Print the inner HTML of the metabox
	 *
	 * @access public
	 * @since 1.0
	 *
	 */
	public static function inner_metabox()
	{

		global $post;

		// get configuration args
		$args = self::get_meta_box_args();
		extract($args);

		$output = '<p>' . $meta_box_description . '</p>';
		foreach( $meta_fields as $meta_field ) {

			$meta_field_value = get_post_meta($post->ID, '_'.$meta_field['name'], true);

			if( '' === $meta_field_value ) {
				$meta_field_value = $meta_field['default'];
			}

			wp_nonce_field( plugin_basename(__CLASS__), $meta_field['name'].'_noncename' );

			if ( 'advertisement_include' === $meta_field['name']) {
				$checked = ('advertisement_include_y' === $meta_field_value) ? ' checked="checked"' : ' ' ;
				$output .= '<p><label for="'.$meta_field['name'].'">';
				$output .= '<input class="checkbox" type="checkbox" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="advertisement_include_y"' . $checked . '/> <span class="desc">'.$meta_field['title'].'</span></label></p>';
			}

			if ( 'advertisement_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value=\''.$meta_field_value.'\' size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
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

			// let WP save menu_order in $wpdb->posts table, not meta
			if ( 'menu_order' === $meta_field['name']) {
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




	/**
	 * Get ads to display
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 *
	 * @return object WP_Query object
	 */
	public static function get_ads($numads = 3, $orderby = 'rand')
	{

		$out = '';
		$args = array(
			'posts_per_page' => $numads,
			'post_type' => 'cpt_advertisement',
			'orderby' => $orderby
		);

		$r = new WP_Query($args);

		if( $r->have_posts() ) :

			while ( $r->have_posts() ) : $r->the_post();
				$ad_url = get_post_meta(get_the_ID(), '_advertisement_url', true);
				$image_obj = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
				if($image_obj){
					$img_src = $image_obj[0];
				} else {
					$img_src = get_stylesheet_directory_uri() . '/images/ad_placeholder.jpg';
				}
				$out .= '<div class="col">';
				$out .= '<a href="'.$ad_url.'">';
				$out .= '<img src="'.$img_src.'" width="480" height="220" />';
				$out .= '</a>';
				$out .= '</div>';
			endwhile;

		else:

		endif;

		wp_reset_postdata();

		return $out;

	}


}


$cpt_adverts = new CPT_Adverts();