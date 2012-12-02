<?php
/*
 * This class is to manage database tables
 * */

class wp_sherif_conversion_db{

	//init
	static function init(){
		register_activation_hook(WPCONVERSIONSHERIF_FILE, array(get_class(), 'create_tables'));
	}
	
	
	//create tables if not exists
	static function create_tables(){
		$tables = self::get_tables_name();
		extract($tables);
		
		$sql[] = "CREATE TABLE IF NOT EXISTS $cookie(
				ID bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
				content text(100) NOT NULL,
				type varchar(30) NOT NULL,
				camp_id bigint unsigned NOT NULL,
				action varchar(30) NOT NULL	 			
			)";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS $display(
				ID bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
				content text(100) NOT NULL,
				type varchar(30) NOT NULL,
				camp_id bigint unsigned NOT NULL				 			
			)";
		
		if(!function_exists('dbDelta')) :
			include ABSPATH . 'wp-admin/includes/upgrade.php';
		endif;
		foreach($sql as $s){
			dbDelta($s);
		}
		
	}
	
	
	//defining tables name
	static function get_tables_name(){
		global $wpdb;
		return array('cookie' => $wpdb->prefix . 'sherifs_cookie', 'display' => $wpdb->prefix . 'sherifs_display');
	}
	
	
	//insert cookie permalinks, tags, categories
	static function insert_a_cookie_record($keyword = '', $action){
		
		
		
		
		$type = '';
		if(self::is_url(trim($keyword))){
			$type = 'permalink';
			//var_dump($keyword);
			//die();
		}
		elseif(is_tag($keyword)){
			$type = 'tag';
		}
		/*
		elseif(is_category($keyword)){
			$type = 'category';
		}*/
		else{
			return;
		}
		
		return self::insert_cookie($type, $keyword, $action);
	}
	
	
	//db insert action
	static function insert_cookie($type, $keyword, $action){
		if(empty($type) || empty($keyword)) return;
		global $wpdb;
		
		$tables = self::get_tables_name();
		extract($tables);
		
		$camp_id = (int) trim($_POST['existing_campaign']);		
		
		//$existing_rows = self::get_existing_records($camp_id, $type, $action);
		
		//var_dump($existing_rows);
		//var_dump($existing_rows); die();
		
		
		return $wpdb->insert($cookie, array('content'=>$keyword, 'type'=>$type, 'camp_id'=>$camp_id, 'action'=>$action), array('%s', '%s', '%d', '%s'));		
				
		
		
	}
	
	
	/*
	 * return the existing records
	 * */
	static function get_existing_records($camp_id, $type, $action){
		global $wpdb;
		$tables = self::get_tables_name();
		extract($tables);
		
		$sql = "SELECT ID, content FROM $cookie WHERE camp_id = $camp_id AND type = '$type' AND action = '$action' ";
		
		$records = $wpdb->get_results($sql);
		$return = array();
		if($records){
			foreach($records as $record){
				$return[$record->content] = $record->ID;
				//var_dump($record);
			}
		}
		
		return $return;
		
	}
	
	
	//is_url 
	static function is_url($url = ''){
		//$reg_exp = "/^(http(s?):\/\/)?(www\.)+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";
		$reg_exp = "/(https|http|ftp)\:\/\/|([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4})|([a-z0-9A-Z]+\.[a-zA-Z]{2,4})|\?([a-zA-Z0-9]+[\&\=\#a-z]+)/i";
		return preg_match($reg_exp, $url);
	}
	
	
	/*
	 * returnt the tags and permalinks that excludes
	 * */
	static function get_cookie_table_data($camp_id, $type, $action){
		global $wpdb;
		$tables = self::get_tables_name();
		extract($tables);
		
		switch($type){
			case "tag-permalink":
				$sql = "SELECT content FROM $cookie WHERE camp_id = $camp_id
						AND action = '$action'
						AND ( type = 'tag' OR type = 'permalink' )
				";
				break;
			
			case "tag-category" :
				$sql = "SELECT content FROM $cookie WHERE camp_id = $camp_id
						AND action = '$action'
						AND ( type = 'tag' OR type = 'category' )
				";	
				break;
			case "permalink" :
				$sql = "SELECT content FROM $cookie WHERE camp_id = $camp_id
						AND action = '$action'
						AND type = 'permalink'
				";	
				break;
		}
		
		$tags_permalinks = $wpdb->get_col($sql);
		
		if($tags_permalinks){
			return implode(', ', $tags_permalinks);
		}
		
		return '';
	}
	
	
	//remove the exsing cookie data
	static function remove_existing_records_cookie_table($action, $camp_id, $types){
		global $wpdb;
		$tables = self::get_tables_name();
		extract($tables);
		
		$sql = "DELETE FROM $cookie WHERE camp_id = $camp_id AND action = '$action' AND ";
		
		switch($types) {
			case "permalink-tag" :
				$sql .= " ( type = 'permalink' OR type = 'tag' ) ";
				break;
			case "category-tag" :
				$sql .= " ( type = 'tag' OR type = 'category' ) ";
				break;
			case "permalink" :
				$sql .= " type = 'permalink' ";				
				break;
		}
		
		
		
		$wpdb->query($sql);
	}
	
	
	
	//display table settings
	static function insert_into_display($d_tag, $type, $camp_id){
		global $wpdb;
		$tables = self::get_tables_name();	
		extract($tables);
			
		return $wpdb->insert($display, array('content' => $d_tag, 'type' => $type, 'camp_id' => (int)$camp_id), array('%s', '%s', '%d'));
	}
	
	//rem,ove the display table's existing data
	static function remove_dispaly_tables_existing_data($camp_id, $type){
		global $wpdb;
		$tables = self::get_tables_name();
		extract($tables);
		$camp_id = (int) $camp_id;
		
		$sql = "DELETE FROM $display WHERE camp_id = $camp_id AND type = '$type'";
		$wpdb->query($sql);
	}
	
	
	//return the display terms of the posts
	static function get_records_from_display_table($camp_id, $type){
		global $wpdb;
		$tables = self::get_tables_name();
		extract($tables);
		$camp_id = (int) $camp_id;
		
		$sql = "SELECT content FROM $display WHERE camp_id = $camp_id AND type = '$type'";
		
		$return = $wpdb->get_col($sql);
		if($return){
			return implode(', ', $return);
		}
		
		return '';
		
	}
	
}