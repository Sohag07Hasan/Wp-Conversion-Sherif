<style>
	.campaign-anchor button{
		font-size: 20px;
		padding	: 5px;
		background-color: #8888E3;
		cursor: pointer;
	}
	
	.campaign-anchor{
		text-decoration: none;	
	}
	
	div.create-new{
		margin-bottom: 20px;		
	}
	
	.campaign-table td{
		padding: 5px;
	}
	
</style>


<div class="wrap">
	
	<div><img src="<?php echo $images['big'];?>" title="Conversion Sherif" onclick="return false"></div><hr/>
	
	
	<div class="create-new">
		<?php $create_newlink = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new');?>
		<a class="campaign-anchor" href="<?php echo $create_newlink; ?>"> <button >Create New Campaign</button> </a>
	</div>
	
	<table class="widefat campaign-table">
		<thead>
			<tr> 
				<td>Your Campaigns</td> <td> Shortcode </td>
			</tr>
		</thead>
		
		<tbody>
			<tr> 
				<td>Your Campaigns</td> <td> Shortcode </td>
			</tr>
		</tbody>
	</table>

</div>