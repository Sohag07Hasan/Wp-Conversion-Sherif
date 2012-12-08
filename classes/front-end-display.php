<?php
/*
 * This class will show the front end view of campaings for differnt pages and posts
 * */

class wp_sherif_conversion_frontend_display{
	
	const headers_hook = "wp_conversion_sherif_header";
	
	static function init(){
		add_action(self::headers_hook, array(get_class(), 'campaigns_top_of_header'));
		add_action('comment_form_before', array(get_class(), 'campaigns_above_comments_form'));
		add_action('wp_footer', array(get_class(), 'campaigns_at_footer'), 10);
		
		//top of the content
		add_filter('the_content', array(get_class(), 'campaigns_top_of_content'));
		
		
	}
	
	
	/*
	 * campaigns to show top of the header
	 * */
	static function campaigns_top_of_header(){
		
	}
	
	
	/*
	 * campaings to shown above the comments form
	 * */
	static function campaigns_above_comments_form(){
		$campaign = self::get_campaigns(4);
		echo $campaign;
	}
	
	
	/*
	 * campaigns at footer section
	 * */
	static function campaigns_at_footer(){
		$campaign = self::get_campaigns(3);
		echo $campaign;
		
	}
	
	
	static function campaigns_top_of_content($content){
		//global $wpdb;
		
		$campaign = self::get_campaigns(2);
		
		return $campaign . $content;
	}
	
	
	static function get_campaigns($position){
		global $wpdb, $post;
		$tables = wp_sherif_conversion_db::get_tables_name();
		extract($tables);
		
		switch ($position){
			case 1 :
				$p = 'display-top-header';
				break;
			case 2 :
				$p = 'display-top-content';
				break;
			case 3 :
				$p = 'display-top-footer';
				break;
			case 4:
				$p = 'display-above-commentarea';
				break;
			default:
				$p = null;
				break;
		}
		
		/*
		$sql = "SELECT * FROM $display WHERE camp_id in (
			SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '$p' AND meta_value = 'Y'
		) ";
		*/
		
		$sql = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '$p' AND meta_value = 'Y'";
		
		$results = $wpdb->get_results($sql);
		
		$campaigns = array();
		
		if($results) {
			foreach($results as $r){
				$custom = get_post_custom($r->post_id);
				if($custom['display-site-wise'][0] == "Y"){
					$campaigns[$r->post_id] = $r;
				}
				elseif($custom['display-allposts'][0] == "Y" && is_single()){
					$campaigns[$r->post_id] = $r;
				}
				elseif($custom['display-allpages'][0] == "Y" && is_page()){
					$campaigns[$r->post_id] = $r;
				}
				else{
					
					//get current post terms
					$terms = wp_get_object_terms($post->ID, array('post_tag'));
					
					if($terms){
						foreach($terms as $term){
							if(self::campaign_exist_for_this_term($term, $r)){
								$campaigns[$r->post_id] = $r;
							}
						}
					}
				}
			}
		}
		
		$cam_string = '';
		
		if(count($campaigns)){
			foreach($campaigns as $key => $campaign){
				$cam_string .= '<p>' . self::get_campaign_content($key) . '</p>';
			}
		}
		
		return $cam_string;
		
	}
	
	
	/*
	 * checking if the term exists for a campaign
	 * */
	static function campaign_exist_for_this_term($term, $r){
		global $wpdb;
		$tables = wp_sherif_conversion_db::get_tables_name();
		extract($tables);
		
		$type = ($term->taxonomy == 'post_tag') ? 'tag' : 'category';
		
		$sql = "SELECT ID FROM $display WHERE camp_id = $r->post_id AND type = '$type' AND content = '$term->name'";
		
		//var_dump($sql);
		
		return $wpdb->get_var($sql);
	}
	
	
	/*
	 * get the content of a post
	 * */
	
	static function get_campaign_content($post_id){
		global $wpdb;
		$post_id = (int) $post_id;
		$name = wp_sherif_conversion_frontend_cookie::cookie_name . $post_id;
		
		$content = $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE ID = $post_id ");
		$content = unserialize($content);
		
		return (isset($_COOKIE[$name])) ? $content['secondary_content'] : $content['primary_content'];
	}
	
		
	
}