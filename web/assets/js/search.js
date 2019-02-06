/**
 * 
 */
$(function() {

   interactionCategoryDefaults(InteractionCategories)
	
	
   $('.help_query').each(function() { // Notice the .each() loop, discussed below
        $(this).qtip({
            content: {
                text: $(this).next('div').html()
            },
    		position: {
    			my: 'top center',
    			at: 'bottom center'
    		},
    		style: {
    			classes: 'qtip-bootstrap',
    			tip: {
    				width: 10,
    				height: 8
    			}
    		},
            show: 'click',
            hide: 'unfocus'
        });
    });


	
    $( "#min_interaction_score" ).slider({

		step: 0.01,
        min: 0,
        max: 1,
        value: 0,
        change:function( event, ui ) {
          $("#search_min_interaction_score").val(ui.value);
        },
        slide: function( event, ui ) {
          $("#min_interaction_score_handle").html(ui.value);
        }
      });
    
    $("#min_interaction_score_handle").html($( "#min_interaction_score" ).slider( "value" ));
    $("#min_interaction_score").draggable();
	
    
    
    
    var tissueArray = ['adipose_subcutaneous', 'adipose_visceral_omentum', 'adrenal_gland', 'artery_aorta', 'artery_coronary', 'artery_tibial', 'brain_0', 'brain_1', 'brain_2', 'breast_mammary_tissue', 'colon_sigmoid', 'colon_transverse', 'esophagus_gastroesophageal_junction', 'esophagus_mucosa', 'esophagus_muscularis', 'heart_atrial_appendage', 'heart_left_ventricle', 'kidney_cortex', 'liver', 'lung', 'minor_salivary_gland', 'muscle_skeletal', 'nerve_tibial', 'ovary', 'pancreas', 'pituitary', 'prostate', 'skin', 'small_intestine_terminal_ileum', 'spleen', 'stomach', 'testis', 'thyroid', 'uterus', 'vagina', 'whole_blood'];

    tissueArray.forEach(function(tissue){
    	
    	
        $( "#" + tissue ).slider({
            
    		step: 0.01,
            min: 0,
            max: 22,
            value: 0,
            change:function( event, ui ) {
              $("#search_" + tissue).val(ui.value);
            },
            slide: function( event, ui ) {
              $("#" + tissue + "_handle").html(ui.value);
            }
          });
        
        $("#" + tissue + "_handle").html($( "#" + tissue ).slider( "value" ));
        $("#" + tissue).draggable();
    	
    	
    });

    var seperator = '';
    var invalidTerms = [];
    
	$("#search_identifier").autocomplete({
        	source: function(request, response){

        		var commaSpaceCount = (request.term.match(/,\s/g) || []).length;
				var commaCount = (request.term.match(/,/g) || []).length;
				var semicolonCount = (request.term.match(/;/g) || []).length;
				var newLineCount = (request.term.match(/\n/g) || []).length;
				var tabCount = (request.term.match(/\t/g) || []).length;
				var spaceCount = (request.term.match(/\s/g) || []).length;
				
				var seperatorCountArray = [commaSpaceCount, commaCount, semicolonCount, newLineCount, tabCount, spaceCount];     
				
				var maxValue = Math.max.apply(this, seperatorCountArray);
	
				// Get the index of the max value, through the built in function inArray
				var index = $.inArray(maxValue,seperatorCountArray);
				
				var seperatorArray = [', ', ',', ';', "\n", "\t", " "];

				seperator = seperatorArray[index];

				request.term = request.term.replace(/\n/g, ",");
				request.term = request.term.replace(/\t/g, ",");
				request.term = request.term.replace(/\s/g, ",");
				request.term = request.term.replace(/%20/g, ",");
				request.term = request.term.replace(/ /g, ",");

				urlAutocomplete = Url + 'app.php/autocomplete/' + request.term;

				$.getJSON(urlAutocomplete, function(data){					
					response(data.autocomplete);
				});

		},
		select: function(event,ui) { 
		    this.value=ui.item.value; 
		    $(this).trigger('change'); 
		    return false; 
		},
		minLength: 2,

	}).autocomplete( "instance" )._renderItem = function( ul, item) {

		item.value = item.value.replace(/,/g, seperator);
		

		
	  return $( "<li>" )
	    .attr( "data-value", item.value)
	    .append( item.label )
	    .appendTo( ul );
	};
	
	
	$( "#search_identifier" ).on("change keyup paste", validateSearchTerms);
	
	
	$( "#remove_invalid_terms" ).on("click", function(){
		
		var invalidTerms = $('#invalid_terms_array').attr('data');
		
		var searchIdentifierValue = $("#search_identifier").val();
		
		var invalidTermsArray = invalidTerms.split(",");
		
		var commaSpaceCount = (searchIdentifierValue.match(/,\s/g) || []).length;
		var commaCount = (searchIdentifierValue.match(/,/g) || []).length;
		var semicolonCount = (searchIdentifierValue.match(/;/g) || []).length;
		var newLineCount = (searchIdentifierValue.match(/\n/g) || []).length;
		var tabCount = (searchIdentifierValue.match(/\t/g) || []).length;
		var spaceCount = (searchIdentifierValue.match(/\s/g) || []).length;
		
		var seperatorCountArray = [commaSpaceCount, commaCount, semicolonCount, newLineCount, tabCount, spaceCount];     
		
		var maxValue = Math.max.apply(this, seperatorCountArray);

		var index = $.inArray(maxValue,seperatorCountArray);

		var seperatorArray = [', ', ',', ';', "\n", "\t", " "];
		
		var seperator = seperatorArray[index];
		
		searchIdentifierValue = searchIdentifierValue.replace(/\n/g, ",");
		searchIdentifierValue = searchIdentifierValue.replace(/\t/g, ",");
		searchIdentifierValue = searchIdentifierValue.replace(/\s/g, ",");
		searchIdentifierValue = searchIdentifierValue.replace(/%20/g, ",");
		searchIdentifierValue = searchIdentifierValue.replace(/ /g, ",");
		
		$.each(invalidTermsArray, function( index, value ){
					
			if(value != ''){
			var regex = new RegExp(value,"g");
			
			
			
			searchIdentifierValue = searchIdentifierValue.replace(regex, "");
			}
		});
		

		var searchIdentifierValueArray = searchIdentifierValue.split(",");
		
		searchIdentifierValueArray = cleanArray(searchIdentifierValueArray);
		
		searchIdentifierValue = searchIdentifierValueArray.join(seperator);
		

		$("#search_identifier").val(searchIdentifierValue);
		
		
		validateSearchTerms();
		
		
	});
	
	

    $( "#example_1" ).on("click", function(){
    	$( "#search_query_query" ).prop('checked', false);
    	$( "#search_text_output" ).prop('checked', false);
    	$( "#search_published" ).prop('checked', true); 
       	$( "#search_validated" ).prop('checked', true); 
		$( "#search_verified" ).prop('checked', true); 
		$( "#search_literature" ).prop('checked', true);  
		$("#advanced_search").collapse("hide");
    });

    $( "#example_2" ).on("click", function(){
    	$( "#search_query_query" ).prop('checked', true);
    	$( "#search_text_output" ).prop('checked', false);
    	$( "#search_published" ).prop('checked', true); 
       	$( "#search_validated" ).prop('checked', true); 
		$( "#search_verified" ).prop('checked', true); 
		$( "#search_literature" ).prop('checked', true);  
		$("#advanced_search").collapse("show");

    });
        
    $( "#example_3" ).on("click", function(){
    	$( "#search_query_query" ).prop('checked', false);
    	$( "#search_text_output" ).prop('checked', true);
    	$( "#search_published" ).prop('checked', true); 
       	$( "#search_validated" ).prop('checked', true); 
		$( "#search_verified" ).prop('checked', true); 
		$( "#search_literature" ).prop('checked', true);  
		$("#advanced_search").collapse("show");

    });
    
    

    $("#advanced_search").on("hide.bs.collapse", function(){
	    $("#advanced").html('Advanced');

	});
	  $("#advanced_search").on("show.bs.collapse", function(){
	    $("#advanced").html('Basic');
	
	  });
	
});


