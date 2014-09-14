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

class MetaBox_VenueInfo {

	private $meta_config_args;
	const POST_TYPE = 'tribe_venue';

	/**
	 * The constructor
	 *
	 * @access  public
	 * @since   1.0
	 * @return  void
 	 */
	public function __construct()
	{
		add_action( 'add_meta_boxes', array($this,'create_metabox') );
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

		$basename = 'addlvenueinfo';
		$post_type = self::POST_TYPE;
		$post_types = array(self::POST_TYPE);

		if( $post_type ){
			$post_type_name =  get_post_type_object( $post_type )->labels->singular_name;
			$post_type_name_lower = strtolower($post_type_name);
		}

		$map_icon = '<div class="dashicons dashicons-location-alt"></div> ';
		$lat_desc = sprintf( __( 'Enter the latitude of this %s.', 'navypier' ), $post_type_name_lower );
		$long_desc = sprintf( __( 'Enter the longitude of this %s.', 'navypier' ), $post_type_name_lower );

		$meta_fields = array(
			'Lat' => array(
				'name' => 'Lat',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . ' Venue Latitude'),
				'description' => __( $lat_desc, 'navypier' )
			),
			'Long' => array(
				'name' => 'Long',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . ' Venue Longitude'),
				'description' => __( $long_desc, 'navypier' )
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
	 * Create the metabox
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @uses add_meta_box()
	 */
	public function create_metabox()
	{
		$args = self::get_meta_box_args();
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

		// get configuration args
		$args = self::get_meta_box_args();
		extract($args);

		$output = '<p>' . $meta_box_description . '</p>';
		foreach( $meta_fields as $meta_field ) {

			$meta_field_value = get_post_meta($post->ID, '_Venue'.$meta_field['name'], true);

			if( '' === $meta_field_value ) {
				$meta_field_value = $meta_field['default'];
			}

			wp_nonce_field( plugin_basename(__CLASS__), $meta_field['name'].'_noncename' );

			if ( 'Lat' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="venue['.$meta_field['name'].']" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

			if ( 'Long' === $meta_field['name']) {
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="venue['.$meta_field['name'].']" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';
			}

		}

		echo $output;

		return;

	}


}


$MetaBox_VenueInfo = new MetaBox_VenueInfo();