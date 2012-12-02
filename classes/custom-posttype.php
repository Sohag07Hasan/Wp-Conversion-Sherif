<?php

/*
 * creates a custom post type to handle the conversin sherif
 * */

class wp_sherif_conversion_posttype{
	
	//custom posttype related constants
	const posttype = 'sherifconversion';
	
	
	//init function
	static function init(){
		add_action('init', array(get_class(), 'register_new_posttype'));
	}
	
	
	//register new posttype
	static function register_new_posttype(){
		$labels = array(
			'name' => '',
			'singular_name' => '',
			'add_new' => '',
			'add_new_item' => '',
			'edit_item' => '',
			'new_item' => '',
			'all_items' =>'',
			'view_item' => '',
			'search_items' => '',
			'not_found' =>  '',
			'not_found_in_trash' => '', 
			'parent_item_colon' => '',
			

		);
		$args = array(
			'labels' => $labels,
			'exclude_from_search' => true,
			'public' => true,
			'publicly_queryable' => false,
			'show_ui' => false, 
			'show_in_menu' => false,
			'show_in_nav_menus' => false, 
			'query_var' => false,
			'rewrite' => false,
			'capability_type' => 'post',
			'has_archive' => false, 
			'hierarchical' => false,			
			'supports' => array()			
		); 
		register_post_type(self::posttype, $args);	
	}
	
	
	
	//returns the campaigns
	static function get_campaigns(){
		global $wpdb;
		$post_type = self::posttype;
		$sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = '$post_type' ORDER BY post_title";
		return $wpdb->get_results($sql);
	}
	
	
	//delete selected campaign
	static function delete_the_campaign(){
		global $wpdb;
		$tables = wp_sherif_conversion_db::get_tables_name();
		extract($tables);
		
		$post_id = (int) $_GET['cid'];
		wp_delete_post($post_id, true);
		
		$sql = "DELETE FROM $cookie WHERE camp_id = $post_id ";
		$wpdb->query($sql);
		
	}
}