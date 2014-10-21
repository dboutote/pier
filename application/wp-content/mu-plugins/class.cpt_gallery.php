<?php
/**
 * No direct access
 */
defined( 'ABSPATH' ) or die( 'Nothing here!' );

class CPT_Galleries
{
	private $meta_config_args;
	const POST_TYPE = 'cpt_gallery';


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
		add_filter( 'include_feat_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_events_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'include_promos_dont_show_list', array($this, 'check_post_type'), 0,2);
		add_filter( 'hm_rotator_exclude_meta_box', array($this, 'dont_feature'));
		add_action( 'admin_print_footer_scripts', array($this, 'add_quicktags'), 100 );
		add_filter( 'the_content',  array($this,'process_shortcodes'), 7 );
	}


	/**
	 * Preprocess shortcodes before WordPress processes the content
	 *
	 * @access  public
	 * @since   1.0
	 * @uses do_shortcode()
	 */
	function process_shortcodes($content) {
		global $shortcode_tags;

		$orig_shortcode_tags = $shortcode_tags;
		$shortcode_tags      = array();

		add_shortcode( 'np_slide', array($this, 'np_slide') );
		add_shortcode( 'np_gallery', array($this, 'np_gallery') );

		$content = do_shortcode($content);

		// Put the original shortcodes back
		$shortcode_tags = $orig_shortcode_tags;

		return $content;
	}



	/**
	 * Process the np_gallery Shortcode
	 *
	 * @access public
	 * @since 1.0
	 * @param array $atts
	 * @param string $content
	 * @uses shortcode_atts()
	 * @return string $output HTML
	 */
	public function np_gallery($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'id' => 0
		), $atts));

		if( (int)$id < 1 ) {
			return;
		}

		// get the post object for this content type
		$post_object = get_post($id);

		if( !is_null($post_object) ){
			$content .= apply_filters('the_content',$post_object->post_content);
			return '<div class="gallery clearfix">'.$content.'</div>';
		}

		return $content;

	}


	/**
	 * Process the np_slide Shortcode
	 *
	 * @access public
	 * @since 1.0
	 * @param array $atts
	 * @param string $content
	 * @uses shortcode_atts()
	 * @return string $output HTML
	 */
	public function np_slide($atts, $content = null, $code = '')
	{
		extract(shortcode_atts(array(
			'id' => '',
			'classes' => ''
		), $atts));

		$classes = ( '' !== $classes  ) ? ' class="'.$classes.'"' : '';

		$id = ( '' !== $id  ) ? ' id="'.$id.'"' : '';

		return '<div '.$id.$classes.'>'.do_shortcode($content).'</div>';
	}

	
	/**
	 * Add a button to the Text Editor
	 *
	 * @access public
	 * @since 1.0
	 */
	function add_quicktags() {
		if (wp_script_is('quicktags')){ ?>
			<script type="text/javascript" charset="utf-8">
				// <![CDATA[
				if ( typeof QTags != 'undefined' ) {
					//QTags.addButton( 'np_gallery', 'np-gallery', '[np-gallery id="" classes=""]', '[/np-gallery]', '', 'Gallery', '', '' );
					QTags.addButton( 'np_gallery', 'np-gallery-slide', '[np_slide id="" classes=""]', '[/np_slide]', '', 'Slide', '', '' );
				}
				// ]]>
			</script>
		<?php }
	}


	/**
	 * Don't show the Homepage Featured Content Meta Box
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array $dont_show The array of post types to exclude
	 */
	public function dont_feature($dont_show)
	{
		$dont_show[] = self::POST_TYPE;

		return $dont_show;
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
		$name = 'Gallery Shortcode';
		$plural     = 'Gallery Shortcodes';

		// Labels
		$labels = array(
			'name'                 => _x( $plural, 'post type general name' ),
			'singular_name'        => _x( $name, 'post type singular name' ),
			'add_new'              => _x( 'Add New', strtolower( $name ) ),
			'menu_name'            => __( 'Gallery Codes' ),
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
				'exclude_from_search'    => true,
				'show_in_nav_menus'      => false,
				//'menu_position'          => 5,
				'menu_icon'              => 'dashicons-format-gallery',
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
				'supports'               => array('title', 'editor'),
				'register_meta_box_cb'   => array(__CLASS__, 'create_metabox' ),
				'taxonomies'             => array(),
				'has_archive'            => false,
				'rewrite'                => false,
				'query_var'              => false
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
		$basename = 'galleryinfo';
		$post_type = get_post_type();
		$post_types = array(self::POST_TYPE);
		$meta_fields = array();

		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Gallery Shortcode Info', 'navypier' ),
			'meta_box_default' => '',
			'meta_box_description' => '',
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
		global $pagenow;
		$postID = ( $post && $post->ID > 0 ) ? $post->ID : 0 ;

		if('post-new.php' === $pagenow){
			$postID = 0;
		}

		$description = ( $postID > 0 ) ? __("Copy/paste this shortcode wherever you want your slider to appear." ) :  __("Your Doc Slider shortcode will appear here once you save this gallery." );

		$output = '';
		$output .= '<p>'.$description.'</p>';
		$output .= ( $postID > 0  ) ? '<input type="text" style="width:98%;" value="[np_gallery id='.$postID.']" />' : '' ;

		echo $output;

		return;

	}



}


$CPT_Galleries = new CPT_Galleries();