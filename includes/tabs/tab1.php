
<?php 
	if($post){
		$primary_content = $post->post_content;
		$secondary_content = get_post_meta($post->ID, 'secondary_campaign_content', true);
	}
?>


<style>
	.content_area_div{
		margin-top: 30px;
	}
	.content_title span{
		font-size: 20px;
	}
</style>


<input type="hidden" name="tab_number" value="1" />


<div class="content_area_div">
	<p class="content_title"> <span >  <label for="primary_content_area">Primary Content </label> </span> This is the content that will be shown if the cookie for this campaign has not been set on the visitors browser </p>	
	<?php wp_editor($primary_content, 'primary_content_area', array('textarea_name'=>'primary_content'));?>

</div>

<div class="content_area_div">
	<p class="content_title"> <span > <label for="secondary_content_area">Secondary Content </label></span> This is the content that will be shown if the cookie for this campaign has been set on the visitors browser </p>	
	<?php wp_editor($secondary_content, 'secondary_content_area', array('textarea_name'=>'secondary_content'));?>

</div>