

var allInteractionArray = SearchResultsJSON['edges'];
var allProteinArray = SearchResultsJSON['nodes'];
var allDomainArray = SearchResultsJSON['domains'];


var allComplexArray = SearchResultsJSON['complexes']['complex'];
var allProteinComplexArray = SearchResultsJSON['complexes']['protein_complex'];
var allComplexProteinArray = SearchResultsJSON['complexes']['complex_protein'];

var queryProteinIdArray = SearchResultsJSON['query_protein_id_array'];
var searchTerm = SearchResultsJSON['search_term'];

var proteinOfIntrestName = '';
var Layout = 'cola';
if(allInteractionArray.length > 800){Layout = 'cose';}
var currentProteinArray = allProteinArray;
var currentInteractionArray = allInteractionArray;
var cy = '';	
enableScroll();
if(TextOutput == 'text_output' || allInteractionArray.length > 8000){
	filterProteinsAndInteractions();
	setTextOutput();
}else{

 	setNetworkTableEvent();
	setMinimizeAndMaximizeClickEvents();
	setReactomeLinkClickEvent();
	setCategoryCheckboxEvents();
	setTissueExpressionCheckboxEvents();
	setScoreSliderEvent();
	setDownloadEvents();
	createInteractionTable();
	setNodeAndEdgeSummayValues();
	var cy = updateCytoscapeNetwork();

	$(".description").readmore({lessLink: "<a>Read less</a>"});
	$('.footable').trigger('footable_initialized');
	
	
	
}


//*****************************************************************************************//

function updateCytoscapeNetwork(){
	
	var currentProteinAndInteractionArray = filterProteinsAndInteractions();
	var cytoscapeJSON = createCytoscapeJSON();
	displayMessageIfNoInteractions();

	cy = createCytoscapeNetwork(cytoscapeJSON);

 	updateInteractionsTable();
 	addCytoscapeQtips(cy);
 	addInteractorQtips();
 	setNodeAndEdgeSummayValues();
 	updateEnrichedTerms();
 	setLayoutClickEvent(cy);
 	updateExternalLinks();
 	setPanZoomForNonMobile(cy);
 	setCytoscapeExportForNonMobile();
 	setPngDownloadClickEvent(cy);
 	setInteractionRowClickEvent(cy);
 	setEnrichmentRowClickEvent(cy);
 	setNodeHoveEvent(cy)
 	setFootable();
 	reloadPageSize();
 	setCytoscapeExportEvents();
 	

	return cy;

}

//*****************************************************************************************//

function createCytoscapeJSON(){
	
	var nodesJSON = new Object();
	var edgesJSON = new Object();
	
	nodesJSON = [];
	edgesJSON = [];
	
	var complexesContainingMoreThanOneInteractor = getComplexesContainingMoreThanOneInteractor();	
	
	for (j = 0; j < complexesContainingMoreThanOneInteractor.length; ++j) {

		var complex_id = complexesContainingMoreThanOneInteractor[j];
		
		var complex = allComplexArray[complex_id];
		
		var complexId = complex['complex_id'];
		var complexName = complex['name'];
		var complexDescription = complex['description'];
		
		nodesJSON.push({id: complexId, data: { id: complexId}, style: { "label": complexName, 'background-color': '#A041F2'}, classes: "nodes"});
	}
	
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var proteinName = currentProteinArray[i].protein_uniprot_id;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinDescription = currentProteinArray[i].protein_description;
 		var linkArray = currentProteinArray[i].protein_external_links;
 		var tissueExpressionArray = currentProteinArray[i].tissue_expression_array;
 		var subcellularLocationExpressionArray = currentProteinArray[i].subcellular_location_expression_array;
 		var nodeProteinId = proteinId;
 		
 		if(jQuery.isEmptyObject(subcellularLocationExpressionArray) == true){
 			
 			subcellularLocationExpressionArray = {};
 		}
 		if(jQuery.isEmptyObject(tissueExpressionArray) == true){
 			
 			tissueExpressionArray = {};
 		}

		if(proteinId in allDomainArray ){

			var domain = allDomainArray[proteinId];
			var domainType = domain.type;

 			nodesJSON.push({id: nodeProteinId, group: "nodes",data: { id: nodeProteinId, name: geneName, uniprot_id: uniprotId, ensembl_id: ensemblId, entrez_id: entrezId, protein_name: proteinName, gene_name: geneName, description: proteinDescription, external_links: linkArray, tissue_expression_array: tissueExpressionArray, subcellular_location_expression_array: subcellularLocationExpressionArray, query: 'non-query'}, classes: "nodes has_domain"},);
 			
			var proteinDomainArray = allDomainArray[proteinId];

			$.each(proteinDomainArray, function( index, domain ) {

				var domainType = domain.type;

	 			nodesJSON.push({id: nodeProteinId + '_domain_' + domainType, group: "nodes",data: {id: nodeProteinId + '_domain_' + domainType, parent: nodeProteinId, type: domainType}, classes: "domains"});

			});
 		}else{
 			nodesJSON.push({id: nodeProteinId, group: "nodes",data: { id: nodeProteinId, name: geneName, uniprot_id: uniprotId, ensembl_id: ensemblId, entrez_id: entrezId, protein_name: proteinName, gene_name: geneName, description: proteinDescription, external_links: linkArray, tissue_expression_array: tissueExpressionArray, subcellular_location_expression_array: subcellularLocationExpressionArray, query: 'non-query'}, classes: "nodes"},);
 		}
		
		if(allProteinComplexArray){
	 		if(proteinId in allProteinComplexArray ){
	 		 	
				var complexesForProtein = allProteinComplexArray[[proteinId]];
	
				for (j = 0; j < complexesForProtein.length; ++j) {
					var complex_id = complexesForProtein[j];
					if(complexesContainingMoreThanOneInteractor.indexOf(complex_id) != -1){
						
						var complex = allComplexArray[complex_id];
						
						var complexId = complex['complex_id'];
						var complexName = complex['name'];
						var complexDescription = complex['description'];
						
				 		edgesJSON.push({
							group: "edges",
							data: { id: complexId + '_' + nodeProteinId, name: complexName, source: complexId, target: nodeProteinId},
							style: { "line-color": '#A041F2', 'line-style': 'dashed'},
				 		});
					}			
				}
	 		}
		}
 	}

 	for (i = 0; i <  currentInteractionArray.length; ++i) {
 		var interactionId = currentInteractionArray[i]['interaction_id']
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceProteinName = currentInteractionArray[i]['interactor_A']['protein_uniprot_id'];
 		var sourceProteinGeneName = currentInteractionArray[i]['interactor_A']['protein_gene_name'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
 		var targetProteinName = currentInteractionArray[i]['interactor_B']['protein_uniprot_id'];
 		var targetProteinGeneName = currentInteractionArray[i]['interactor_B']['protein_gene_name'];
 		var scoreData = currentInteractionArray[i]['score'];
 		var experimentArray = currentInteractionArray[i]['experiment_array'];
 		
		var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];

 		var sourceNodeId = sourceProteinId;
 		var lineColor = '';
 		if(typeof CategoryArray[highestCategoryStatus] !== "undefined"){
 			lineColor = CategoryArray[highestCategoryStatus]['color_scheme'];
 		}else{
 			lineColor = "#ccc";	
 		}
 		
 		var targetNodeId = targetProteinId;
 		var edgeID = sourceProteinId + "_" + targetProteinId;
 		widthData = getEdgeWidth(scoreData);
 		
 		if(sourceNodeId in allDomainArray){
 			
			var proteinDomainArray = allDomainArray[sourceNodeId];
			$.each(proteinDomainArray, function( index, domain ) {
				if(interactionId == domain.interaction_id){
				var domainType = domain.type;
				sourceNodeId = sourceNodeId + '_domain_' + domainType;
				}
			});

 		}

 		edgesJSON.push({
			group: "edges",
			data: { id: edgeID, name: sourceProteinGeneName + ' - ' + targetProteinGeneName, source: sourceNodeId, target: targetNodeId, interaction: sourceProteinGeneName + ' - ' + targetProteinGeneName, score: scoreData, experiment_array: experimentArray, highest_category_status: highestCategoryStatus},
			style: { "line-color": lineColor, 'width': widthData},		
 		});
 		
 	}
 	
 	console.log(edgesJSON);
 	var cytoscapeJSON = nodesJSON.concat(edgesJSON);
	
	return cytoscapeJSON;
}

