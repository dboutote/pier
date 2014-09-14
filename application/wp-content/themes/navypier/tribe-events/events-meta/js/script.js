if (typeof jQuery === "undefined") {
    throw new Error("script.js requires jQuery");
}

jQuery(function ($) {

    "use strict";

	var $venue_table = $('#event_venue');
	
	var $addleventinfodiv = $('#addleventinfodiv');
	$('#tribe_events_event_details').after($addleventinfodiv);
	$('#tribe_events_event_options').hide();
	var $venue_select = $('select[name="venue[VenueID]"]');
	var $venue_lat = $('input[name="venue[Lat]"]');
	var $venue_long = $('input[name="venue[Long]"]');	
	
	if( $venue_select.length> 0 && '0' != $venue_select.val() ){
		$venue_lat.parent().hide();
		$venue_long.parent().hide();
	};
	
	$venue_select.on('change', function(){
		var selected_venue_id = $(this).val();
		
		// if they're selecting a new venue, clear out the current lat/long
		if( '0' == selected_venue_id ){
			 $venue_lat.val('').parent().show();
			 $venue_long.val('').parent().show();			 
		} else {
			 $venue_lat.parent().hide();
			 $venue_long.parent().hide();
		/*
			// ajax all the things
			var request = $.ajax({
				type : "POST",
				url : npem_scriptsJax.ajaxurl,
				data : {plugin: "events-meta", util_action: "get_venue_info", action:"setup_venue_info", post_id:selected_venue_id},
				dataType : 'json'
			}).done(function( response ) {
				// -1 means an error, 1 means success					
				if('1' === response.code) {
					 $venue_lat.val(response._VenueLat);
					 $venue_long.val(response._VenueLong);		
				}				
			}).fail(function(response){			
			}).always(function(){			
			});
		*/
		}
				


	});
	

	

});