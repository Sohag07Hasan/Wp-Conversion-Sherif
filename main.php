<?php 
/*
 * Plugin Name: WP Conversion Sherif
 * Description: Description goes here
 * author: Mahibul Hasan Sohag
 * author uri: http://sohag7hasan.elance.com
 * */

define("WPCONVERSIONSHERIF_DIR", dirname(__FILE__));
define("WPCONVERSIONSHERIF_FILE", __FILE__);
define("WPCONVERSIONSHERIF_URL", plugins_url('/', __FILE__));


include WPCONVERSIONSHERIF_DIR . '/classes/sherifs-admin-area.php';
wp_sherif_conversion_admin::init();

