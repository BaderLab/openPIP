/**
 * 
 */



	
 	$(".interaction_network_row").on("click", function(){
 		

 		$('.interaction_network_row').each(function(){ $(this).css('background', '#ffffff');});
	 	$(this).css('background', '#d9d9d9');
 	}
 	);
 	
 	$(".interaction_network_row").each(function() { 
	     $(this).qtip({
	         content: {
	             text: $(this).next('div').html()
	         },
	 		position: {
	 			viewport: $(window),
	 			my: 'left center',
	 			at: 'right center'
	 		},
	 		style: {
	 			classes: 'qtip-bootstrap',
	 			tip: {
	 				width: 16,
	 				height: 8
	 			}
	 		},
	         show: 'click',
	         hide: 'unfocus'
	     });
	 });

 	
 	$("#new_updates").on("click", function(){
 		
 		$("#add_new_network_form").toggleClass("hidden");
 		$("#new_updates").toggleClass("hidden");
 		$("#no_new_updates").toggleClass("hidden");
 		
 	});
 	
 	$("#no_new_updates").on("click", function(){
 		
 		$("#add_new_network_form").toggleClass("hidden");
 		$("#new_updates").toggleClass("hidden");
 		$("#no_new_updates").toggleClass("hidden");
 		
 	});
 	

 	
 	
 	
 	
 	