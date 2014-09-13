<?php
/**
 * Homepage Featured Content
 *
 * Allows author to mark post as featured for a rotator on t he homepage.
 *
 */

class MetaBox_FeaturedEvents {

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
		add_action( 'add_meta_boxes', array($this,'create_metabox') );
		add_action( 'save_post',      array($this,'save_meta'), 0, 3 );
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
		$basename = 'show-featured-events';
		$post_type_name = 'post';
		
		$post_types = get_post_types();
		$post_type = get_post_type();
		
		if( $post_type ){
			$post_type_name = strtolower( get_post_type_object( $post_type )->labels->singular_name );
		}	
		
		$meta_fields = array(
			'feat_events_include' => array(
				'name' => 'feat_events_include',
				'type' => 'checkbox',
				'default' => '',
				'title' => sprintf( __( 'Check here to include <strong>featured</strong> events in this %s.', 'navypier' ), $post_type_name ),
				'description' => __('')				
			),	
			'feat_eventbox_title' => array(
				'name' => 'feat_eventbox_title',
				'type' => 'text',
				'default' => 'Featured Events',
				'title' => __('Event Box Title'),
				'description' => __('Enter an optional title.')				
			),
			'feat_events_number' => array(
				'name' => 'feat_events_number',
				'type' => 'text',
				'default' => '3',
				'title' => __('Number of Events'),
				'description' => __('Enter the number of featured events to display. Enter "all" to display all.')				
			)			
		);		
			
		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Include Featured Events' ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'When checked, this %s will show a list of upcoming featured events.', 'navypier' ), $post_type_name ),
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
		if( false === $this->show_in_posttype(get_post_type()) ){
			return;
		};
		
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
	protected function show_in_posttype( $post_type)
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
		
		$output = '<p>' . $meta_box_description . '</p>';
		foreach( $meta_fields as $meta_field ) {
			
			$meta_field_value = get_post_meta($post->ID, '_'.$meta_field['name'], true);
			
			if( '' === $meta_field_value ) {
				$meta_field_value = $meta_field['default'];
			}

			wp_nonce_field( plugin_basename(__CLASS__), $meta_field['name'].'_noncename' );
			
			if ( 'feat_events_include' === $meta_field['name']) {			
				$checked = ('feat_events_include_y' === $meta_field_value) ? ' checked="checked"' : ' ' ;
				$output .= '<p><label for="'.$meta_field['name'].'">';
				$output .= '<input class="checkbox" type="checkbox" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="feat_events_include_y"' . $checked . '/> <span class="desc">'.$meta_field['title'].'</span></label></p>';			
			}	
			
			if ( 'feat_eventbox_title' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
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
		
		if( false === $this->show_in_posttype( $post->post_type ) ){
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
  
  

/**
 * Check if post has a promotion attached
 *
 * @since 1.0
 *
 * @param int $post_id Optional. Post ID.
 * @return bool Whether post has a promotion attached
 */
function mbp_has_feat_events( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	return (bool) get_post_meta( $post_id, '_feat_events_include', true );
}


$MetaBox_FeaturedEvents = new MetaBox_FeaturedEvents();