function interactionCategoryDefaults(InteractionCategories){
	
	$.each(InteractionCategories, function (index, interaction_category) {
		var selected_by_default = interaction_category[2];	
		if(selected_by_default == 0){
			var id = 'search_' + interaction_category[1]
			$('#' + id).prop('checked', false);
		}
	});
}


function cleanArray(actual) {
	  var newArray = new Array();
	  for (var i = 0; i < actual.length; i++) {
	    if (actual[i]) {
	      newArray.push(actual[i]);
	    }
	  }
	  return newArray;
	}

function getSeperator(searchIdentifierValue) {
	
	var commaSpaceCount = (searchIdentifierValue.match(/,\s/g) || []).length;
	var commaCount = (searchIdentifierValue.match(/,/g) || []).length;
	var semicolonCount = (searchIdentifierValue.match(/;/g) || []).length;
	var newLineCount = (searchIdentifierValue.match(/\n/g) || []).length;
	var tabCount = (searchIdentifierValue.match(/\t/g) || []).length;
	var spaceCount = (searchIdentifierValue.match(/\s/g) || []).length;
	
	var seperatorCountArray = [commaSpaceCount, commaCount, semicolonCount, newLineCount, tabCount, spaceCount];     
	
	var maxValue = Math.max.apply(this, seperatorCountArray);

	var index = $.inArray(maxValue,seperatorCountArray);

	var seperatorArray = [', ', ',', ';', "\n", "\t", " "];
	
	var seperator = seperatorArray[index];
	
	return seperator;
}


