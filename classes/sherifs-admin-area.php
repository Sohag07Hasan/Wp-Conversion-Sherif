<?php
/*
 * handles admin section
 */

class wp_sherif_conversion_admin{
	
	static function init(){
		add_action('admin_menu', array(get_class(), 'create_admin_menu'));
		//add_action('admin_enqueue_scripts', array(get_class(), 'admin_css_js'));		
		add_action('init', array(get_class(), 'form_submission_handler'));
	}
	
	
	/*
	 * calling the admi menu function
	 * */
	
	static function create_admin_menu(){
		$images = self::get_logos();
		add_menu_page('wp conversion sherif menu', 'Wp Conversion Sherif', 'manage_options', 'wp_conversion_sherif_menu', array(get_class(), 'menu_page'), $images['tiny']);
	}
	
	/*
	 * get the images
	 * */
	static function get_logos(){
		return array(
			'tiny' => WPCONVERSIONSHERIF_URL . 'images/logo/logo_tiny.png',
			'big' => WPCONVERSIONSHERIF_URL . 'images/logo/conversion_sheriff_logo.png'
		);
	}
	
	
	
	/*
	 * populate menu page
	 * */
	static function menu_page(){
		$images = self::get_logos();
		switch($_GET['action']){
			case "new" :
				include WPCONVERSIONSHERIF_DIR . '/includes/new-campaign.php';
				break;
			default :
				if($_GET['action'] == 'del') wp_sherif_conversion_posttype::delete_the_campaign();
				$campaigns = wp_sherif_conversion_posttype::get_campaigns();
				include WPCONVERSIONSHERIF_DIR . '/includes/campaigns.php';
				break;
		}
		
	}
	
	
	
