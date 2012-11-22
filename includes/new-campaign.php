<style>
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	
	.ui-tabs-nav{
		/*background-color: #7F7F7F;*/		
	}
</style>



<div class="wrap">	
	<div><img src="<?php echo $images['big'];?>" title="Conversion Sherif" onclick="return false"></div><hr/>
	<form action="" method="post">
		
		<div class="campaign-title">
			<label for="campaign-title">Campaing Name</label> <input id="campaign-title" name="campaign-title" value=""<?php echo 'aweful'; ?> />
		</div>
		
		<div id="tabs">
		
			<ul>
				<li><a href="#tabs-1">Content</a></li>
				<li><a href="#tabs-2">Cookie Settings</a></li>
				<li><a href="#tabs-3">Display Settings</a></li>
			</ul>
			
			<div id="tabs-1">
				<div class="editor-1">
					<p> <span>Primary Content :</span> </p>
					<?php wp_editor('First content', 'nothingboss');?>
					<?php //wp_editor('secnod content', 'nothingbossy');?>
				</div>			
			</div>
			
			
			
			
			
			<div id="tabs-2">
				Tab 2
			</div>
			
			<div id="tabs-3">
				Tab3
			</div>
			
		
		
						
						
			
		</div>
		
		
	
	</form>
		
</div>

<script>
	jQuery(function($) {
		/*	
		
		jQuery( "#tabs" ).tabs({ active: 0});
		jQuery( "#dialog-link, #icons li" ).hover(
				function() {
				jQuery( this ).addClass( "ui-state-hover" );
			},
			function() {
				jQuery( this ).removeClass( "ui-state-hover" );
			}
		);
		*/
	});
</script>

