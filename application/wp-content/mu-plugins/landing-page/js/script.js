if (typeof jQuery === "undefined") {
    throw new Error("script.js requires jQuery");
}

jQuery(function ($) {

    "use strict";
	
	var $landpagediv = $('#landingpagediv');
	$('#pageparentdiv').after($landpagediv);

	var $tax_select = $('select[name="entries_tax"]');
	var $taxplaceholder = $('#taxplaceholder');
	var $template_select = $('select[name="page_template"]');

	$landpagediv.removeClass('hide-if-js');
	
	if( 'page-landing-page.php' != $template_select.val() ){
		$landpagediv.hide();
	}
	

	$template_select.on('change', function(){
		var selected_type = $(this).val();
		if( 'page-landing-page.php' === selected_type ){
			$landpagediv.fadeIn();
		} else {
			$landpagediv.fadeOut();
		}
	});


	$('select[name="entries_type"]').on('change', function(){
		var selected_type = $(this).val();
				
		// ajax all the things
		var request = $.ajax({
			type : "POST",
			url : lpJax.ajaxurl,
			data : {plugin: "landing-page", util_action: "get_type_taxonomies", action:"setup_type_taxonomies", post_type:selected_type},
			dataType : 'json'
		}).done(function( response ) {
			// -1 means an error, 1 means success	
			if('-1' === response.code) {
				$taxplaceholder.fadeOut(function(){
					$('option:not(:first)', $tax_select).remove();
				});
			}
			
			if('1' === response.code) {
				$taxplaceholder.fadeOut(function(){
					$tax_select.empty().append(response.notice);
					$(this).fadeIn();
				});											
			}
			
		}).fail(function(response){			
		}).always(function(){			
		});

	});
	

	

});