	/*
	 * add css and javascript
	 * */
	static function admin_css_js(){
		if($_GET['page'] == 'wp_conversion_sherif_menu'):
			/*
			wp_enqueue_script( 'jquery' );
			wp_register_script('wp-conversion-sherif-tabs-jquery-ui', self::get_plugin_url('ui_library/tabs/jquery-ui-1.9.1.custom.min.js'), array('jquery'));
			wp_enqueue_script('wp-conversion-sherif-tabs-jquery-ui');
			
			wp_register_script('wp-coversion-sherif-assesjs', self::get_plugin_url('js/asset.js'));
			wp_enqueue_script('wp-coversion-sherif-assesjs');
			
			wp_register_style('wp-conversion-sherif-tabs-css-ui', self::get_plugin_url('ui_library/tabs/smoothness/jquery-ui-1.9.1.custom.css'));
			wp_enqueue_style('wp-conversion-sherif-tabs-css-ui');
			*/
			
		endif;
	}
	
	
	//get plguins url
	static function get_plugin_url($location = ''){
		return WPCONVERSIONSHERIF_URL . $location;
	}
	
	
	//handle form submission
	static function form_submission_handler(){
		if($_POST['campaign-submited'] == 'Y'){
			switch ($_POST['tab_number']){
				case "2" :
					return self::save_tab2();
					break;
				case "3" :
					return self::save_tab3();
					break;
				default :
					return self::save_tab1();
					break;
			}
		}
	}
	
	
	//save the tab1
	static function save_tab1(){
		$title = trim($_POST['campaign-title']);
		$content = array(
			'primary_content' => trim($_POST['primary_content']),
			'secondary_content' => trim($_POST['secondary_content'])
		);
		
		$post = array(
			'post_title' => (empty($title)) ? 'Un Named' : $title,
			'post_content' => serialize($content),
			'post_type' => wp_sherif_conversion_posttype::posttype
		);
		
		
		
		if(isset($_POST['existing_campaign']) && !empty($_POST['existing_campaign'])){
			$post['ID'] = trim($_POST['existing_campaign']);
		}
		
		$new_post_id = wp_insert_post($post);
		if($new_post_id){
			$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=1&tab=1&cid=') . $new_post_id;
		}
		else{
			$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=2&tab=1');
		}

		return self::do_redirect($redirect_url);
	}
	
	
	//save the second tab form data
	static function save_tab2(){
		//$title = trim($_POST['campaign-title']);
		$post_id = trim($_POST['existing_campaign']);
		if(empty($post_id)){
			$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=3&tab=1');
			return self::do_redirect($redirect_url);
		}
		
		update_post_meta($post_id, 'cookie-excludes-checkbox', $_POST['cookie-excludes-checkbox']);
		update_post_meta($post_id, 'cookie-includes-checkbox', $_POST['cookie-includes-checkbox']);
		update_post_meta($post_id, 'cookie-includes-post-checkbox', $_POST['cookie-includes-post-checkbox']);
		update_post_meta($post_id, 'cookie-time', $_POST['cookie-time']);
		
		//cookie excluding settings
		if($_POST['cookie-excludes-checkbox'] == 'Y'){
			$action = 'e';			
			$cookie_excludes = explode(',', $_POST['cookie-excludes']);
			
			//remove the existing records
			wp_sherif_conversion_db::remove_existing_records_cookie_table($action, $post_id, 'permalink-tag');
			
			if(count($cookie_excludes)){
				$cookie_excludes = array_unique($cookie_excludes);
				foreach($cookie_excludes as $cookie_exclude){
					wp_sherif_conversion_db::insert_a_cookie_record(trim($cookie_exclude), $action);
				}
			}
		}
		
		//include cookie settings
		if($_POST['cookie-includes-checkbox'] == 'Y'){
			$action = 'i';	
			$cookie_includes = explode(',', $_POST['cookie-includes']);
			
			wp_sherif_conversion_db::remove_existing_records_cookie_table($action, $post_id, 'category-tag');
			
			if(count($cookie_includes)){
				$cookie_includes = array_unique($cookie_includes);
				foreach($cookie_includes as $cookie_include){
					$type = '';
					$cookie_include = trim($cookie_include);
					
					if(term_exists($cookie_include, 'post_tag')){
						$type = 'tag';
					}
					if(term_exists($cookie_include, 'category')){
						$type = 'category';
					}
															
					if($type){
						wp_sherif_conversion_db::insert_cookie($type, trim($cookie_include), $action);
					}
					
				}
			}
		}
		
		
		//include posts with thes permalinks
		if($_POST['cookie-includes-post-checkbox'] == 'Y'){
			$action = 'i';	
			$including_links = explode(',', $_POST['cookie-includes-permalinks']);
			
			wp_sherif_conversion_db::remove_existing_records_cookie_table($action, $post_id, 'permalink');
			
			if(count($including_links)){
				$including_links = array_unique($including_links);
				foreach($including_links as $including_link){
					if(wp_sherif_conversion_db::is_url($including_link)){
						wp_sherif_conversion_db::insert_cookie('permalink', trim($including_link), $action);	
					}													
				}
			}
		}
		
		
		
		
		$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=4&tab=2&cid=') . $post_id;
		return self::do_redirect($redirect_url);
	}
	
	
	
	//save the form from tab3
	static function save_tab3(){
		$post_id = trim($_POST['existing_campaign']);
		if(empty($post_id)){
			$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=2&tab=1');
			return self::do_redirect($redirect_url);
		}
		
		
		
		update_post_meta($post_id, 'display-site-wise', $_POST['display-site-wise']);
		update_post_meta($post_id, 'display-allpages', $_POST['display-allpages']);
		update_post_meta($post_id, 'display-allposts', $_POST['display-allposts']);
		update_post_meta($post_id, 'display-following-tags', $_POST['display-following-tags']);
		update_post_meta($post_id, 'display-follwing-permalinks', $_POST['display-follwing-permalinks']);
		
		update_post_meta($post_id, 'display-top-header', $_POST['display-top-header']);
		update_post_meta($post_id, 'display-bottom-content', $_POST['display-bottom-content']);
		update_post_meta($post_id, 'display-bottom-header', $_POST['display-bottom-header']);
		update_post_meta($post_id, 'display-top-footer', $_POST['display-top-footer']);
		update_post_meta($post_id, 'display-top-content', $_POST['display-top-content']);
		update_post_meta($post_id, 'display-bottom-footer', $_POST['display-bottom-footer']);
		
		$redirect_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new&msg=5&tab=3&cid=') . $post_id;
		return self::do_redirect($redirect_url);
	}
	
	
	//do a redirect
	static function do_redirect($url = null){
		if($url){
			if(!function_exists('wp_redirect')){
				include ABSPATH . '/wp-includes/pluggable.php';
			}

			wp_redirect($url);
			die();
		}
	}
	
	
		
	
}