<?php
/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );

class CPT_Shops
{
	private $meta_config_args;
	const POST_TYPE = 'cpt_shop';


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
		add_action( 'init', array($this, 'register_taxonomy'), 999 );
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
		$name = 'Shop';
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
				'menu_icon'              => 'dashicons-cart',
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
				'rewrite'                => array('slug' => 'shops', 'with_front' => false)
			)
		);
	}


	/**
	 * Register Taxonomy
	 */
	public function register_taxonomy()
	{

		$name = 'Shop Category';
		$plural	= 'Shop Categories';

		register_taxonomy(
			'shop_category',    // Name of taxonomoy
			self::POST_TYPE,          // Applies to these post types
			array(
				'label'                         => _x( $plural, 'taxonomy general name' ),			// A descriptive name for the taxonomy (marked for translation.)
				'labels'                        => array(
					'name'                          => _x( $plural, 'taxonomy general name' ),		// The plural form of the name of your taxonomoy shows
					'singular_name'                 => _x( $name, 'taxonomy general name' ),        // The singular form of the name of your taxonomoy
					'menu_name'                     => __( $plural),                           		// the menu name text. This string is the name to give menu items. Defaults to value of name
					'all_items'                     => __( 'All ' . $plural ),                   	// the all items text. Default is __( 'All Tags' ) or __( 'All Categories' )
					'edit_item'                     => __( 'Edit ' . $name ),                   	// the edit item text. Default is __( 'Edit Tag' ) or __( 'Edit Category' )
					'view_item'                     => __( 'View ' . $name ),                   	// the view item text. Default is __( 'Edit Tag' ) or __( 'Edit Category' )
					'update_item'                   => __( 'Update ' . $name ),                     // the update item text. Default is __( 'Update Tag' ) or __( 'Update Category' )
					'add_new_item'                  => __( 'Add New '. $name ),                   	// the add new item text. Default is __( 'Add New Tag' ) or __( 'Add New Category' )
					'new_item_name'                 => __( 'New ' . $name ),                    	// the new item name text. Default is __( 'New Tag Name' ) or __( 'New Category Name' )
					'parent_item'                   => __( 'Parent ' . $name ),                     // the parent item text. This string is not used on non-hierarchical taxonomies such as post tags. Default is null or __( 'Parent Category' )
					'parent_item_colon'             => __( 'Parent ' . $name.':' ),                 // The same as parent_item, but with colon : in the end null, __( 'Parent Category:' )
					'search_items'                  => __( 'Parent ' . $plural ),                	// The search items text. Default is __( 'Search Tags' ) or __( 'Search Categories' )
					#'popular_items'               => __( 'Popular Tags' ),                   		// the popular items text. Default is __( 'Popular Tags' ) or null
					#'separate_items_with_commas'  => __( 'Separate tags with commas' ),      		// the separate item with commas text used in the taxonomy meta box. Default is __( 'Separate tags with commas' ), or null
					#'add_or_remove_items'         => __( 'Add or remove tags' ),              		// the add or remove items text and used in the meta box when JavaScript is disabled. This string isn't used on hierarchical taxonomies. Default is __( 'Add or remove tags' ) or null
					#'choose_from_most_used'       => __( 'Choose from the most used tags' ),  		// the choose from most used text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies. Default is __( 'Choose from the most used tags' ) or null
					#'not_found'                   => __('menuname')                           		// When no tags are found
				),
				'public'                        => true,                                        	// Should this taxonomy be exposed in the admin UI.
				'show_ui'                       => true,                                       		// Whether to generate a default UI for managing this taxonomy. Default: if not set, defaults to value of public argument
				'show_in_nav_menus'             => true,                                       	// should taxonomy be available for selection in navigation menus. Default: if not set, defaults to value of public argument
				'show_tagcloud'                 => false,                                       	// Wether to allow the Tag Cloud widget to use this taxonomy. Default: if not set, defaults to value of show_ui argument
				#'meta_box_cb'                   => null,                                        	// Provide a callback function name for the meta box display
				#'show_admin_column'             => false,                                       	// Whether to allow automatic creation of taxonomy columns on associated post-types table
				'hierarchical'                  => true,                                        	// Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.
				//'update_count_callback'       => null,
				'rewrite'                       => array(                                       	// Set to false to prevent rewrite, or array to customize customize query var.
					'slug'                          => '',                              		// prepend posts with this slug - defaults to taxonomy's name
					'with_front'                    => false                                    	// Whether your taxonomy should use the front base from your permalink settings
				),
				'query_var'                     => true                                         	// False to prevent queries, or string to customize query var. Default will use $taxonomy as query var
			)
		);
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
		$basename = 'shopinfo';
		$post_type = get_post_type();
		$post_types = array(self::POST_TYPE);

		if( $post_type ){
			$post_type_name =  get_post_type_object( $post_type )->labels->singular_name;
			$post_type_name_lower = strtolower($post_type_name);
		}

		$map_icon = '<div class="dashicons dashicons-location-alt"></div> ';
		$lat_desc = sprintf( __( 'Enter the latitude of this %s.', 'navypier' ), $post_type_name_lower );
		$long_desc = sprintf( __( 'Enter the longitude of this %s.', 'navypier' ), $post_type_name_lower );

		$meta_fields = array(
			'menu_order' => array(
				'name' => 'menu_order',
				'type' => 'text',
				'default' => '0',
				'title' => __('Menu Order'),
				'description' => __( '', 'navypier' )
			),
			'alt_title' => array(
				'name' => 'alt_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Alternate Title'),
				'description' => __( 'Enter an optional short title.', 'navypier' )
			),
			'sub_title' => array(
				'name' => 'sub_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Sub Title'),
				'description' => __('Enter an optional sub title.')
			),
			'deal_title' => array(
				'name' => 'deal_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Deal Title'),
				'description' => __('Enter the link text for the deal url. (e.g., "Get Deal").')
			),
			'deal_url' => array(
				'name' => 'deal_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Deal URL'),
				'description' => __('Enter the url for a special deal (if applicable).')
			),
			'tix_title' => array(
				'name' => 'tix_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Tickets Title'),
				'description' => __('Enter the link text for the deal url. (e.g., "Buy Tickets").')
			),
			'tix_url' => array(
				'name' => 'tix_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Tickets URL'),
				'description' => __('Enter the url to purchase tickets (if applicable).')
			),
			'website_title' => array(
				'name' => 'website_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Website Title'),
				'description' => __('Enter the link text for the website url. (e.g., "Website").')
			),
			'website_url' => array(
				'name' => 'website_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Website URL'),
				'description' => __('Enter the url for the website (if applicable).')
			),
			'phone_title' => array(
				'name' => 'phone_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Phone Title'),
				'description' => __('Enter the link text for the phone number. (e.g., "Call Us!").')
			),
			'phone_url' => array(
				'name' => 'phone_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Phone URL'),
				'description' => __('Enter the number/url for the phone (if applicable).')
			),
			'document_title' => array(
				'name' => 'document_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Document Title'),
				'description' => __('Enter the link text for the downloadable document. (e.g., "Download Menu").')
			),
			'document_url' => array(
				'name' => 'document_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Document URL'),
				'description' => __('Enter the url for the download (if applicable).')
			),
			'location_title' => array(
				'name' => 'location_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Location Title'),
				'description' => __('Enter the link text for the location url. (e.g., "Map It").')
			),
			'latitude' => array(
				'name' => 'latitude',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . ' ' . $post_type_name .' Latitude'),
				'description' => __( $lat_desc, 'navypier' )
			),
			'longitude' => array(
				'name' => 'longitude',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . ' ' . $post_type_name .' Longitude'),
				'description' => __( $long_desc, 'navypier' )
			),
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

			if ( 'menu_order' === $meta_field['name']) {
				$meta_field_value = $post->menu_order;
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="4" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'alt_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'sub_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'deal_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'deal_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'website_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'website_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'phone_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'phone_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'document_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'document_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'tix_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'tix_url' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'location_title' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'latitude' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'longitude' === $meta_field['name']) {
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

}

$CPT_Shops = new CPT_Shops();