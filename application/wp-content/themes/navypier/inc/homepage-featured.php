<?php
/**
 * Homepage Featured Content
 *
 * Allows author to mark post as featured for a rotator on t he homepage.
 *
 */

 
class Homepage_Featured {

	private $meta_config_args;
	private $dont_show_in = array('cpt_advertisement');

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
		add_action( 'admin_menu',     array($this,'register_options_page') );
		add_action( 'admin_init',     array($this,'register_settings') );
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
		$basename = 'homepage-rotator';
		$post_type_name = 'post';
		
		$post_types = get_post_types();
		$post_type = get_post_type();
		
		if( $post_type ){
			$post_type_name = strtolower( get_post_type_object( $post_type )->labels->singular_name );
		}
		
		
		$meta_fields = array(
			'rotator_include' => array(
				'name' => 'rotator_include',
				'type' => 'checkbox',
				'default' => '',
				'title' => __('Check here to include this content in the homepage content rotator.'),
				'description' => __('')				
			),	
			'rotator_title' => array(
				'name' => 'rotator_title',
				'type' => 'text',
				'default' => '',
				'title' => __('Slide Title'),
				'description' => sprintf( __( 'Enter an optional editorial post title. Default: %s title.', 'navypier' ), $post_type_name )
			),
			'rotator_subtitle' => array(
				'name' => 'rotator_subtitle',
				'type' => 'text',
				'default' => '',
				'title' => __('Slide Sub Title'),
				'description' => __('Enter an optional editorial sub title. Default: none.')				
			),
			'rotator_btn_url' => array(
				'name' => 'rotator_btn_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Slide Link URL'),
				'description' => sprintf( __( 'Enter an optional editorial url. Default: %s permalink.', 'navypier' ), $post_type_name )				
			),
			'rotator_img_url' => array(
				'name' => 'rotator_img_url',
				'type' => 'text',
				'default' => '',
				'title' => __('Slide Image URL'),
				'description' => sprintf( __( 'Enter an optional image url. Default: %s featured image. After uploading your photo, enter the url here. <a href="#" id="add_file" class=" insert-media add_media" title="Add Media">Click here to upload.</a>', 'navypier' ), $post_type_name )					
			),			
		);		
			
		$args = array(
			'meta_box_id' => $basename . 'div',
			'meta_box_name' => $basename . 'info',
			'meta_box_title' => __( 'Homepage Rotator Settings' ),
			'meta_box_default' => '',
			'meta_box_description' => sprintf( __( 'You can customize the appearance of this %s if you select it for the Homepage Rotator. If any setting is left blank, the rotator will fall back to the default noted.', 'navypier' ), $post_type_name ),
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
	protected function show_in_posttype( $post_type )
	{
		if( !$post_type || '' === $post_type ){
			return false;
		}
		
		$dont_show = apply_filters('hm_rotator_exclude_meta_box', $this->dont_show_in );
				
		if( in_array($post_type, $dont_show) ){
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
			
			if ( 'rotator_include' === $meta_field['name']) {			
				$checked = ('rotator_include_y' === $meta_field_value) ? ' checked="checked"' : ' ' ;
				$output .= '<p><label for="'.$meta_field['name'].'">';
				$output .= '<input class="checkbox" type="checkbox" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="rotator_include_y"' . $checked . '/> <span class="desc">'.$meta_field['title'].'</span></label></p>';			
			}	
			
			if ( 'rotator_title' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}
			
			if ( 'rotator_subtitle' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}	

			if ( 'rotator_btn_url' === $meta_field['name']) {			
				$output .= '<p><b><label for="'.$meta_field['name'].'">'.$meta_field['title'].'</label></b><br />';
				$output .= '<input class="reg-text" type="text" id="'.$meta_field['name'].'" name="'.$meta_field['name'].'" value="'.$meta_field_value.'" size="16" style="width: 99%;" /> <span class="desc">'.$meta_field['description'].'</span></p>';			
			}

			if ( 'rotator_img_url' === $meta_field['name']) {			
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
		
		// update the transient cache
		delete_transient( 'rotator_content');
		
		return $post_id;
	 
	 }

	 
	/**
	 * Display Homepage Rotator Items in a Dashboard Panel
	 *
	 * @access public
	 * @since 1.0
	 * 
	 */
	public function register_options_page() 
	{
		add_submenu_page( 'options-general.php', 'Homepage Rotator Items', 'Homepage Rotator', 'manage_options', 'hmpg_rotate', array($this,'show_options_page') );
	} 
	 
	 
	/**
	 * Register rotator slide order setting
	 *
	 * @access public
	 * @since 1.0
	 * 
	 */ 
	public function register_settings() 
	{
		register_setting( 'hm_rotator_order_options', 'hm_rotator_order', array($this, 'validate_settings') );
	} 

	/**
	 * Validate rotator settings.
	 *
	 * Make sure that all user supplied content is in an expected
	 * format before saving to the database.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array $input Array of settings input.
	 * @return array Validated settings output.
	 */
	public function validate_settings( $input )
	{

		$errors = array();
		$featured_ids = array_map( 'absint', $input );
		
		foreach( $featured_ids as $post_id => $order){
			if( 0 === $order ){
				$errors[$post_id] = 'blank';
			}
		}

		if( !empty($errors) ) {
			add_settings_error(
				'hm_rotator_order',
				esc_attr( 'hm_rotator_order_err' ),
				__('Please check you order. Order input must be numeric and greater than 0.'),
				'error'
			);
			#delete_option('hm_rotator_order');
			#return false;
		}
		
		delete_transient( 'rotator_content' );
		
		return $featured_ids;
		
	}


	
	/**
	 * Get featured post content
	 *
	 * This function will return the an array containing the
	 * post IDs of all featured posts.
	 *
	 * Sets the "rotator_content" transient.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 *
	 * @return object WP_Query object
	 */
	public static function get_rotator_content()
	{
		// Return array of cached results if they exist.
		$rotator_content = get_transient( 'rotator_content' );

		if ( false === $rotator_content || '' == $rotator_content ) {
		
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'any',
				'meta_query' => array(
					array(
						'key' => '_rotator_include', 
						'value' => 'rotator_include_y' 
					)
				) 
			);		
					
			// Query for featured posts.
			add_filter('posts_orderby', 'hm_rotator_orderby' );
			$rotator_content = new WP_Query($args);
			remove_filter('posts_orderby', 'hm_rotator_orderby' );
			
			// set cache
			set_transient( 'rotator_content', $rotator_content, 12 * HOUR_IN_SECONDS );			
		}
				
		wp_reset_postdata();
		
		return $rotator_content;
		
	}
	
	
	/**
	 * Show rotator options page
	 *
	 * @access public
	 * @since 1.0
	 * 
	 */ 
	public function show_options_page()
	{ ?>
		<div class="wrap">
		
			<?php screen_icon(); ?>	<h2>Homepage Rotator Items</h2>
			<?php $r = self::get_rotator_content(); ?>
							
			<?php if( $r->have_posts() ) : ?>
				<h3><div class="dashicons dashicons-clipboard"></div> Notes:</h3>
				<ul style="list-style: square outside none; margin-left: 18px;">
					<li><?php _e('The content items below are currently marked to be included in the featured content rotator on the homepage of the site.');?></li>
					<li><?php _e('The order below is how they will appear in the rotator.');?></li>
					<li><?php _e('You can adjust the order by indicating each item&#8217;s position in the Order column.');?></li>
					<li><?php _e('To edit an item, click the title link.');?></li>
				</ul>

				<form method="post" action="options.php">
					<?php settings_fields('hm_rotator_order_options'); ?>
					<?php $options =  get_option('hm_rotator_order'); ?>
					<?php $count = 1; ?>
		
					<table class="widefat comments fixed" cellspacing="0">
						<thead>
							<tr>
								<th class="column-order" style="width:100px;">Order</th>
								<th class="column-thumb" style="width:100px;">Thumbnail</th>
								<th class="column-date" style="width:100px;">Publish Date</th>
								<th class="column-title">Title</th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th class="column-order" style="width:100px;">Order</th>
								<th class="column-thumb" style="width:100px;">Thumbnail</th>
								<th class="column-date" style="width:100px;">Publish Date</th>
								<th class="column-title">Title</th>
							</tr>
						</tfoot>
						<tbody id="the-homepage-list" class="list:homepage">
							<?php $style='';?>
							<?php while ( $r->have_posts() ) : $r->the_post(); 					
								$style = ( ' class="alternate"' == $style ) ? '' : ' class="alternate"';
								$img_src = get_post_meta(get_the_ID(), '_rotator_img_url', true);
								if ( '' == $img_src ) {
									$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rotator-home');
									$img_src = $image_url[0];
								}; ?>
								<tr <?php echo $style; ?> id="post-<?php the_ID(); ?>">
									<?php $order = ( $options && isset ( $options[ get_the_ID() ])  ) ? $options[ get_the_ID() ] : $count; ?>
									<td style="width: 40px"><input class="small-text" type="text" name="hm_rotator_order[<?php echo  get_the_ID();?>]" value="<?php echo $order; ?>" /></td>
									<td style="width:100px;"><img src="<?php echo $img_src; ?>" alt="<?php echo get_the_title(); ?>" width="80" /></td>
									<td style="width:100px;"><?php the_time('M d, Y'); ?></td>
									<td><a href="<?php echo get_edit_post_link( get_the_ID() ); ?>#homepage-rotatordiv" title="click to edit - will open in new window" target="_blank"><?php the_title() ; ?></a></td>
								</tr>
								<?php ++$count; ?>
							<?php endwhile; // end of the loop. ?>
						</tbody>
					</table>
					<?php submit_button(); ?>
				</form>	
			<?php else: ?>
				<p>Nothing to display.</p>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>

		</div>


	<?php }
	

	
}
  

// the homepage rotator
function hm_rotator_orderby($orderby) {
	$order =  get_option('hm_rotator_order');	
	
	if( $order ) {
		asort($order);
		$order = array_flip($order);	
		$orderby = implode(',', $order);	

		return "FIELD(ID, $orderby)";	
	}
	return $orderby;
}

$homepage_featured = new Homepage_Featured();


?>