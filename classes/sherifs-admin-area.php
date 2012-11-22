<?php
/*
 * handles admin section
 */

class wp_sherif_conversion_admin{
	
	static function init(){
		add_action('admin_menu', array(get_class(), 'create_admin_menu'));
		add_action('admin_enqueue_scripts', array(get_class(), 'admin_css_js'));
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
				include WPCONVERSIONSHERIF_DIR . '/includes/campaigns.php';
				break;
		}
		
	}
	
	
	
	/*
	 * add css and javascript
	 * */
	static function admin_css_js(){
		if($_GET['page'] == 'wp_conversion_sherif_menu'):
			
			wp_enqueue_script( 'jquery' );
			wp_register_script('wp-conversion-sherif-tabs-jquery-ui', self::get_plugin_url('ui_library/tabs/jquery-ui-1.9.1.custom.min.js'), array('jquery'));
			wp_enqueue_script('wp-conversion-sherif-tabs-jquery-ui');
			
			wp_register_script('wp-coversion-sherif-assesjs', self::get_plugin_url('js/asset.js'));
			wp_enqueue_script('wp-coversion-sherif-assesjs');
			
			wp_register_style('wp-conversion-sherif-tabs-css-ui', self::get_plugin_url('ui_library/tabs/smoothness/jquery-ui-1.9.1.custom.css'));
			wp_enqueue_style('wp-conversion-sherif-tabs-css-ui');
			
		endif;
	}
	
	
	//get plguins url
	static function get_plugin_url($location = ''){
		return WPCONVERSIONSHERIF_URL . $location;
	}
}