jQuery(document).ready(function($){
	$( "#tabs" ).tabs({ active: 0});
	$( "#dialog-link, #icons li" ).hover(
			function() {
			$( this ).addClass( "ui-state-hover" );
		},
		function() {
			$( this ).removeClass( "ui-state-hover" );
		}
	);
});