function createCytoscapeNetwork(cytoscapeJSON){
	
	cy = cytoscape({	
		container: document.getElementById('cy'),
	  	elements: cytoscapeJSON,

	  	style: [{
 				selector: '.nodes',
 				css: 
 				{
                     'content': 'data(gene_name)',
                     'text-valign': 'center',
                     'color': 'white',
                     'text-outline-width': 2,
                     'padding-top': '10px',
                     'padding-left': '10px',
                     'padding-bottom': '10px',
                     'padding-right': '10px',
                     'background-color': InteractorNodeColor
     			}
 			},
 			{
 				selector: '.has_domain',
 				css: 
 				{
                     'content': 'data(gene_name)',
                     'text-valign': 'top',
     			}
 			},
 			
 			
 			
	  		{
				selector: '.domains',
				css: 
				{
                 'content': 'data(type)',
                 'text-valign': 'center',
                 'color': 'white',
                 'text-outline-width': 2,
                 'padding-top': '10px',
                 'padding-left': '10px',
                 'padding-bottom': '10px',
                 'padding-right': '10px',
                 'background-color': '#CCCCCC'
 			   }
			},
            {
             	selector: '.edge',
             	css: 
                 {
             	  'line-color' : '#AAAAAA'
             	}
	}]});
	
	var api = cy.expandCollapse({
		fisheye: true,
		animate: true,
		undoable: false
	});

	
	cy.nodes().on("expandcollapse.aftercollapse", function(event) { var node = this;  node.style({'text-valign': 'center', 'border-width': '3px', 'border-color': '#A041F2'})});
	cy.nodes().on("expandcollapse.afterexpand", function(event) { var node = this;  node.style({'text-valign': 'top', 'border-width': '3px', 'border-color': '#A041F2' })});
	api.collapseAll();
	
	var layoutRun =  cy.layout({ 
		name: Layout,
		avoidOverlap: true,
		equidistant: true,
		minNodeSpacing: 50,
 		randomize: true,
 		fit: true,
	 		nodeRepulsion       : 10000,
 	 		nodeOverlap         : 100,

	});
	layoutRun.run();
	setQueryNodeColor(cy);
	cy.minZoom(0.1);
	return cy;
}




function getComplexesContainingMoreThanOneInteractor(){

	var complexContainingOneInteractorArray = [];
	var complexesContainingMoreThanOneInteractorArray = [];
	
	for (i = 0; i < currentProteinArray.length; ++i) {	
		var proteinId = currentProteinArray[i].protein_id;
		if(allProteinComplexArray){
		if(proteinId in allProteinComplexArray){	
			var complexesForProtein = allProteinComplexArray[proteinId];
			for (j = 0; j < complexesForProtein.length; ++j) {	
				complexContainingOneInteractorArray.push(complexesForProtein[j]);	
			}
		}
		}
	}	
	
	var complexesContainingMoreThanOneInteractorArray = complexContainingOneInteractorArray.reduce(function(list, item, index, array) { 
		  if (array.indexOf(item, index + 1) !== -1 && list.indexOf(item) === -1) {
		    list.push(item);
		  }
		  return list;
		}, []);

	
	return complexesContainingMoreThanOneInteractorArray;
}










//*****************************************************************************************//

function filterProteinsAndInteractions(){

	currentProteinArray = filterProteinTissueExpression();	
	currentProteinArray = Array.from(new Set(currentProteinArray));
	
	currentInteractionArray = filterInteractionCatagoryAndScore();	
	currentInteractionArray = Array.from(new Set(currentInteractionArray));	

	currentInteractionArray = filterInteractionsWithMissingProteins(currentProteinArray, currentInteractionArray);	
	currentInteractionArray = Array.from(new Set(currentInteractionArray));	

	currentInteractionArray = filterInteractionsNotIncludingQueryProteins(currentInteractionArray);

	
	
	currentProteinArray = filterProteinsWithNoInteractions(currentProteinArray, currentInteractionArray);	
	currentProteinArray = Array.from(new Set(currentProteinArray));


}


function updateInteractionsTable(){

	for (i = 0; i <  allInteractionArray.length; ++i) {
		
 		var sourceProteinId = allInteractionArray[i]['interactor_A']['protein_id'];
 		var targetProteinId = allInteractionArray[i]['interactor_B']['protein_id'];
		var interactionID = sourceProteinId  + "_" + targetProteinId;

		$("#" + interactionID).detach().appendTo("#hide_rows");
	}
	
	for (i = 0; i <  currentInteractionArray.length; ++i) {
		
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		var interactionID = sourceProteinId  + "_" + targetProteinId;		
		var Interaction = currentInteractionArray[i]['experiment_array']['interaction'];
		var Score = currentInteractionArray[i]['experiment_array']['score'];
		var experimentArray = currentInteractionArray[i]['experiment_array'];	
		var experimentString = '';
		$.each(experimentArray, function(i, experiment){
			
			experimentString = experimentString + '<div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Dataset</h4></div><div class="row">' + experiment['dataset'] + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Orientation</h4></div><div class="row">DNA Binding Domain: ' + experiment['dna_binding_domain_name'] + '</div><div class="row">Activation Domain: ' + experiment['activation_domain_name'] + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Open Reading Frames</h4></div><div class="row">Open Reading Frame of Interactor A: ' + experiment['orf_id_A'] + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Assay Version</h4></div><div class="row">This interaction was identified in assay version ' + experiment['assay_version'] + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Screens</h4></div><div class="row">This interaction was identified in' + experiment['orf_id_B'] + ' Screens;</div></div>';

		});
		
		$("#" + interactionID).detach().appendTo("#interaction_rows");		
		$("." + interactionID).qtip({
			content: function(){
					return '<div class="container" style="padding-top: 20px; width: 100%; max-width: 540px;"><div class="row" style="margin-bottom: 20px;"><div class="col-sm-10"><h3 style="font-weight: bold; color:'  + ';">'  + '</h3><div class="shadow"></div></div></div><div class="col-sm-7"><div class="row">Confidence Score: ' + Score + '</div>' + '</div>';
			},
			position: {
			   my: 'center',
			   at: 'center',
			   target: $(window),
			   viewport: $('#cy')
			},
			style: {
				classes: 'qtip-bootstrap',
				tip: {
					width: 16,
					height: 8
				}
			}
		});
	}
	if(currentInteractionArray.length == 0){
		$('#interaction_rows').prepend('<p style="margin-top: 10px;">No Interactions Found</p>');
	}
	
	
	

}

//*****************************************************************************************//

function filterProteinsWithNoInteractions(){
	
	currentProteinArray2 = [];
	
 	for (i = 0; i < currentProteinArray.length; ++i) {	
 		var proteinId = currentProteinArray[i].protein_id;
 		for (j = 0; j < currentInteractionArray.length; ++j) {
 			var sourceProteinId = currentInteractionArray[j]['interactor_A']['protein_id'];
 			var targetProteinId = currentInteractionArray[j]['interactor_B']['protein_id'];
 			if(sourceProteinId == proteinId || targetProteinId == proteinId){				
 				currentProteinArray2.push(currentProteinArray[i]); 				
 			}
 		}
 	}
 	
 	return currentProteinArray2;	
}


function filterInteractionsWithMissingProteins(){

	var currentInteractionArray2 = [];

	for (i = 0; i <  currentInteractionArray.length; ++i) {
		
		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		
		var interactorA = false;
		var interactorB = false;
				
		for (j = 0; j < currentProteinArray.length; ++j) {
			var proteinId = currentProteinArray[j].protein_id;
			if(proteinId == sourceProteinId){
				interactorA = true;
			}
			if(proteinId == targetProteinId){	
				interactorB = true;
			}
		}

		if(interactorA == true && interactorB == true){
			currentInteractionArray2.push(currentInteractionArray[i]);
		}
	
	}
	
	return currentInteractionArray2;
}

function filterInteractionsNotIncludingQueryProteins(){
	
	var currentInteractionArray2 = [];
	var queryProteinInteractorArray = [];
	
	for (i = 0; i <  queryProteinIdArray.length; ++i) {
		queryProteinInteractorArray.push('' + queryProteinIdArray[i] + '');
	}
	
	
	
	for (i = 0; i <  currentInteractionArray.length; ++i) {
		
		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		
		if ($.inArray(sourceProteinId, queryProteinIdArray) != -1 || $.inArray(targetProteinId, queryProteinIdArray) != -1 ){

			queryProteinInteractorArray.push(sourceProteinId);
			queryProteinInteractorArray.push(targetProteinId);
			
		} 
		
		
	}

	queryProteinInteractorArray = Array.from(new Set(queryProteinInteractorArray));

	
	for (i = 0; i <  currentInteractionArray.length; ++i) {
		
		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];

		if ($.inArray(sourceProteinId, queryProteinInteractorArray) != -1 && $.inArray(targetProteinId, queryProteinInteractorArray) != -1){

			currentInteractionArray2.push(currentInteractionArray[i]);
			
		} 
	}
	
	return currentInteractionArray2;
}

