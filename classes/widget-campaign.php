<?php
/*
 * This class creates a widget
 * */

class wp_sherif_conversion_widget extends WP_Widget{
	
	//constructor class
	function __construct(){
		$widget_ops = array('classname' => 'wp_sherif_conversion', 'description' => __( 'Shows a Selected Sherif Conversion Campaign'));
		parent::__construct('sherifconversion', __('Conversion Sherif'), $widget_ops);
	}
	
	
	
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$campaign = esc_attr( $instance['campaign_number'] );
		$campaigns = self::get_campaigns();
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('campaign_number'); ?>"><?php _e( 'Campaign:' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('campaign_number'); ?>" name="<?php echo $this->get_field_name('campaign_number'); ?>">
				<option value='0'> Choose a Campaign </option>
	<?php 
				if($campaigns){
					foreach($campaigns as $cam){
						echo "<option ".selected($cam->ID, $campaign)." value='$cam->ID' >$cam->post_title</option>";						
					}					
				}
	?>
									
				
			</select>
		</p>
		
<?php 
	}
	
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['campaign_number'] = strip_tags($new_instance['campaign_number']);
		return $instance;
	}
	
	
	
	//front end veiw for the fu nction
	function widget($args, $instance){
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Search' ) : $instance['title'], $instance, $this->id_base);
		$campaign = $instance['campaign_number'];
		
		$post = get_post($campaign);
		if(!$post) return;
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
			echo '<p>' . $post->post_title . '</p>';
			
			$campaign = wp_sherif_conversion_frontend_display::get_campaign_content($post->ID);
			
			echo '<p> ' . $campaign . ' </p>';
			
		echo $after_widget;
	}
	
	
	
	static function get_campaigns(){
		return wp_sherif_conversion_posttype::get_campaigns();
	}
	
}