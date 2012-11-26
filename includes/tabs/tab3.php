
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



<div class="content-area-div">
	
	<ul type="square">
		
		<li>
			<p class="text-before-textarea-big"> What Url's Do You Want Your Campaign To Appear On? </p>
			<p class="text-before-textarea-small"> (You can leave this section balnk if you are going to use the shortcode or widget area to display your campaign) </p>
			
			<p> <input type="checkbox" name="campaign-appering[]" value="1" id="everyurlsitewise" /> <label for="everyurlsitewise"> Every url sitewide </label></p>	
			<p> <input type="checkbox" name="campaign-appering[]" value="2" id="allpages" /> <label for="allpages"> All Pages</label> </p>	
			<p> <input type="checkbox" name="campaign-appering[]" value="3" id="allposts" /> <label for="allposts"> All posts </label> </p>	
			<p> <input type="checkbox" name="campaign-appering[]" value="4" id="postswiththefollowingtags" > <label for="postswiththefollowingtags">Posts with the following Tags </label> <br> (Seperate tags with comma) </p>			
			
			<textarea name="campaign-shown-tags" rows="5" cols="100" ></textarea>
			
		</li>
		
		<li>
			<p> <input type="checkbox" name="" id="followingpermalink"> <label for="followingpermalink"> The following permalinks </label><br> (Seperate tags with comma) </p>
			
			<textarea name="campaign-shown-permalinks" rows="5" cols="100" ></textarea>
			
		</li>
				
	</ul>
	
	<div class="">
		<p class="text-before-textarea-big"> Where abouts do you want your campaign to apper on your webpages? </p>
		
		<table class="form-table">
			<tr>
				<td> <input type="checkbox" name="campaignposition[]" value="1" id="topofheader" /> <label for="topofheader">Top of Header</label> </td>
				<td> <input type="checkbox" name="campaignposition[]" value="4" id="bottomofthecontent" > <label for="bottomofthecontent">Bottom of the content</label> </td>
			</tr>
			<tr>
				<td> <input type="checkbox" name="campaignposition[]" value="2" id="bottomofheader"><label for="bottomofheader"> Bottom of Header</label> </td>
				<td> <input type="checkbox" name="campaignposition[]" value="5" id="topofthefooter"><label for="topofthefooter"> Top of the footer</label> </td>
			</tr>
			<tr>
				<td> <input type="checkbox" name="campaignposition[]" value="3" id="topofthecontent" ><label for="topofthecontent"> Top of the content</label> </td>
				<td> <input type="checkbox" name="campaignposition[]" value="6" id="bottomofthefooter" ><label for="bottomofthefooter"> Bottom of the footer</label> </td>
			</tr>
		</table>
			
	</div>
	
	<div class="">
		<p class="text-before-textarea-big"> Want to display your campaign some where other than the above options? </p>
		<table class="form-table">
			<tr>
				<td> Cut and Paste this shot code any where on your site </td>
				<td> [Sample_code=1] </td>
			</tr>
			
		</table>
	</div>
		
</div>