function filterProteinTissueExpression(){

	var currentProteinArray = [];
	
	for (i = 0; i < allProteinArray.length; ++i) {

		var proteinId = allProteinArray[i].protein_id;
		var proteinName = allProteinArray[i].protein_uniprot_id;
		var geneName = allProteinArray[i].protein_gene_name;
		var proteinDescription = allProteinArray[i].protein_description;
		var linkArray = allProteinArray[i].protein_external_links;
		var tissueExpressionArray = allProteinArray[i].tissue_expression_array;
	    var tissueArray = ['adipose_subcutaneous', 'adipose_visceral_omentum', 'adrenal_gland', 'artery_aorta', 'artery_coronary', 'artery_tibial', 'brain_0', 'brain_1', 'brain_2', 'breast_mammary_tissue', 'colon_sigmoid', 'colon_transverse', 'esophagus_gastroesophageal_junction', 'esophagus_mucosa', 'esophagus_muscularis', 'heart_atrial_appendage', 'heart_left_ventricle', 'kidney_cortex', 'liver', 'lung', 'minor_salivary_gland', 'muscle_skeletal', 'nerve_tibial', 'ovary', 'pancreas', 'pituitary', 'prostate', 'skin', 'small_intestine_terminal_ileum', 'spleen', 'stomach', 'testis', 'thyroid', 'uterus', 'vagina', 'whole_blood'];
	  	var removeProtein = false;

		if(removeProtein == false){
	 		tissueArray.forEach(function(tissue){
	 			if(TissueExpressionParameterArray[tissue]){
		        	if( 5.0 > tissueExpressionArray[tissue]){
		        		removeProtein = true;		
		        	} 
	 			}
	        });
		}
		
		if(removeProtein== false){
			
			currentProteinArray.push(allProteinArray[i]);
		}
	}
	
	return currentProteinArray;
}

function filterInteractionCatagoryAndScore(){

	var currentInteractionArray = [];
	
	for (i = 0; i <  allInteractionArray.length; ++i) {
		
		var sourceProteinId = allInteractionArray[i]['interactor_A']['protein_id'];
		var sourceProteinName = allInteractionArray[i]['interactor_A']['protein_uniprot_id'];
		var sourceProteinGeneName = allInteractionArray[i]['interactor_A']['protein_gene_name'];
		var targetProteinId = allInteractionArray[i]['interactor_B']['protein_id'];
		var targetProteinName = allInteractionArray[i]['interactor_B']['protein_uniprot_id'];
		var targetProteinGeneName = allInteractionArray[i]['interactor_B']['protein_gene_name'];
		var scoreData = allInteractionArray[i]['score'];
		var highestCategoryStatus = allInteractionArray[i]['interaction_category_array']['highest_category_status'];

		var removeEdge = false;
		if(CategoryParameterArray[highestCategoryStatus] == 'false' || CategoryParameterArray[highestCategoryStatus] == false){	
			removeEdge = true;
		}

		if(scoreData == null){	
			scoreData = 0;
		}

		if(scoreData < ScoreParameter){
			removeEdge = true;
		}
		
		if(removeEdge == false){
			currentInteractionArray.push(allInteractionArray[i]);
		}
	}
	
	return currentInteractionArray;
}


function addCytoscapeQtips(cy){
	
	cy.$('.nodes').qtip({
		content: 
			function(){ 
			var proteinName = this.data('protein_name');
			var searchTerm = this.data('search_term');
			var geneName = this.data('gene_name');
			var uniprotIdString = this.data('uniprot_id');
			var ensemblId = this.data('ensembl_id');
			var entrezId = this.data('entrez_id');
			var proteinDescription = this.data('description');
			var linkArray = this.data('external_links');
			var returnLinks = '<div class="row">';
			var uniprotIdArray = '';
			if(uniprotIdString){
				var uniprotIdArray = uniprotIdString.split(",");
			}
			
			 var qtipData = uniprotIdString + '_' + geneName;
			 qtipData = qtipData.replace(/,/g, '_');
			var returnVar = $('.' + qtipData).html();
			return returnVar;
			
		},
		position: {
		   my: 'center',
		   at: 'center',
		   target: $(window),
		   viewport: $('#cy'),
		   adjust: { screen: true },
		   screen: "flip"
		},
		style: {
			classes: 'qtip-bootstrap',
			tip: {
				width: 8,
				height: 8
			}
		},
	});

	cy.edges().qtip({
		content: function(){
			var Interaction = this.data('interaction');
			var Score = this.data('score');
			var experimentArray = this.data('experiment_array');
			
			var tabMenue = '<ul class="nav nav-tabs" style="margin: 0px;">';
			var experimentTab = '<div class="tab-content border"  style="pading: 0px; border-top: 0px;">';
			var $num = 0;
			$.each(experimentArray, function(i, experiment){
				$num++;
				var screen_plural = ''
				if(experiment['num_screens'] == 1){
					screen_plural = 'screen';
					
				}else{
					
					screen_plural = 'screens';
				}

				if(i == 0){
					experimentTab = experimentTab + '<div id="' + experiment['id'] + '" class="tab-pane fade in active" style="padding: 10px; min-width:500px;">';
					tabMenue = tabMenue + '<li class="active"><a data-toggle="tab" href="#'  + experiment['id'] +  '">' + $num + '</a></li>';
				}else{
					experimentTab = experimentTab + '<div id="' + experiment['id'] + '" class="tab-pane fade" style=" padding: 10px; min-width:500px;">';
					tabMenue = tabMenue + '<li ><a data-toggle="tab" href="#'  + experiment['id'] +  '">' + $num + '</a></li>';
					
				}

				experimentTab = experimentTab + '<div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Dataset</h4></div><div class="row">' + experiment['dataset'] + 
				'</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Orientation</h4>' + 
				'</div><div class="row">DNA Binding Domain: ' + experiment['dna_binding_domain_name'] + '</div><div class="row">Activation Domain: ' + experiment['activation_domain_name'] + 
				'</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Open Reading Frames</h4></div><div class="row">Open Reading Frame of ' + 
				experiment['dna_binding_domain_name'] + ': <a href="http://horfdb.dfci.harvard.edu/index.php?page=showdetail&orf=' + experiment['orf_id_A'] + '" target=_blank>' + 
				experiment['orf_id_A'] + '</a></div><div class="row">Open Reading Frame of ' + 
				experiment['activation_domain_name'] + ': <a href="http://horfdb.dfci.harvard.edu/index.php?page=showdetail&orf=' + experiment['orf_id_B'] + '" target=_blank>' + 
				experiment['orf_id_B'] + '</a></div>' +
				'<div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Assay Version</h4></div>' +
				'<div class="row">This interaction was identified in assay version ' + experiment['assay_version'] + '</div>' +
				'<div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Screens</h4></div><div class="row">This interaction was identified in ' + 
				experiment['num_screens'] + ' ' + screen_plural + '</div></div></div>';

			});
			
			tabMenue = tabMenue + '</ul>';
			experimentTab = experimentTab + '</div>';
			
			return '<div class="container" style="padding-top: 20px; width: 100%; max-width: 540px;"><div class="row" style="margin-bottom: 20px;"><div class="col-sm-12"><h3 style="font-weight: bold; color:' +  MainColorScheme + ';">' + Interaction + '</h3><div class="shadow"></div></div></div><div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Confidence Score</h4></div><div class="row">' + Score + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Experiment</h4></div>' + tabMenue + experimentTab + '</div>';

		},
		position: {
		   my: 'center',
		   at: 'center',
		   target: $(window),
		   viewport: $('#cy')
		},
		style: {
			classes: 'qtip-bootstrap',
			tip: {
				width: 16,
				height: 8
			}
		}
	});
	
}

