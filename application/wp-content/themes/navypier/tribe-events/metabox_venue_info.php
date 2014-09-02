<?php
/**
 * Latitude/Langitude for Event Calendar
 *
 * Does not do any saving.  It adds venue[Lat] & venue[Long] to the $_POST array and lets Events Calendar
 * handle the saving.
 * 
 * Applicable action hooks aren't available to add to fields directly to the meta boxes EC creates.
 *
 */

class MetaBox_VenueInfo {

	private $meta_config_args;

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
		#add_action( 'save_post',      array($this,'save_meta'), 0, 3 );
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
		$basename = 'venue-latlong';
		$post_type_name = 'venue';
		
		$post_types = get_post_types();
		$post_type = get_post_type();
		
		if( $post_type ){
			$post_type_name = strtolower( get_post_type_object( $post_type )->labels->singular_name );
		}

		$map_icon = '<div class="dashicons dashicons-location-alt"></div> ';
		
		$lat_desc = ( $post_type && 'tribe_events' === $post_type ) 
		? 'Enter the latitude of this event\'s venue.' 
		: 'Enter the latitude of this venue.';
		
		$long_desc = ( $post_type && 'tribe_events' === $post_type ) 
		? 'Enter the longitude of this event\'s venue.' 
		: 'Enter the longitude of this venue.';	
		
		$meta_desc = ( $post_type && 'tribe_events' === $post_type ) 
		? 'Add additional information for this event\'s venue.' 
		: 'Add additional information for this venue.';	

		
		$meta_fields = array(
			'Lat' => array(
				'name' => 'Lat',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . 'Venue Latitude'),
				'description' => __( $lat_desc, 'tribe-events-calendar' )
			),
			'Long' => array(
				'name' => 'Long',
				'type' => 'text',
				'default' => '',
				'title' => __($map_icon . 'Venue Longitude'),
				'description' => __( $long_desc, 'tribe-events-calendar' )			
			)		
		);		
			
		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Additional Venue Information' ),
			'meta_box_default' => '',
			'meta_box_description' => __( $meta_desc, 'tribe-events-calendar' ),
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
			
			$meta_field_value = get_post_meta($venue_id, '_Venue'.$meta_field['name'], true);
			
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
?>