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
		padding: 10px;
	}
	
	.campaign-delete{
		color: #FF0000;
	}
	
	.campaign-table input{
		font-size: 12px;
	}
	
</style>


<div class="wrap">
	
	<div><img src="<?php echo $images['big'];?>" title="Conversion Sherif" onclick="return false"></div><hr/>
	
	<?php 
		if($_GET['action'] == 'del'){
			echo "<div class='updated'><p>Campaign deleted ..</p></div>";
		}
	?>
	
	<div class="create-new">
		<?php $create_newlink = admin_url('admin.php?page=wp_conversion_sherif_menu&action=new');?>
		<a class="campaign-anchor" href="<?php echo $create_newlink; ?>"> <button >Create New Campaign</button> </a>
	</div>
	
	<table class="widefat campaign-table">
		<thead>
			<tr> 
				<th>Your Campaigns</th> <th> Shortcode </th>
			</tr>
		</thead>
		
		<tbody>
			<?php if($campaigns):?>
				
				<?php $action_link = admin_url('admin.php?page=wp_conversion_sherif_menu'); ?>				
				<?php foreach($campaigns as $campaign) :?>
					<tr>
						<td> 
							<?php echo $campaign->post_title; ?> <br/>
							 <a class="campaign-edit" href="<?php echo $action_link . '&action=new&cid=' . $campaign->ID; ?>">edit</a> | <a class="campaign-delete" href="<?php echo $action_link . '&action=del&cid=' . $campaign->ID; ?>">delete</a>
						</td>
						<td> <input readonly type="text" value="<?php echo "[Campaign_Code id={$campaign->ID}]"; ?>" /> </td>
					</tr>
				<?php endforeach;?>				
			
			<?php endif;?>
		</tbody>
	</table>

</div>