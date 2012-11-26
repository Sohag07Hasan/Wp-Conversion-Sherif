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