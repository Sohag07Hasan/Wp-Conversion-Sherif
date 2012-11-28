<?php 
	if($post){
		
	}
?>



<style>
	.content_title span{
		font-size: 20px;
	}
	.content_title{
		margin-top: 20px;
	}
	
	.header{
		font-size: 25px;
	}
	
	.content_area_div{
	/*	text-align: center; */
	}
	
	.text-before-textarea-big{
		font-size: 19px;
	}
	
	.text-before-textarea-small{
		font-size: 11px;
	}
	
	.cookie-hours{
		margin-top: 20px;
	}
	
	.text-before-textarea-small span{
		padding: 10px;
	}
	
</style>


<input type="hidden" name="tab_number" value="2" />

<div class="content_area_div">
	
	<h2 class="content_title header"> The Cookie For this will be set when the visitor .... </h2>
	
	<ul type="square">
		
		<li>
			<p class="text-before-textarea-big"> <input id="cookie-excludes-checkbox" type="checkbox" name="cookie-excludes-checkbox" value="Y" '> <label for="cookie-excludes-checkbox">... Visits anywhere on this website. Excluding the following permalinks or tags</label> </p>
			<p class="text-before-textarea-small"> Add any permalinks or post tags that you want to exclude from this (<code>Seperate each with comma</code>) <br/> (<code>Leave blank if you don't want to exclude any urls from this rule</code>) </p>
			
			<textarea name="cookie-excludes" rows="5" cols="103" ></textarea>
			
		</li>
		
		<li>
			<p class="text-before-textarea-big"> <input id="cookie-includes-checkbox" type="checkbox" name="cookie-includes-checkbox" value="Y" '> <label for="cookie-includes-checkbox">...lands on a post with the following tags / categories </label> </p>
			<p class="text-before-textarea-small"> Add any tags/categories that you want to set the cookie (<code>Seperate each with a comma</code>) </p>
			
			<textarea name="cookie-includes" rows="5" cols="103" ></textarea>
			
		</li>
		
		<li>
			<p class="text-before-textarea-big"> <input id="cookie-includes-post-checkbox" type="checkbox" name="cookie-includes-post-checkbox" value="Y" '><label for="cookie-includes-post-checkbox">...lands on a post/page with the following permalinks  </label></p>
			<p class="text-before-textarea-small"> Add any permalinks that you want to set the cookie (<code>Seperate each with comma</code>) </p>
			
			<textarea name="cookie-excludes" rows="5" cols="103" ></textarea>
			
		</li>
		
	</ul>
	
	
	<div class="cookie-hours">
		<p class="text-before-textarea-big"> How long do you want the cookie last </p>
		<p class="text-before-textarea-small">
			<span><input id="24hours" type="radio" name="cookie-time" value="1"> <label for="24hours">24 Hours</label></span>
			<span><input id="1week" type="radio" name="cookie-time" value="2"> <label for="1week"> 1 Week </label></span>  
			<span><input id="1month" type="radio" name="cookie-time" value="3"> <label for="1month"> 1 Month </label></span>  
			<span><input id="1year" type="radio" name="cookie-time" value="4"> <label for="1year">1 Year </label></span>    
		</p>
	</div>
	
	
</div>