<?php 
	if($post){
		$post_meta = get_post_custom($post->ID);
		//var_dump($post_meta);
		$terms = wp_sherif_conversion_db::get_records_from_display_table($post->ID, 'tag');
		$permalinks = wp_sherif_conversion_db::get_records_from_display_table($post->ID, 'permalink');
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
	
	.campaign_code_cpy{
		color: #1E90FF;		
	}
	
</style>

<!-- tab identifier -->
<input type="hidden" name="tab_number" value="3" />

<div class="content-area-div">
	
	<ul type="square">
		
		<li>
			<p class="text-before-textarea-big"> What Url's Do You Want Your Campaign To Appear On? </p>
			<p class="text-before-textarea-small"> (You can leave this section balnk if you are going to use the shortcode or widget area to display your campaign) </p>
			
			<p> <input <?php checked('Y', $post_meta["display-site-wise"][0]);?> type="checkbox" name="display-site-wise" value="Y" id="everyurlsitewise" /> <label for="everyurlsitewise"> Every url sitewide </label></p>	
			<p> <input  <?php checked('Y', $post_meta["display-allpages"][0]);?> type="checkbox" name="display-allpages" value="Y" id="allpages" /> <label for="allpages"> All Pages</label> </p>	
			<p> <input  <?php checked('Y', $post_meta["display-allposts"][0]);?> type="checkbox" name="display-allposts" value="Y" id="allposts" /> <label for="allposts"> All posts </label> </p>	
			<p> <input  <?php checked('Y', $post_meta["display-following-tags"][0]);?> type="checkbox" name="display-following-tags" value="Y" id="postswiththefollowingtags" > <label for="postswiththefollowingtags">Posts with the following Tags </label> (Seperate tags with comma) </p>			
			
			<textarea name="campaign-shown-tags" rows="5" cols="100" ><?php echo $terms; ?></textarea>
			
		</li>
				
		 	
	</ul>
	
	<div class="">
		<p class="text-before-textarea-big"> Where abouts do you want your campaign to apper on your webpages? </p>
		
		<table class="form-table">
			<tr>
				<td> <input  <?php checked('Y', $post_meta['display-top-header'][0]);?> type="checkbox" name="display-top-header" value="Y" id="topofheader" /> <label for="topofheader">Top of Header</label> </td>
			</tr>
			
			<tr>
				<td> <input  <?php checked('Y', $post_meta['display-top-content'][0]);?> type="checkbox" name="display-top-content" value="Y" id="topofthecontent" ><label for="topofthecontent"> Top of the content</label> </td>
			</tr>
			
			<tr>
				<td> <input <?php checked('Y', $post_meta['display-top-footer'][0]);?> type="checkbox" name="display-top-footer" value="Y" id="topofthefooter"><label for="topofthefooter"> Footer</label> </td>
			</tr>
			
			<tr>
				<td> <input  <?php checked('Y', $post_meta['display-above-commentarea'][0]);?> type="checkbox" name="display-above-commentarea" value="Y" id="display-above-commentarea" ><label for="display-above-commentarea"> Above Comment area</label> </td>
			</tr>			
			
		</table>
			
	</div>
	
	<div class="">
		<p class="text-before-textarea-big"> Want to display your campaign some where other than the above options? </p>
		<table>
			<tr>
				<td> Cut and Paste this shot code any where on your site </td>
				<td class="campaign_code_cpy"> <input type="text" readonly value="[Campaign_Code id=<?php echo $post->ID;?>]" />  </td>
			</tr>
			
		</table>
	</div>
		
</div>