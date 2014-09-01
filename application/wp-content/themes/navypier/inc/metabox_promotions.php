<?php
/**
 * Homepage Featured Content
 *
 * Allows author to mark post as featured for a rotator on t he homepage.
 *
 */

class MetaBox_Promotion {

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
		$basename = 'show-promotion';
		$post_types = get_post_types();
		$post_type = get_post_type();
		$post_type_name = strtolower( get_post_type_object( $post_type )->labels->singular_name );		
		
		$meta_fields = array(
			'promotion_include' => array(
				'name' => 'promotion_include',
				'type' => 'checkbox',
				'default' => '',
				'title' => sprintf( __( 'Check here to include a promotion in this %s.', 'navypier' ), $post_type_name ),
				'description' => __('')				
			),	
			'promotion_title' => array(
				'name' => 'promotion_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Promotion Title'),
				'description' => __( 'Enter the name of this promotion.', 'navypier' ),
			),
			'promotion_subtitle' => array(
				'name' => 'promotion_subtitle',
				'type' => 'text',
				'default' => '',
				'title' => __('Promotion Title'),
				'description' => __('Enter an optional subtitle.')				
			),
			'promotion_url' => array(
				'name' => 'promotion_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Promotion URL'),
				'description' => __('Enter an optional url for this promotion.')			
			),				
			'promotion_action_bar' => array(
				'name' => 'promotion_action_bar',
				'type' => 'text',
				'default' => '',
				'title' => __('Action Bar'),
				'description' => __( 'Enter the actionable items here ("Read More", "Get Deal", etc.). ex: <code>&lt;a href="#" class="icon read-more">read more&lt;/a&gt;&lt;a href="#" class="icon get-deal"&gt;get deal&lt;/a&gt;</code>', 'navypier' )				
			)			
		);		
			
		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Display a Promotion' ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'Use these settings to display a promotion or deal in this %s.', 'navypier' ), $post_type_name ),
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
	
		if( 'cpt_promotion' === get_post_type() ){
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
			
			if ( 'promotion_include' === $meta_field['name']) {			
				$checked = ('promotion_include_y' === $meta_field_value) ? ' checked="checked"' : ' ' ;
				$output .= '<p><label for="'.$meta_field['name'].'">';
				$output .= '<input class="checkbox" type="checkbox" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="promotion_include_y"' . $checked . '/> <span class="desc">'.$meta_field['title'].'</span></label></p>';			
			}	
			
			if ( 'promotion_title' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}
			
			if ( 'promotion_subtitle' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}

			if ( 'promotion_url' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value=\''.$meta_field_value.'\' size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}	

			if ( 'promotion_action_bar' === $meta_field['name']) {			
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
	 
		if( 'cpt_promotion' === get_post_type() ){
			return;
		}
		
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
function mbp_has_promotion( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	return (bool) get_post_meta( $post_id, '_promotion_include', true );
}


function mbp_display_promotion_box( $post_id = null ){
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;
	$promo_title = get_post_meta( $post_id, '_promotion_title', true );
	$promo_subtitle = get_post_meta( $post_id, '_promotion_subtitle', true );
	$promo_url = get_post_meta( $post_id, '_promotion_url', true );
	$promo_actions = get_post_meta( $post_id, '_promotion_action_bar', true );

	$out = '<div class="promotion-container">';
	$out .= '<a href="'.$promo_url.'" class="promotion-text">';
	$out .= $promo_title.'<br />';
	$out .= '<span class="promotion-date">'.$promo_subtitle.'</span>';
	$out .= '</a>';
	$out .= '<div class="promotion-links">'.$promo_actions.'</div>';		
	$out .= '</div>';			
	
	echo $out;
}

$MetaBox_Promotion = new MetaBox_Promotion();


?>