function addInteractorQtips(){
	
	
	 $('.interactor_qtip').each(function() {
		 
		 var qtipData = $(this).attr('data');
	     $(this).qtip({
	         content: {
	             text: $('.' + qtipData).html()
	         },
	 		position: {
	 			viewport: $('#cy'),
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
	 

	
}

function updateEnrichedTerms(){

	var EnrichmentQuery = [];

	$.each(currentProteinArray, function(j, ele_node){
		
		EnrichmentQuery.push(ele_node['protein_gene_name']);
		  				
	});
	var requestTerm = EnrichmentQuery.join();
	
	url = Url + 'term_enrichment/' + requestTerm;


	
	$.getJSON(url, function(JsonData) {
	 		
		$("#MF_table").empty();
		

	 	if(typeof JsonData.MF !== 'undefined' && JsonData.MF.length > 0 ){
	
		 	JsonData.MF.forEach(function(MF_row, i) {
		 		$("#MF_table").append("<tr class='enrichment_row' data='" + MF_row['list'] + "' term='" + MF_row['GO_term'] + "'><td><a href='http://amigo.geneontology.org/amigo/term/"+ MF_row['GO_term_code'] + "' target='_blank'>" + MF_row['GO_term_code'] + "</a></td><td>" + MF_row['GO_term'] + "</td><td class='row_qtip'>" + MF_row['p_value'] + "</td></tr><tr class='hidden'><td></td></tr>");
		 	});
	 	}else{

	 		$("#MF_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#MF_table").trigger('footable_redraw');
	 	
	 	$("#CC_table").empty();	 	
	 	if(typeof JsonData.CC !== 'undefined' && JsonData.CC.length > 0 ){

		 	JsonData.CC.forEach(function(CC_row, i) {
				$("#CC_table").append("<tr class='enrichment_row' data='" + CC_row['list'] + "' term='" + CC_row['GO_term'] + "'><td><a href='http://amigo.geneontology.org/amigo/term/"+ CC_row['GO_term_code'] + "' target='_blank'>" + CC_row['GO_term_code'] + "</a></td><td>" + CC_row['GO_term'] + "</td><td>" + CC_row['p_value'] + "</td></tr><div class='hidden'></div>");
		 	});
	 	}else{

	 		$("#CC_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");	
	 	}
	 	$("#CC_table").trigger('footable_redraw');
	 	
	 	$("#BP_table").empty();
	 	if(typeof JsonData.BP !== 'undefined' && JsonData.BP.length > 0 ){	

		 	JsonData.BP.forEach(function(BP_row, i) {
				$("#BP_table").append("<tr class='enrichment_row' data='" + BP_row['list'] + "' term='" + BP_row['GO_term'] + "'><td><a href='http://amigo.geneontology.org/amigo/term/"+ BP_row['GO_term_code'] + "' target='_blank'>"  + BP_row['GO_term_code'] + "</a></td><td>" + BP_row['GO_term'] + "</td><td>" + BP_row['p_value'] + "</td></tr><div class='hidden'></div>");	 
		 	});
	 	}else{
	 	
	 		$("#BP_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");		
	 	}
	 	$("#BP_table").trigger('footable_redraw');
	 	
	 	$("#rea_table").empty();
	 	
	 	if(typeof JsonData.rea !== 'undefined' && JsonData.rea.length > 0){	
		 	JsonData.rea.forEach(function(rea_row, i) {
				var reac_id = rea_row['GO_term_code'].replace("REAC:", '');
				$("#rea_table").append("<tr class='enrichment_row' data='" + rea_row['list'] + "' term='" + rea_row['GO_term'] + "'><td><a href='http://www.reactome.org/content/detail/R-HSA-"+ reac_id + "' target='_blank'>"  + rea_row['GO_term_code'] + "</a></td><td>" + rea_row['GO_term'] + "</td><td>" + rea_row['p_value'] + "</td></tr><div class='hidden'></div>");
		 	});
	 	}else{
	 		$("#rea_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#rea_table").trigger('footable_redraw');
	 	
	 	$("#cor_table").empty();
	 	if(typeof JsonData.cor !== 'undefined' && JsonData.cor.length > 0){
		 	JsonData.cor.forEach(function(cor_row, i) {
	 			var cor_id = cor_row['GO_term_code'].replace("CORUM:", '');
	 			$("#cor_table").append("<tr class='enrichment_row' data='" + cor_row['list'] + "' term='" + cor_row['GO_term'] + "'><td><a href='http://mips.helmholtz-muenchen.de/corum/?id="+ cor_id + "' target='_blank'>"  + cor_row['GO_term_code'] + "</a></td><td>" + cor_row['GO_term'] + "</td><td>" + cor_row['p_value'] + "</td></tr><div class='hidden'></div>");
		 	});
	 	}else{
	 		$("#cor_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#cor_table").trigger('footable_redraw');
	 	
	 	$("#tissue_expression_table").empty();

	 	
	 	if(typeof JsonData.tissue_expression !== 'undefined'){
	 		


	 		for(var tissue in JsonData.tissue_expression){
	 			
	 			var list_array = [];
	 			for(var geneData in JsonData.tissue_expression[tissue]){
	 				
	 				
	 				list_array.push(JsonData.tissue_expression[tissue][geneData][1]);
	 			}
	 			
		 		var list = list_array.join();
	 			
		 		var tissueName = tissue.toTitleCase();
		 		
	 			$("#tissue_expression_table").append("<tr class='tissue_expression_row' data='" + list  + "' term='" + tissue + "'><td>" + tissueName + "</td></tr><div class='hidden'></div>");
			 	
	 		} 

	 	}else{
	 		$("#tissue_expression_table").append("<tr><td>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#tissue_expression_table").trigger('footable_redraw');
	 	
	 	
	 	$("#subcellular_localization_table").empty();
	 	
	 	if(typeof JsonData.subcellular_location !== 'undefined'){
	 		

	 		for(var location in JsonData.subcellular_location){
	 			
	 			var list_array = [];
	 			for(var geneData in JsonData.subcellular_location[location]){
	 				
	 				
	 				list_array.push(JsonData.subcellular_location[location][geneData][1]);
	 			}
	 			
		 		var list = list_array.join();
		 		
		 		var locationName = location.toTitleCase();
	 			
	 			$("#subcellular_localization_table").append("<tr class='subcellular_location_row' data='" + list  + "' term='" + location + "'><td>" + location + "</td></tr><div class='hidden'></div>");
			 	
	 		} 

	 	
	 	}else{
	 		$("#subcellular_localization_table").append("<tr><td>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#subcellular_localization_table").trigger('footable_redraw');
	 	
	 	
	 	
	 	
	 	$( '.enrichment_row' ).each(function(){
	 		
		    $(this).qtip({
	    		content: 
	    			function(){ 

		    			var proteinNameList = this.attr('data');
		    			var Term = this.attr('term');
		    			Term = Term.toTitleCase()
		    			
		    			var urlProteinList = Url + 'search_results/' + proteinNameList;
		    			
		    			

		    			
		    			SearchTermArray = SearchTerm.split(",");
		    			
		    			proteinNameListArray = proteinNameList.split(",");
		    			
		    			var AddArray = SearchTermArray.concat(proteinNameListArray);
		    			
		    			AddArray = $.unique(AddArray);
		    			
		    			AddArray = AddArray.join();
		    			
		    			var urlAddProteinList = Url + 'search_results/' + AddArray;
		    			
		    			var downloadUrl = Url + "download/enriched_term_protein_csv/" + proteinNameList; 
	
		    			return '<div class="container" style="padding-top: 20px; max-width: 300px;"><div class="row"><h4><strong>' + Term  + '</strong></h4></div><div class="shadow"></div><div class="row" style="padding-top: 20px;"><div class="row"><a href="' + downloadUrl + '" target="_blank">Download Proteins (CSV)</a></div><div class="row"><a href="' + urlProteinList + '" target="_blank">Add to New Search Query</a></div><div class="row"><a href="' + urlAddProteinList + '" target="_blank">Add to Current Search Query</a> </div></div>';

	    		},
				position: {
					viewport: $(window),
					my: 'bottom right',
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
	 	
	 	
	});
	
	
}

function setLayoutClickEvent(cy){
	
 	$('.layout').on("click", function(event){
 	    
 		var layoutType = event.target.id;
 	
 		var layoutRun =  cy.layout({ 
 			name: layoutType,
 			avoidOverlap: true,
 			equidistant: true,
 			minNodeSpacing: 50,
 	 		randomize: true,
 	 		nodeRepulsion: 10000,
 	 		nodeOverlap: 10,
 	 		animate: 'end',
 	 		animationDuration: 500,
 	 		animationThreshold: 500,
 	 		fit: true,
 	 		springCoeff: edge => 0.00008,
 		});
 		layoutRun.run();
 		
 		cy.style().selector('$node').style({'content': 'data(gene_name)'}).update();
 
 		Layout = layoutType;
 		

 		
 	});	
	
}

function setCategoryCheckboxEvents(){

	$.each(CategoryArray, function(key, catagory){
		var CategoryName = key;
		 $("#" + CategoryName + "_checkbox").on('change', function(){
				CategoryParameterArray[$(this).attr("data")] = this.checked;
				updateCytoscapeNetwork();
		 });
	});
	
}

function setScoreSliderEvent(){

	$( "#min_interaction_score" ).slider({
	    
		step: 0.01,
	     min: 0,
	     max: 1,
	     value: ScoreParameter,
	     change:function( event, ui ) {
	    	 ScoreParameter = ui.value;
	    	 updateCytoscapeNetwork();
	
	     },
	     slide: function( event, ui ) {
	       $("#min_interaction_score_handle").html(ui.value);
	     }
	 });
	
	 $("#min_interaction_score_handle").html($( "#min_interaction_score" ).slider( "value" ));
	 $("#min_interaction_score").draggable();
}

function setTissueExpressionCheckboxEvents(){
	
    var tissueArray = ['adipose_subcutaneous', 'adipose_visceral_omentum', 'adrenal_gland', 'artery_aorta', 'artery_coronary', 'artery_tibial', 'brain_0', 'brain_1', 'brain_2', 'breast_mammary_tissue', 'colon_sigmoid', 'colon_transverse', 'esophagus_gastroesophageal_junction', 'esophagus_mucosa', 'esophagus_muscularis', 'heart_atrial_appendage', 'heart_left_ventricle', 'kidney_cortex', 'liver', 'lung', 'minor_salivary_gland', 'muscle_skeletal', 'nerve_tibial', 'ovary', 'pancreas', 'pituitary', 'prostate', 'skin', 'small_intestine_terminal_ileum', 'spleen', 'stomach', 'testis', 'thyroid', 'uterus', 'vagina', 'whole_blood'];
    
    tissueArray.forEach(function(tissue){
    	
		 $("#" + tissue + "_checkbox").on('change', function(){
			
			if($("#" + tissue + "_checkbox").is(':checked')){
				TissueExpressionParameterArray[tissue] = true;
		 	}else if(!$("#" + tissue + "_checkbox").is(':checked')){
		 		
		 		TissueExpressionParameterArray[tissue] = false;
		 	}	
				
			updateCytoscapeNetwork();
		 });
    });
}




function setCytoscapeExportEvents(){

	$('#export_cy').on('click', function(){	
		
		var networkSUID = null;
		cyRestActive = checkIfCyRestIsActive();	
		
		if(cyRestActive){
			
			networkSUID = exportNetwork();
			var styleExists = checkStyleExists(networkSUID);    	    	
			if(styleExists == false){
				exportStyle(networkSUID);	
			}     	
			applyStyleToNetwork(networkSUID);
			fitNetworkToWindow(networkSUID);
		}else{
			$("#cy_message").removeClass("hidden");
		    $(".qtip").addClass("hidden");
		    $("body").addClass("noscroll");
		}		
	});
}

function checkIfCyRestIsActive(){
	
	var cyRestActive = false;
	$.ajax({
	    type: "GET",
	    url: "http://localhost:1234/v1",
	    async: false,
	    crossDomain: true,
	}).success(function(success){	
		if(success){
			cyRestActive = true;
		}
	});
	
	return cyRestActive;
}

function exportNetwork(){
	
	var networkSUID = null;
	$.ajax({
	    type: "POST",
	    url: "http://localhost:1234/v1/networks?format=json",
	    data: JSON.stringify(cy.json()),
	    async: false,
	    headers: {
	        "Content-Type": "application/json"
	    },
	    crossDomain: true,
	    dataType: "json",
	}).success(function(networkId){networkSUID = networkId.networkSUID});
	
	return networkSUID;
}


function checkStyleExists(networkSUID){
	
	var styleExists = true;
	$.ajax({
	    type: "GET",
	    url: "http://localhost:1234/v1/styles/HuRI",
	    async: false,
	    crossDomain: true,
	}).error(function (xhr, ajaxOptions, thrownError){
	    if(xhr.status==404) {
	    	styleExists = false;
	    }
	});
	
	return styleExists;
}

function exportStyle(networkSUID){
	var style = {"title":"HuRI","defaults":[{"visualProperty":"COMPOUND_NODE_PADDING","value":10},{"visualProperty":"COMPOUND_NODE_SHAPE","value":"ROUND_RECTANGLE"},{"visualProperty":"DING_RENDERING_ENGINE_ROOT","value":"org.cytoscape.view.presentation.property.NullVisualProperty$NullDataTypeImpl@621bbc96"},{"visualProperty":"EDGE","value":"DefaultVisualizableVisualProperty(id=EDGE, name=Edge Visual Property)"},{"visualProperty":"EDGE_BEND","value":""},{"visualProperty":"EDGE_CURVED","value":true},{"visualProperty":"EDGE_LABEL","value":""},{"visualProperty":"EDGE_LABEL_COLOR","value":"#000000"},{"visualProperty":"EDGE_LABEL_FONT_FACE","value":"SansSerif.plain,plain,10"},{"visualProperty":"EDGE_LABEL_FONT_SIZE","value":18},{"visualProperty":"EDGE_LABEL_TRANSPARENCY","value":255},{"visualProperty":"EDGE_LABEL_WIDTH","value":200},{"visualProperty":"EDGE_LINE_TYPE","value":"SOLID"},{"visualProperty":"EDGE_PAINT","value":"#808080"},{"visualProperty":"EDGE_SELECTED","value":false},{"visualProperty":"EDGE_SELECTED_PAINT","value":"#FF0000"},{"visualProperty":"EDGE_SOURCE_ARROW_SELECTED_PAINT","value":"#FFFF00"},{"visualProperty":"EDGE_SOURCE_ARROW_SHAPE","value":"NONE"},{"visualProperty":"EDGE_SOURCE_ARROW_UNSELECTED_PAINT","value":"#000000"},{"visualProperty":"EDGE_STROKE_SELECTED_PAINT","value":"#FF0000"},{"visualProperty":"EDGE_STROKE_UNSELECTED_PAINT","value":"#404040"},{"visualProperty":"EDGE_TARGET_ARROW_SELECTED_PAINT","value":"#FFFF00"},{"visualProperty":"EDGE_TARGET_ARROW_SHAPE","value":"NONE"},{"visualProperty":"EDGE_TARGET_ARROW_UNSELECTED_PAINT","value":"#000000"},{"visualProperty":"EDGE_TOOLTIP","value":""},{"visualProperty":"EDGE_TRANSPARENCY","value":200},{"visualProperty":"EDGE_UNSELECTED_PAINT","value":"#404040"},{"visualProperty":"EDGE_VISIBLE","value":true},{"visualProperty":"EDGE_WIDTH","value":5},{"visualProperty":"NETWORK","value":"DefaultVisualizableVisualProperty(id=NETWORK, name=Network Visual Property)"},{"visualProperty":"NETWORK_BACKGROUND_PAINT","value":"#666666"},{"visualProperty":"NETWORK_CENTER_X_LOCATION","value":0},{"visualProperty":"NETWORK_CENTER_Y_LOCATION","value":0},{"visualProperty":"NETWORK_CENTER_Z_LOCATION","value":0},{"visualProperty":"NETWORK_DEPTH","value":0},{"visualProperty":"NETWORK_EDGE_SELECTION","value":true},{"visualProperty":"NETWORK_HEIGHT","value":400},{"visualProperty":"NETWORK_NODE_SELECTION","value":true},{"visualProperty":"NETWORK_SCALE_FACTOR","value":1},{"visualProperty":"NETWORK_SIZE","value":550},{"visualProperty":"NETWORK_TITLE","value":""},{"visualProperty":"NETWORK_WIDTH","value":550},{"visualProperty":"NODE","value":"DefaultVisualizableVisualProperty(id=NODE, name=Node Visual Property)"},{"visualProperty":"NODE_BORDER_PAINT","value":"#FFFFFF"},{"visualProperty":"NODE_BORDER_STROKE","value":"SOLID"},{"visualProperty":"NODE_BORDER_TRANSPARENCY","value":150},{"visualProperty":"NODE_BORDER_WIDTH","value":2},{"visualProperty":"NODE_CUSTOMGRAPHICS_1","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_2","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_3","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_4","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_5","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_6","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_7","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_8","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_9","value":"org.cytoscape.ding.customgraphics.NullCustomGraphics,0,[ Remove Graphics ],"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_1","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_2","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_3","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_4","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_5","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_6","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_7","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_8","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_POSITION_9","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_1","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_2","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_3","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_4","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_5","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_6","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_7","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_8","value":0},{"visualProperty":"NODE_CUSTOMGRAPHICS_SIZE_9","value":0},{"visualProperty":"NODE_CUSTOMPAINT_1","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_1, name=Node Custom Paint 1)"},{"visualProperty":"NODE_CUSTOMPAINT_2","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_2, name=Node Custom Paint 2)"},{"visualProperty":"NODE_CUSTOMPAINT_3","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_3, name=Node Custom Paint 3)"},{"visualProperty":"NODE_CUSTOMPAINT_4","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_4, name=Node Custom Paint 4)"},{"visualProperty":"NODE_CUSTOMPAINT_5","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_5, name=Node Custom Paint 5)"},{"visualProperty":"NODE_CUSTOMPAINT_6","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_6, name=Node Custom Paint 6)"},{"visualProperty":"NODE_CUSTOMPAINT_7","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_7, name=Node Custom Paint 7)"},{"visualProperty":"NODE_CUSTOMPAINT_8","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_8, name=Node Custom Paint 8)"},{"visualProperty":"NODE_CUSTOMPAINT_9","value":"DefaultVisualizableVisualProperty(id=NODE_CUSTOMPAINT_9, name=Node Custom Paint 9)"},{"visualProperty":"NODE_DEPTH","value":0},{"visualProperty":"NODE_FILL_COLOR","value":"#C80000"},{"visualProperty":"NODE_HEIGHT","value":40},{"visualProperty":"NODE_LABEL","value":""},{"visualProperty":"NODE_LABEL_COLOR","value":"#FFFFFF"},{"visualProperty":"NODE_LABEL_FONT_FACE","value":"Arial Bold,plain,12"},{"visualProperty":"NODE_LABEL_FONT_SIZE","value":18},{"visualProperty":"NODE_LABEL_POSITION","value":"C,C,c,0.00,0.00"},{"visualProperty":"NODE_LABEL_TRANSPARENCY","value":255},{"visualProperty":"NODE_LABEL_WIDTH","value":200},{"visualProperty":"NODE_NESTED_NETWORK_IMAGE_VISIBLE","value":true},{"visualProperty":"NODE_PAINT","value":"#787878"},{"visualProperty":"NODE_SELECTED","value":false},{"visualProperty":"NODE_SELECTED_PAINT","value":"#FFFF00"},{"visualProperty":"NODE_SHAPE","value":"ELLIPSE"},{"visualProperty":"NODE_SIZE","value":50},{"visualProperty":"NODE_TOOLTIP","value":""},{"visualProperty":"NODE_TRANSPARENCY","value":240},{"visualProperty":"NODE_VISIBLE","value":true},{"visualProperty":"NODE_WIDTH","value":60},{"visualProperty":"NODE_X_LOCATION","value":0},{"visualProperty":"NODE_Y_LOCATION","value":0},{"visualProperty":"NODE_Z_LOCATION","value":0}],"mappings":[{"mappingType":"passthrough","mappingColumn":"name","mappingColumnType":"String","visualProperty":"NODE_LABEL"},{"mappingType":"discrete","mappingColumn":"query","mappingColumnType":"String","visualProperty":"NODE_FILL_COLOR","map":[{"key":"non-query","value":"#3C78D8"},{"key":"query","value":"#CC0000"}]},{"mappingType":"discrete","mappingColumn":"highest_category_status","mappingColumnType":"String","visualProperty":"EDGE_STROKE_UNSELECTED_PAINT","map":[{"key":"Published","value":"#6AA84F"},{"key":"Validated","value":"#E69138"},{"key":"Verified","value":"#A61C00"}]}]}
	
	$.ajax({
	    type: "POST",
	    url: "http://localhost:1234/v1/styles",
	    data: JSON.stringify(style),
	    async: false,
	    headers: {
	        "Content-Type": "application/json"
	    },
	    crossDomain: true,
	    dataType: "json",
	});

}

function applyStyleToNetwork(networkSUID){

	$.ajax({
	    type: "GET",
	    url: "http://localhost:1234/v1/apply/styles/HuRI/" + networkSUID,
	    async: false,
	    crossDomain: true,
	});

}

function fitNetworkToWindow(networkSUID){
	
	$.ajax({
	    type: "GET",
	    url: "http://localhost:1234/v1/apply/fit/" + networkSUID,
	    async: false,
	    crossDomain: true,
	});
}





function setDownloadEvents(){
	
	
	$('#download_unpublished_data_link').on("click", function(){

		var isChecked = $('#recieve_updates_on_interaction_network').is(":checked");
		alert(isChecked);
		var requestType = $("#request_type").val();
		
		var Parameters = [Version, ScoreParameter, CategoryParameterArray , TissueExpressionParameterArray];
	
		switch(requestType) {
		    case 'psi_mitab_interaction':
		    	$('#data_request_data').val(JSON.stringify(currentInteractionArray));
		    	$("#data_download_form").attr("action", Url + "download/interaction_psi_mitab/");
		        break;
		    case 'csv_interaction':
		    	$('#data_request_data').val(JSON.stringify(currentInteractionArray));
		    	$("#data_download_form").attr("action", Url + "download/interaction_csv/");
		        break;
		    case 'csv_interactor':
		    	$('#data_request_data').val(JSON.stringify(currentProteinArray));
		    	$("#data_download_form").attr("action", Url + "download/interactor_csv/");
		        break;
		    case 'fasta':
		    	$('#data_request_data').val(JSON.stringify(currentProteinArray));
		    	$("#data_download_form").attr("action", Url + "download/multi_fasta/");
		        break;
		}
		
		
    	if(isChecked){
    		$('#add_user_interaction_network').val(true);
    	}else{
    		$('#add_user_interaction_network').val(false);
    	}
		
    	
    	$('#data_request_query_parameters').val(JSON.stringify(Parameters));
    	$('#data_request_query_id_array').val(JSON.stringify(queryProteinIdArray));
    	$('#data_download_form').submit();
    	$("#data_request_logged_in").addClass("hidden");

	});
	
	$('#psi_mitab_interaction').on("click", function(){
		
		if(loggedIn == true){

			$("#data_request_logged_in").removeClass("hidden");
			$("#request_type").val('psi_mitab_interaction');

		}else{

			$("#data_request_logged_out").removeClass("hidden");
			
		}

	    $(".qtip").addClass("hidden");
	    $("body").addClass("noscroll");
		
	});

	$('#csv_interaction').on("click", function(){
		
		if(loggedIn == true){

			$("#data_request_logged_in").removeClass("hidden");
			$("#request_type").val('csv_interaction');

		}else{

			$("#data_request_logged_out").removeClass("hidden");
			
		}

	    $(".qtip").addClass("hidden");
	    $("body").addClass("noscroll");
			
	});
	
	$('#csv_interactor').on("click", function(){
		
		if(loggedIn == true){

			$("#data_request_logged_in").removeClass("hidden");
			$("#request_type").val('csv_interactor');

		}else{

			$("#data_request_logged_out").removeClass("hidden");
			
		}

	    $(".qtip").addClass("hidden");
	    $("body").addClass("noscroll");
		
	});
	
	$('#fasta').on("click", function(){
		
		if(loggedIn == true){

			$("#data_request_logged_in").removeClass("hidden");
			$("#request_type").val('fasta');

		}else{

			$("#data_request_logged_out").removeClass("hidden");
			
		}

	    $(".qtip").addClass("hidden");
	    $("body").addClass("noscroll");
		
	});
	
}

function setNodeAndEdgeSummayValues(){
	
	$("#node_number").html( currentProteinArray.length );
	$("#edge_number").html( currentInteractionArray.length );

}

function displayMessageIfNoInteractions(){
	if(currentInteractionArray.length == 0){	
		$("#no_interactions_found").removeClass("hidden");
	}else{
		$("#no_interactions_found").addClass("hidden");	
	}
}

function getEdgeWidth(scoreData){
	
	var widthData = 1;
		if (scoreData <= 0.20){
			widthData = 2;
		}else if(scoreData <= 0.40 && scoreData > 0.20){
			widthData = 3;
		}else if(scoreData <= 0.60 && scoreData > 0.40){
			widthData = 4;
		}else if(scoreData <= 0.80 && scoreData > 0.60){
			widthData = 5;
		}else if(scoreData <= 1 && scoreData > 0.80){
			widthData = 6;
		}
		
		return widthData;
}

function setPanZoomForNonMobile(cy){

    var isMobile = checkMobile();
	if(isMobile == false){
		cy.panzoom({});
	}
	
}

function setCytoscapeExportForNonMobile(){
	
    var isMobile = checkMobile();
	if(isMobile == false){	
		$("#export_cy").removeClass('hidden');
		$("#export_cy").qtip({
            content: {
                text: "Export Network to Cytoscape"
            },
    		position: {
    			my: 'left center',
    			at: 'right center'
    		},
    		style: {
    			classes: 'qtip-bootstrap',
  
    			tip: {
    				width: 24,
    				height: 20
    			}
    		},
    	    show: {
    	        event: 'mouseenter'
    	    },

        });
	}
}


function checkMobile(){
	
    var isMobile = false;

 	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
     || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

	return isMobile;
}

function setPngDownloadClickEvent(cy){
	$('#png').on('click', function(){
		var png64 = cy.png({bg: '#ffffff'});
		$('#png').attr('href', png64);
	});
}

function setReactomeLinkClickEvent(){
	
	$("#reactome_link").on('click', function(){	
		
	    var reactomeURI = 'http://www.reactome.org/AnalysisService/identifiers/';	
	    var dataArray = $("#reactome_link").attr('data').split(','); 
	    var dataString = dataArray.join("\n");
	    var dataUrl = '#Genes\n' + dataString;

	    jQuery.ajax({
	        type: "POST",
	        url: reactomeURI,
	        data: dataUrl,
	        async: false,
            headers: {
                "Content-Type": "text/plain"
            },
            dataType: "json"
	    }).success(function (data, textStatus) {
	        if (textStatus === 'success') {
	        	window.open('http://www.reactome.org/PathwayBrowser/#DTAB=AN&ANALYSIS=' + data.summary.token, '_blank');
	        }
	    });		
	});
}

function setInteractionRowClickEvent(cy){

    $('.interaction_row').click(  
    		
    	function(){
    		
        	if($(this).hasClass("selected")){
        		$(this).removeClass("selected");
        		$( '.interaction_row' ).each(function(){ $(this).css('background', '#ffffff');});
        		$( '.enrichment_row' ).each(function(){ $(this).css('background', '#ffffff');});
	    		cy.nodes().style({ 'opacity' : 1});
	    		cy.edges().style({ 'opacity' : 1});

            }else{
        		$( '.interaction_row' ).each(function(){ $(this).css('background', '#ffffff');});
        		$( '.enrichment_row' ).each(function(){ $(this).css('background', '#ffffff');});
        		$(this).addClass("selected");
    			 $(this).css('background', '#d9d9d9');
    			 var id = $(this).attr('id');
	    		cy.nodes().style({ 'opacity' : 0.2});
	    		cy.edges().style({ 'opacity' : 0.2});
	    		cy.$('#' + id).style({ 'opacity' : 1});
	    		cy.$('#' + id).connectedNodes().style({ 'opacity' : 1});

            }
        }
     );
}

function setEnrichmentRowClickEvent(cy){

    $('.enrichment_table').on("click", '.enrichment_row, .tissue_expression_row, .subcellular_location_row', function(){

	 	if($(this).hasClass("selected")){
	 		$(this).removeClass("selected");
	 		$( '.interaction_row' ).css('background', '#ffffff');
	 		$( '.enrichment_row' ).css('background', '#ffffff');
	 		$( '.tissue_expression_row' ).css('background', '#ffffff');
	 		$( '.subcellular_location_row' ).css('background', '#ffffff');
			cy.nodes().style({ 'opacity' : 1});
			cy.edges().style({ 'opacity' : 1});
	
	     }else{
	 		$( '.interaction_row' ).css('background', '#ffffff');
	 		$( '.enrichment_row' ).css('background', '#ffffff');
	 		$( '.tissue_expression_row' ).css('background', '#ffffff');
	 		$( '.subcellular_location_row' ).css('background', '#ffffff');
	 		$(this).addClass("selected");
			 $(this).css('background', '#d9d9d9');
			 var id = $(this).attr('id');
			 var data = $(this).attr('data');
			 var proteins = data.split(",");
			 
			cy.nodes().style({ 'opacity' : 0.2});
			cy.edges().style({ 'opacity' : 0.2});
	
	
			var highlightednodes_array = [];

			$.each(proteins, function(i, protein){
	
				
				var nodeArray = cy.nodes().filter(function(){ return this.data('gene_name') == protein});

				var node = nodeArray[0];
				
				node.style({ 'opacity' : 1});
		
				highlightednodes_array.push("#" + node.data('id'));
				

	
	    	});
			
			var highlightednodes_string = highlightednodes_array.join();

			var subgraphNodes = cy.$(highlightednodes_string);
			
			var edgeArray = subgraphNodes.edgesWith(subgraphNodes);
			
			$.each(edgeArray, function(i, edge){
				
				edge.style({ 'opacity' : 1});
			});
       }
   });
}

function setNodeHoveEvent(cy){
 	cy.nodes().on("mouseover", function(e){
 		
 		$( '.interaction_row' ).each(function(ele){ $(ele).css('background', '#ffffff');});

 	    timer = setTimeout(function(){
     		cy.nodes().style({ 'opacity' : 0.2});
     		cy.edges().style({ 'opacity' : 0.2});
     		e.target.style({ 'opacity' : 1});
     		e.target.neighborhood().style({ 'opacity' : 1});
 	    }, 700);

 	}).on("mouseout", function(){
 	    clearTimeout(timer);
 		cy.nodes().style({ 'opacity' : 1});
 		cy.edges().style({ 'opacity' : 1});
 	    
 	});
}


function setNetworkTableEvent(){
	
	$(".network_table_tab").on('click',function(){
		selectedTab = $(this).html();

		if(selectedTab == "<strong>GO Enrichment</strong>" || selectedTab == "<strong>Pathway Enrichment</strong>" || selectedTab == "<strong>Complex Enrichment</strong>"){

			selectedTab = selectedTab + "<i id='enrichment_warning' class='help_query glyphicon glyphicon glyphicon-info-sign' style='cursor: pointer; margin: 0px 0px 0px 10px;'></i>"
			
		}

		$("#selected_network_table_tab").html(selectedTab);
		$("#enrichment_warning").qtip({
            content: {
                text: "The current GO and pathway enrichment results are not corrected for biases introduced from the network and therefore, should be interpreted with caution."
            },
    		position: {
    			my: 'top center',
    			at: 'bottom center'
    		},
    		style: {
    			classes: 'qtip-bootstrap',
    			width: '400px',
    			tip: {
    				width: 10,
    				height: 8
    			}
    		},
            show: 'click',
            hide: 'unfocus'
        });
		
	});
	
	
	
}

function setMinimizeAndMaximizeClickEvents(){

	$("#summary").on("hide.bs.collapse", function(){
		$("#maximize_minimize").html('[ + ]');
	});
	
	$("#summary").on("show.bs.collapse", function(){
		$("#maximize_minimize").html('[ - ]');
	});

}

function setFootable(){
	$('table').footable({
		"columns": [{
			"sortable": true
		}]});
	
	$('#change-page-size').change(function (e) {
		e.preventDefault();
		var pageSize = $(this).val();
		$('.footable').data('page-size', pageSize);
		$('.footable').trigger('footable_redraw');
	});
}

function setQueryNodeColor(cy){
	for (i = 0; i < queryProteinIdArray.length; ++i) {

		var queryProteinId = queryProteinIdArray[i];
		var selectID = '#' + queryProteinId;	
		cy.$(selectID).style({'background-color': QueryNodeColor });
		cy.$(selectID).data({'query' : 'query'});
	}
}



function reloadPageSize(){

	var current = $("#change-page-size").val();
	$("#change-page-size").val(current).change();

}

function enableScroll(){
	if(allInteractionArray.length > 100){
		$(window).load(function() {	
			$(".se-pre-con").fadeOut('fast', function(){
				$(window).disablescroll("undo");
			});	
		});
	}else{
		
		$(".se-pre-con").fadeOut('fast', function(){
			$(window).disablescroll("undo");
		});	
	}
}

function showLoadingScreen(){	
	if(currentInteractionArray.length > 100){
		$("#loading_screen").prepend('<div id="se-pre-con" class="se-pre-con"><div class="loader" style="text-align: center;"><div class="row"><h4>Network Data is Loading</h4></div></div></div>');
	}
}

function createInteractionTable(){

	if(currentInteractionArray.length > 0){
		
		$.each(currentInteractionArray, function(i, interaction){

			var score = '';
			
			if(interaction['score']){
				
				score = interaction['score'];
			}
			
			var uniprot_id_A = interaction['interactor_A']['protein_uniprot_id'];
			var uniprot_id_B = interaction['interactor_B']['protein_uniprot_id'];
			
			if(uniprot_id_A){
				uniprot_id_A = uniprot_id_A.replace(/,/g, '_')
			}
			if(uniprot_id_B){
				uniprot_id_B = uniprot_id_B.replace(/,/g, '_')
			}

			var queryProteinA = false;
			
			if($.inArray( interaction['interactor_A']['protein_id'], queryProteinIdArray ) != -1){
				queryProteinA = true;
				
			}

			var queryProteinB = false;
			
			if($.inArray( interaction['interactor_B']['protein_id'], queryProteinIdArray ) != -1){
				queryProteinB = true;
				
			}
			
			var interaction_row = '<tr id="' + interaction['interactor_A']['protein_id'] + '_' + interaction['interactor_B']['protein_id'] +  '" class="interaction_row">' +
			'<td><a data="' + uniprot_id_A + '_' +  interaction['interactor_A']['protein_gene_name'] + 
			'" class="interactor_qtip link"'; 
			
			if(queryProteinA){				
				interaction_row = interaction_row + " style='color:" + QueryNodeColor + "'>";
			}else{
				interaction_row = interaction_row + " style='color: #3C78D8'>";
			}
			
			interaction_row = interaction_row + interaction['interactor_A']['protein_gene_name'] + '</a></td>' +
			'<td><a data="' + uniprot_id_B + '_' +  interaction['interactor_B']['protein_gene_name'] + 
			'" class="interactor_qtip link"';
			
			if(queryProteinB){				
				interaction_row = interaction_row + " style='color:" + QueryNodeColor + "'>";
			}else{
				interaction_row = interaction_row + " style='color: #3C78D8'>";
			}
			
			interaction_row = interaction_row + interaction['interactor_B']['protein_gene_name'] + '</a></td>' +
			'<td>' + score + '</td><td>';
	
			$.each(interaction['dataset_array'], function(j, dataset){
				
				if(dataset['interaction_status'] != 'published'){
					
					interaction_row = interaction_row + '<a class="link reference_qtip">' + dataset['name'] + '</a>' +
								'<div class="hidden">' +  dataset['description'] + '</div></br>';
					
				}else{
					interaction_row = interaction_row + '<a class="link" href="http://www.ncbi.nlm.nih.gov/pubmed/' +  dataset['dataset_reference'] + '" target="_blank">' + dataset['dataset_author'] + ' (' + dataset['year'] + ')</a></br>'; 
					
					
				}
			});
			
			interaction_row = interaction_row + '</td></tr>';

			$('#interaction_rows').prepend(interaction_row);
			
		});
		
		
		$.each(currentProteinArray, function(i, protein){
			
			var uniprotIdString = protein.protein_uniprot_id;
			
			
			var uniprotIdArray = [];
			
			if(uniprotIdString != null){
				uniprotIdString = uniprotIdString.replace(/,/g, '_');
				uniprotIdArray = protein.protein_uniprot_id.split(",");
				
			}
			
			var protein_qtip =  '<div class= "' + uniprotIdString + '_' + protein.protein_gene_name + '" hidden>' +
				'<div class="container" style="padding-top: 20px; width: 100%;">' +
					'<div class="row" style="margin-bottom: 20px;">' +
						'<div class="col-sm-10"><h3 style="font-weight: bold; color: ' + MainColorScheme + '">' + protein.protein_gene_name + '</h3>' +
							'<div class="shadow"></div>'+
						'</div>'+
					'</div>' +
			
					'<div class="col-sm-7">' +
					
						'<div class="row"><h4 style="font-weight: bold; color: ' + MainColorScheme + '">Actions</h4></div>' +
						
						'<div class="row"><a href="' + protein.protein_gene_name + '" target="_blank" class="link">Search for ' + protein.protein_gene_name + '</a></div>' +
						'<div class="row"><a href="'+ Url + 'search_results/' + searchTerm + ',' + protein.protein_gene_name + '" target="_blank">Add to Current Search</a></div>';
			if(uniprotIdString){
				protein_qtip = protein_qtip + '<div class="row"><a href="' + Url + 'protein_sequence/' +  protein.protein_uniprot_id + '" target="_blank" class="link">Show protein sequence</a></div>';
				
			}			
						
						
			protein_qtip = protein_qtip + '<div class="row"><h4 style="font-weight: bold; color:' + MainColorScheme + '">Description</h4></div>';
			".'+ qtipData + '_description' +'"
			if(protein.protein_description != null){
				protein_qtip = protein_qtip + '<div class="row"><span class="more ' + uniprotIdString + '_' + protein.protein_gene_name + '_description">' + protein.protein_description + '</span></div>';
			}else{
				protein_qtip = protein_qtip + '<div class="row"><span class="more">' + 'N/A' + '</span></div>';
			}			
			protein_qtip = protein_qtip + '</div>' +
					'<div class="col-sm-5" style="padding:0px;">' +
						'<div class="row"><h4 style="font-weight: bold; color: ' + MainColorScheme + '">Links</h4></div>' +
						'<div class="row">';
						
			if(uniprotIdString){			
				protein_qtip = protein_qtip + '<div class="row"><strong style="color: #666666">Uniprot</strong></div><div class="row">';
			}			
						
			$.each(uniprotIdArray, function(i, uniprotId){		
				protein_qtip = protein_qtip + '<a href="http://www.uniprot.org/uniprot/' + uniprotId + '" class="link" target="_blank">' + uniprotId + '</a></br>';
			});	
						
						
			protein_qtip = protein_qtip + '</div><div class="row"><strong style="color: #666666">Ensembl</strong></div><div class="row">' +
						'<a href="http://www.ensembl.org/id/' + protein.protein_ensembl_id + '" class="link" target="_blank">' + protein.protein_ensembl_id + '</a></div>';
			if(protein.protein_entrez_id){
				protein_qtip = protein_qtip + '<div class="row"><strong style="color: #666666">NCBI Gene</strong></div><div class="row">'+
				'<a href="https://www.ncbi.nlm.nih.gov/gene/' + protein.protein_entrez_id + '" class="link" target="_blank">' + protein.protein_entrez_id + '</a></div>';
			}
			
			protein_qtip = protein_qtip + '</div></div>';
			
			
			$('#protein_qtips').prepend(protein_qtip);
		});

	}else{
		
		$('#interaction_rows').prepend('<p>No Interactions Found</p>');
		
	}

}

function updateExternalLinks(){
	
	var geneManiaUrl = 'http://genemania.org/search/human/';
	var stringUrl = 'http://string-db.org/newstring_cgi/show_network_section.pl?identifiers=';
	var reactomeUrl = "";
	var pathwayCommonsUrl = "http://www.pathwaycommons.org/pcviz/#pathsbetween/";
	var davidUrl = "http://david.abcc.ncifcrf.gov/api.jsp?type=ENTREZ_GENE_ID&ids=";
	var gProfiler = "http://biit.cs.ut.ee/gprofiler/index.cgi?organism=hsapiens&query=";
	var intAct = "http://www.ebi.ac.uk/intact/query/";
	var complexPortal = "http://www.ebi.ac.uk/complexportal/complex/search?query=";
	var cBioPortal = "http://www.cbioportal.org/ln?q=";


	$.each(currentProteinArray, function(i, protein){ 
		geneManiaUrl = geneManiaUrl + protein.protein_gene_name + '%7C'; 
		stringUrl =  stringUrl + protein.protein_gene_name + '%0D';
		reactomeUrl = reactomeUrl + protein.protein_gene_name + ',';
		pathwayCommonsUrl = pathwayCommonsUrl + protein.protein_gene_name + ',';
		davidUrl = davidUrl + protein.protein_entrez_id + ',';
		gProfiler =  gProfiler + protein.protein_gene_name + ' ';
		complexPortal = complexPortal + protein.protein_gene_name + '%20';
		cBioPortal = cBioPortal + protein.protein_gene_name + '%20';
		
		if($.inArray( protein.protein_id, queryProteinIdArray ) != -1){
			intAct = intAct +  protein.protein_gene_name + '%20';
			
		}

	});


	
	stringUrl =  stringUrl + '&species=9606';
	davidUrl = davidUrl + '&tool=summary';
	
	$("#gene_mania_link_li").prepend('<a href="' + geneManiaUrl + '" target="_blank">GeneMANIA</a>');
	$("#string_link_li").prepend('<a href="' + stringUrl + '" target="_blank">STRING</a>');
	$("#reactome_link_li").prepend('<a id="reactome_link" style="cursor: pointer;" data="' + reactomeUrl + '">Reactome</a>');
	$("#pathway_commons_link_li").prepend('<a href="' + pathwayCommonsUrl + '" target="_blank">Pathway Commons</a>');
	$("#david_link_li").prepend('<a href="' + davidUrl + '" target="_blank">DAVID</a>');
	$("#gprofiler_link_li").prepend('<a href="' + gProfiler + '" target="_blank">gProfiler</a>');
	$("#cbioportal_link_li").prepend('<a href="' + cBioPortal + '" target="_blank">cBioPortal</a>');
	$("#intact_link_li").prepend('<a href="' + intAct + '" target="_blank">IntAct (Query)</a>');
	$("#complex_portal_link_li").prepend('<a href="' + complexPortal + '" target="_blank">Complex Portal</a>');

	setReactomeLinkClickEvent();
}

String.prototype.toTitleCase = function() {
	  var i, j, str, lowers, uppers;
	  
	  str = this.replace(/_/g, " ");
	  str = str.replace(/([^\W_]+[^\s-]*) */g, function(txt) {
	    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	  });

	  // Certain minor words should be left lowercase unless 
	  // they are the first or last words in the string
	  lowers = ['A', 'An', 'The', 'And', 'But', 'Or', 'For', 'Nor', 'As', 'At', 
	  'By', 'For', 'From', 'In', 'Into', 'Near', 'Of', 'On', 'Onto', 'To', 'With'];
	  for (i = 0, j = lowers.length; i < j; i++)
	    str = str.replace(new RegExp('\\s' + lowers[i] + '\\s', 'g'), 
	      function(txt) {
	        return txt.toLowerCase();
	      });

	  // Certain words such as initialisms or acronyms should be left uppercase
	  uppers = ['Id', 'Tv'];
	  for (i = 0, j = uppers.length; i < j; i++)
	    str = str.replace(new RegExp('\\b' + uppers[i] + '\\b', 'g'), 
	      uppers[i].toUpperCase());

	  return str;
}


function download(filename, text) {
    var pom = document.createElement('a');
    pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    pom.setAttribute('download', filename);

    if (document.createEvent) {
        var event = document.createEvent('MouseEvents');
        event.initEvent('click', true, true);
        pom.dispatchEvent(event);
    }
    else {
        pom.click();
    }
}

function setTextOutput(){
	$("#main").hide();
	$("#main_text_output").show();
	$( "#text_output" ).append( "Unique identifier for interactor A,Unique identifier for interactor B,Alternative identifier for interactor A,Alternative identifier for interactor B,Aliases for A,Aliases for B,First author,Identifier of the publication,Confidence score<br>");
	
	
	$.each(allInteractionArray, function(i, interaction){
		var unprotA = interaction.interactor_A.protein_uniprot_id.replace(/,/gi, "|");
		var unprotB = interaction.interactor_B.protein_uniprot_id.replace(/,/gi, "|");
		var datasetArray = interaction.dataset_array;
		var authorArray = [];
		var pubIdArray = [];
		$.each(datasetArray, function(i, dataset){
			
			authorArray.push(dataset.dataset_author);
			pubIdArray.push(dataset.dataset_reference);
		});
		var author = authorArray.join("|");
		var pubId = pubIdArray.join("|");
	
		$( "#text_output" ).append(
				unprotA + "," + 
				unprotB + "," + 
				interaction.interactor_A.protein_ensembl_id + "," +
				interaction.interactor_B.protein_ensembl_id + "," + 
				interaction.interactor_A.protein_gene_name + "," + 
				interaction.interactor_B.protein_gene_name + "," +
				author + "," + 
				pubId + "," +
				interaction.score + "," +
				'</br>' );
	});
	
	$("#download").on("click", function(){
	
		var str = $('#text_output').html();
		var regex = /<br\s*[\/]?>/gi;
		var returnCsv = str.replace(regex, "\n");
		returnCsv = returnCsv.replace(/^[\n\t\s ]*/, "");
		download('results.csv', returnCsv);
	});
}


function whatisVariable(variable){

	
	
	var typeVar = typeof variable;
	
	var nullVar = false;
	if(variable === null){
		nullVar = true;
		
	}
	
	var undefinedVar = false;
	if(variable === undefined){
		undefinedVar = true;
		
	}
	
	var undefinedVar = false;
	if(variable === ''){
		undefinedVar = true;
		
	}
	
	



}

