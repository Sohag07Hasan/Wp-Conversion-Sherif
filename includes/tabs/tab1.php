
<?php 
	if($post){
		$content = unserialize(trim($post->post_content));
		$primary_content = $content['primary_content'];
		$secondary_content = $content['secondary_content'];
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
	<p class="content_title"> <span >  <label for="primary_content_area">Primary Content </label> </span> here is nothin </p>	
	<?php wp_editor($primary_content, 'primary_content_area', array('textarea_name'=>'primary_content'));?>

</div>

<div class="content_area_div">
	<p class="content_title"> <span > <label for="secondary_content_area">Secondary Content </label></span> here is nothin </p>	
	<?php wp_editor($secondary_content, 'secondary_content_area', array('textarea_name'=>'secondary_content'));?>

</div>