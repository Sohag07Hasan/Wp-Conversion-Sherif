<?php 
	
	// current page url 
	$page_url = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new');
	
	
	//form action
	$action = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new');
	
	//messages
	$message = '';	
	if(isset($_GET['msg'])){
		switch ($_GET['msg']){
			case 1 :
				$message = '<div class="campaign-updated"><p> Campaign Saved.. </p></div>';
				break;
			case 2 :
				$message = '<div class="campaign-error"><p> Please Create a new campaign and then set the display options.. </p></div>';
				break;
			case 3 :
				$message = '<div class="campaign-error"><p> Please Create a new campaign and then set the cookie options.. </p></div>';
				break;
			case 4 :
				$message = '<div class="campaign-updated"><p> Options for Cookie are Saved.. </p></div>';;
				break;
			case 5 :
				$message = '<div class="campaign-updated"><p> Options for Display are Saved.. </p></div>';;
				break;
		}
	
	}

	if(isset($_GET['cid'])){
		$post = get_post(trim($_GET['cid']));
		if($post){
			$title = $post->post_title;
			$page_url .= '&cid=' . trim($_GET['cid']);				
		}		
	}
		

	//tabs creation link
	$tab1 = $page_url . '&tab=1';
	$tab2 = $page_url . '&tab=2';
	$tab3 = $page_url . '&tab=3';	
?>


<style>

	.form-submit{
		float: right;
		font-size: 22px;
	}
	
	.nav-tab{
		background-color: #BFBFBF;
		color: #000000;
	}
	
	.tab-active{
		background-color: #FFFFFF;
		border-bottom: none;
	}
	
	.wrap div{
		/* background-color: #D0D0D0; */		
	}
	
	.campaign-title{
		font-size: 20px;
		margin-bottom: 20px;
	}
	
	.campaign-updated{
		margin: 5px 0 15px;
		background-color: #FFFFE0;
   		border-color: #E6DB55;
		padding: 0 0.6em;
		border-radius: 3px 3px 3px 3px;
   		border-style: solid;
    	border-width: 1px;
		color: #333333;
		font-family: sans-serif;
    	font-size: 12px;
    	line-height: 1.4em;
	}
	
	.campaign-error{
		margin: 5px 0 15px;
		background-color: #FFEBE8;
   		border-color: #CC0000;;
		padding: 0 0.6em;
		border-radius: 3px 3px 3px 3px;
   		border-style: solid;
    	border-width: 1px;
		color: #333333;
		font-family: sans-serif;
    	font-size: 12px;
    	line-height: 1.4em;	
	}
	
</style>


<div class="wrap">	
	
	
	<div><img src="<?php echo $images['big'];?>" title="Conversion Sherif" onclick="return false"></div><hr/>
	
	<?php echo $message; ?>	
	
	<form action="<?php echo $action; ?>" method="post">
	
		<?php if(isset($_GET['cid']) && !empty($_GET['cid'])) :	?>
			<input type="hidden" name="existing_campaign" value="<?php echo trim($_GET['cid']); ?>" />
		<?php endif;?>
		
	
		<input type="hidden" name="campaign-submited" value="Y" />
		
		<!-- <p class="form-submit">	<input type="submit" value="Save Campaign" class="button-primary" /></p> -->
		
		<div style="clear:both"></div>
				
		<div class="campaign-title">
			<label for="campaign-title">Campaing Name</label> <input size="50" id="campaign-title" name="campaign-title" value="<?php echo $title; ?>" />
		</div>
		
		<h2 class="nav-tab-wrapper nav-tab-styler">
			<?php $class = ($_GET['tab'] == 1 || !isset($_GET['tab'])) ? 'nav-tab nav-tab-active tab-active' : 'nav-tab';	?>
			<a class="<?php echo $class; ?>" href="<?php echo $tab1;?>">Content</a>
			
			<?php $class = ($_GET['tab'] == 2) ? 'nav-tab nav-tab-active tab-active' : 'nav-tab';	?>
			<a class="<?php echo $class; ?>" href="<?php echo $tab2;?>">Cookie Settings</a>
			
			<?php $class = ($_GET['tab'] == 3) ? 'nav-tab nav-tab-active tab-active' : 'nav-tab';	?>
			<a class="<?php echo $class; ?>" href="<?php echo $tab3;?>">Display Settings</a>
		</h2>		
		
		<?php 
			switch($_GET['tab']){
				case 2:
					include dirname(__FILE__) . '/tabs/tab2.php';
					break;
				case 3:
					include dirname(__FILE__) . '/tabs/tab3.php';
					break;
				default:
					include dirname(__FILE__) . '/tabs/tab1.php';
					break;
			}		
		?>
		
		<p class="form-submit">
			<input type="submit" value="Save Campaign" class="button-primary" /> 
		</p>
		
	</form>
		
</div>