function validateSearchTerms() {
    
	var searchIdentifierValue = "/" + $("#search_identifier").val();
	
	
	searchIdentifierValue = searchIdentifierValue.replace(/\n/g, ",");
	searchIdentifierValue = searchIdentifierValue.replace(/\t/g, ",");
	searchIdentifierValue = searchIdentifierValue.replace(/\s/g, ",");
	searchIdentifierValue = searchIdentifierValue.replace(/%20/g, ",");
	searchIdentifierValue = searchIdentifierValue.replace(/ /g, ",");
	
	var urlTermValidation = '';
	

	if(searchIdentifierValue == '/'){
		
		urlTermValidation = Url + 'app.php/term_validation';
	}else{
		
		urlTermValidation = Url + 'app.php/term_validation' + searchIdentifierValue;
	}
	
	var termCountArray = searchIdentifierValue.split(",");
	var termCount = termCountArray.length;


	
	$.getJSON(urlTermValidation, function(data){
		

		var invalidTermsString = '';
		var invalidTerms = '';
		$.each(data, function (index, value) {
			
			invalidTermsString  = invalidTermsString + ',' + value;
			
			invalidTerms = invalidTerms + '<div class="row" style="margin:0px;">' + value  + '</div>';
		});
		
		var invalidTermCount = data.length;
		var validTermCount = termCount - invalidTermCount;	
		
		invalidTermsString = invalidTermsString.replace(/^,/, "");
		if(invalidTerms){
			
			$("#all_terms_valid").addClass('hidden');
			$(".search_terms_not_found").removeClass('hidden');
			$("#invalid_terms_array").removeClass('hidden');
			$("#remove_invalid_terms").removeClass('hidden');
			$("#invalid_terms_array").attr('data', invalidTermsString);
			$("#invalid_terms_array").html(invalidTerms);
			$(".number_present_terms").html(validTermCount);
			$(".number_not_present_terms").html(invalidTermCount);

		}else{
			
			if($("#search_identifier").val() != ''){

				$("#all_terms_valid").removeClass('hidden');
			}
			
			$(".search_terms_not_found").addClass('hidden');
			$("#invalid_terms_array").addClass('hidden');                			
			$("#remove_invalid_terms").addClass('hidden');
			$(".number_present_terms").html(validTermCount);
			
		}
		
		
		
	});
}