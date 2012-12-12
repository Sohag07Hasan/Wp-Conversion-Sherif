<?php

	ob_start();	

/*
 * handles the cookies and display
 * */

class wp_sherif_conversion_frontend_cookie{
	
	//some variable sto store the importenat data
	static $current_url;
	static $current_post = null;
	static $terms = array();
	
	const cookie_name = "wp_sherif_conversion_";
	
	/*
	 * initialize
	 * */
	static function init(){
		//add_action('init', array(get_class(), 'permalink_cookie'));
		add_filter('the_content', array(get_class(), 'parse_query'));
		
		//add_action('the_posts', array(get_class(), 'parse_query'), 100);
		
		add_action('wp_footer', array(get_class(), 'make_action_to_set_cookie'), 100);
	}
	
	static function parse_query($content){
		
		if(is_single() || is_page()) {
			
			global $post;
			self::$current_post = $post;
			self::$terms = wp_get_object_terms($post->ID, array('category', 'post_tag'));			
		
		}
		
		return $content;
		
	}
	
	
	static function make_action_to_set_cookie(){
		if(self::$current_post){
			
			//var_dump(self::$current_post);
			self::set_cookie_for_post($post);
		}
	}
	
	
	/*
	 * cookie settings
	 * */
	static function permalink_cookie(){
		$url = self::get_current_url();
		self::$current_url = $url;		
		return self::set_cookie_for_permalink();
				
	}
	
	
	/*
	 * return the current url
	 * */
	static function get_current_url(){
		$url=(!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	
	
	/*
	 * */
	static function set_cookie_for_permalink(){
		global $wpdb, $wp_query;
		$tables = wp_sherif_conversion_db::get_tables_name();
		extract($tables);
		$url = self::$current_url;
		
		$sql = "SELECT * FROM $cookie WHERE camp_id in (
			SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-excludes-checkbox' AND meta_value = 'Y'
		) AND type = 'permalink' AND action = 'e' AND content = '$url'";
		
		$cols = $wpdb->get_results($sql);
		
		if($cols) return true;
			
		
	}
	
	
	/*
	 * static function 
	 * */
	static function set_cookie_for_post($post){
		
		//var_dump(self::$current_post); die();
		
		if(is_single() || is_page()){
			global $wpdb;
			
			$tables = wp_sherif_conversion_db::get_tables_name();
			extract($tables);
			
			//permalink chekcing
			$url = self::get_current_url();		
			$sql = "SELECT * FROM $cookie WHERE camp_id in (
				SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-excludes-checkbox' AND meta_value = 'Y'
			) AND type = 'permalink' AND action = 'e' AND content = '$url'";
		
			$cols = $wpdb->get_results($sql);
			
			if($cols) return $content ;
			
			
			//category and tag checking
			//$terms = wp_get_object_terms($post->ID, array('category', 'post_tag'));
			$terms = self::$terms;
			
			//var_dump($terms);
			
			if($terms){
				$term_names = array();
				foreach($terms as $term){
					$term_names[$term->taxonomy][] = $term->name;
				}
							
			
				foreach($term_names as $taxonomy => $term_name) :
					$tax = ($taxonomy == 'post_tag') ? 'tag' : $taxonomy;
					foreach($term_name as $tn) {
						$sql = "SELECT * FROM $cookie WHERE camp_id in (
							SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-excludes-checkbox' AND meta_value = 'Y'
						) AND type = '$tax' AND action = 'e' AND content = '$tn'";
						
						if($wpdb->get_results($sql)) return $content;
					}					
					
				endforeach;				
				
				
				
				/*
				 * if all the sites url are chosen to put cookie 
				 * 
				*/
				$sql = "SELECT camp_id FROM $cookie WHERE camp_id in (
					SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-excludes-checkbox' AND meta_value = 'Y'
				)";
				
				$campaigns_for_all_sites = $wpdb->get_col($sql);
				var_dump($campaigns_for_all_sites);
				die();
				
				
				//terms and categories inclusion
				foreach($term_names as $taxonomy => $term_name) :
					$tax = ($taxonomy == 'post_tag') ? 'tag' : $taxonomy;
					foreach($term_name as $tn) {
						
						$sql = "SELECT camp_id FROM $cookie WHERE camp_id in (
							SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-includes-checkbox' AND meta_value = 'Y'
						) AND type = '$tax' AND action = 'i' AND content = '$tn' ";
						
						$campaigns = $wpdb->get_col($sql);

						
						if($campaigns){
							foreach($campaigns as $cam_id){
								$cookie_time = get_post_meta($cam_id, 'cookie-time', true);
								switch($cookie_time){
									case 1 :
										$time = 24;
										break;
									case 2 :
										$time = 7 * 24;
										break;
									case 3 :
										$time = 30 * 24;
										break;
									case 4 :
										$time = 365 * 24;
										break;
									default :
										$time = 24;
										break;
								}
								
								self::set_cookie($time, $cam_id);
							}
						}
					}
				endforeach;					
			}
			
			
			//if the permalinik is set to set teh cookie
			$sql = "SELECT camp_id FROM $cookie WHERE camp_id in (
				SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'cookie-includes-post-checkbox' AND meta_value = 'Y'
			) AND type = 'permalink' AND action = 'i' AND content = '$url'";
		
			$campaigns = $wpdb->get_col($sql);
			
		//	var_dump($campaigns);
			
			if($campaigns){
				foreach ($campaigns as $cam_id){
					$cookie_time = get_post_meta($cam_id, 'cookie-time', true);
					switch($cookie_time){
						case 1 :
							$time = 24;
							break;
						case 2 :
							$time = 7 * 24;
							break;
						case 3 :
							$time = 30 * 24;
							break;
						case 4 :
							$time = 365 * 24;
							break;
						default :
							$time = 24;
							break;
					}
					
					self::set_cookie($time, $cam_id);
					
					
				}
			}
			
		}
		
			
		
	}
	
	
	
	/*
	 * setup cookie
	 * */
	static function set_cookie($time, $cam_id){
		
	
		$name = self::cookie_name . $cam_id;
		$time = time() + $time * 60 * 60;

		
		//var_dump($_COOKIE[$name]);
		if(isset($_COOKIE[$name])) return;					
		return setcookie($name, $cam_id, $time);			
				
	}
	
}