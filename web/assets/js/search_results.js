

var allInteractionArray = '',
	allProteinArray = '',
    allDomainArray = '',
    proteinInteractionCountsInNetwork = [];
    selectedRows = [];
	queryProteinIdArray = '',
	searchTerm = '',
	proteinOfIntrestName = '',
	Layout = '',
	currentProteinArray = '',
	currentInteractionArray = '',
	foundProteinSummary = '',
	unfoundProteinSummary = '',
	FilterParameter = '',
	ScoreParameter = '',
	removedProteins = [],
	cy = '';
	// Url= 'http://localhost:8000/'
	//$("#search_term_summary").html(queryParameters.SearchTermSummary);
	//$("#proteins_found_summary").html(found_protein_summary);
	//$("#proteins_not_found_summary").html(unfound_protein_summary);
	//$("#filter_summary").html(FilterParameter);
	//$("#score_parameter").html(ScoreParameter);
	//$("#interaction_status").html(CategorySummary);
	//$("#node_number").html( currentProteinArray.length );
	//$("#edge_number").html( currentInteractionArray.length );	

	$("#huri_img").fadeIn(2000);
	setTissueFilterQtips();	
	setSearchQtips();
	setNetworkMenuDropdowns();
	setExampes();
	setScoreSliderEvent();
	setDownloadPanel();
	setFilterEvents();
	setSearchAutocomplete();
	setValidateSearchTerm();
	setRemoveInvalidTerm();
	setNetworkTableEvent();
	setMinimizeAndMaximizeClickEvents();
	setReactomeLinkClickEvent();
	setCategoryCheckboxEvents();
	setAnnotationCheckboxEvents();
	setNodeResizeAndColorChangeCheckboxEvents();
	setFilterParameterCheckboxEvents();
	setDataFileCheckboxEvents();
	setSearchAutocompleteInteractor();
	setValidateSearchTermInteractor();
	setRemoveInvalidTermInteractor();
	setNetworkTableCollapseEvents();
	setUpdateQuery();
	setUpdateInteractors();


main();



function main(){

	allInteractionArray = SearchResultsJSON['all_interactions'];
	allProteinArray = SearchResultsJSON['all_proteins'];
	allDomainArray = SearchResultsJSON['domains'];
	queryProteinIdArray = SearchResultsJSON['query_protein_id_array'];
	searchTerm = SearchResultsJSON['search_term'];
	foundProteinSummary = SearchResultsJSON['found_protein_summary'];
	unfoundProteinSummary = SearchResultsJSON['unfound_protein_summary'];
	proteinOfIntrestName = '';
	Layout = getLayout();
	currentProteinArray = allProteinArray;
	currentInteractionArray = allInteractionArray;
	cy = '';	
	//enableScroll();
	
	console.log(allInteractionArray);
	
	var switchValue = getSwitch();
	
	switch (switchValue) {
    case 'return_data_file':
    	showDataDownload();
        break;
    case 'too_many_interactions':
    	showDataDownload();
        break;
    case 'display_network':
    	
    	displayNetwork();
        break;
	}

}

//*****************************************************************************************//


function displayNetwork(){

	setProteinInteractionCountsArray();
	//setNodeAndEdgeSummayValues();
	//updateSearchSummary();

	cy = updateCytoscapeNetwork();
	
	addInteractorQtips();
	
	preventDropDownMenuClose();
	$(".description").readmore({lessLink: "<a>Read less</a>"});
}

function updateCytoscapeNetwork(){	
	var currentProteinAndInteractionArray = filterProteinsAndInteractions();	
	var cytoscapeJSON = createCytoscapeJSON();
	displayMessageIfNoInteractions();
	cy = createCytoscapeNetwork(cytoscapeJSON);
	createInteractionTable();
	createInteractorTable(cy);	
	updateInteractionsTable();
 	updateSummary();
 	addCytoscapeQtips(cy);
 	addInteractorQtips();
 	setLayoutClickEvent(cy);
 	setNodeHoverEvent(cy);
 	removeNodeHoverEvent(cy);
 	setPanZoomForNonMobile(cy);
 	setPngDownloadClickEvent(cy);
 	setFootable();
 	updateNetworkTable();
 	setRemoveProteinFromNetworkEvents();
	tissueExpressionNodeSize(cy);
	tissueSpecificityNodeColor(cy);
 	setCytoscapeExportForNonMobile();
 	setCytoscapeExportEvents();
	return cy;
}

function updateNetworkTable(){
 	updateEnrichedTerms();
 	updateAnnotationTable();
 	updateExternalLinks();
 	setFootable();
 	//reloadPageSize();
 	updateSearchForm();
 	setInteractionRowClickEvent2();
 	setInteractorRowClickEvent2()
 	setEnrichmentRowClickEvent();
	
}

//*****************************************************************************************//

function createCytoscapeJSON(){
	
	var nodesJSON = new Object();
	var edgesJSON = new Object();
	
	nodesJSON = [];
	edgesJSON = [];
	
	//var complexesContainingMoreThanOneInteractor = getComplexesContainingMoreThanOneInteractor();	
	
	//for (j = 0; j < complexesContainingMoreThanOneInteractor.length; ++j) {

		//var complex_id = complexesContainingMoreThanOneInteractor[j];
		
		//var complex = allComplexArray[complex_id];
		
		//var complexId = complex['complex_id'];
		//var complexName = complex['name'];
		//var complexDescription = complex['description'];
		
		//nodesJSON.push({id: complexId, data: { id: complexId }, style: { "label": complexName, 'background-color': '#A041F2'}, classes: "nodes"});
	//}
	
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var proteinName = currentProteinArray[i].protein_protein_name;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinDescription = currentProteinArray[i].protein_description;
 		var linkArray = currentProteinArray[i].protein_external_links;
 		var annotationArray = currentProteinArray[i].annotation_array;
 		var tissueExpressionArray = currentProteinArray[i].tissue_expression_array;
 		var subcellularLocationExpressionArray = currentProteinArray[i].subcellular_location_expression_array;
 		var nodeProteinId = proteinId;
 		
 		if(jQuery.isEmptyObject(subcellularLocationExpressionArray) == true){
 			
 			subcellularLocationExpressionArray = {};
 		}
 		if(jQuery.isEmptyObject(tissueExpressionArray) == true){
 			   
 			tissueExpressionArray = {};
 		}
 		nodesJSON.push({id: nodeProteinId, group: "nodes",data: { id: nodeProteinId, name: geneName, uniprot_id: uniprotId, ensembl_id: ensemblId, entrez_id: entrezId, protein_name: proteinName, gene_name: geneName, description: proteinDescription, external_links: linkArray, annotation_array: '', tissue_expression_array: tissueExpressionArray, subcellular_location_expression_array: subcellularLocationExpressionArray, query: 'non-query'}, classes: "nodes"},); 		
 		if(false){
		if(proteinId in allDomainArray ){
			var domain = allDomainArray[proteinId];
			var domainType = domain.type;
 			nodesJSON.push({id: nodeProteinId, group: "nodes",data: { id: nodeProteinId, name: geneName, uniprot_id: uniprotId, ensembl_id: ensemblId, entrez_id: entrezId, protein_name: proteinName, gene_name: geneName, description: proteinDescription, external_links: linkArray, annotation_array: '', tissue_expression_array: tissueExpressionArray, subcellular_location_expression_array: subcellularLocationExpressionArray, query: 'non-query'}, classes: "nodes has_domain"},);	
			var proteinDomainArray = allDomainArray[proteinId];
			$.each(proteinDomainArray, function( index, domain ) {
				var domainType = domain.type;
	 			nodesJSON.push({id: nodeProteinId + '_domain_' + domainType, group: "nodes",data: {id: nodeProteinId + '_domain_' + domainType, parent: nodeProteinId, type: domainType}, classes: "domains"});
			});
 		}else{
 			nodesJSON.push({id: nodeProteinId, group: "nodes",data: { id: nodeProteinId, name: geneName, uniprot_id: uniprotId, ensembl_id: ensemblId, entrez_id: entrezId, protein_name: proteinName, gene_name: geneName, description: proteinDescription, external_links: linkArray, annotation_array: '', tissue_expression_array: tissueExpressionArray, subcellular_location_expression_array: subcellularLocationExpressionArray, query: 'non-query'}, classes: "nodes"},);
 		}
		
		if (typeof allProteinComplexArray !== 'undefined'){
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
 	}
 	console.log(currentInteractionArray);
 	for (i = 0; i <  currentInteractionArray.length; ++i) {

 		var interactionId = currentInteractionArray[i]['interaction_id']
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceProteinName = currentInteractionArray[i]['interactor_A']['protein_protein_name'];
 		var sourceProteinGeneName = currentInteractionArray[i]['interactor_A']['protein_gene_name'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
 		var targetProteinName = currentInteractionArray[i]['interactor_B']['protein_protein_name'];
 		var targetProteinGeneName = currentInteractionArray[i]['interactor_B']['protein_gene_name'];
 		var scoreData = currentInteractionArray[i]['score'];
 		var annotationArray = currentInteractionArray[i]['annotation_array'];
		var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];		
		var interactionCategoryArray = currentInteractionArray[i]['interaction_category_array']['interaction_category_array'];
		
 		var sourceNodeId = sourceProteinId;
 		var lineColor = "#ccc";
 		if(typeof CategoryArray[highestCategoryStatus] !== "undefined" && typeof interactionCategoryArray  !== "undefined" ){
 			if(interactionCategoryArray.length > 1){
 				var experimental_and_literature_check = false;
 				$.each(interactionCategoryArray, function( index, category ) {
 					if(category['category_name'] == 'Literature'){
 						experimental_and_literature_check = true;
 					}
 				});
				if(experimental_and_literature_check == true){
					lineColor = "#ff55dd";
				}else{
					lineColor = CategoryArray[highestCategoryStatus]['color_scheme'];
				}
 			}else{
 				lineColor = CategoryArray[highestCategoryStatus]['color_scheme'];
 			}
 		}

 		var targetNodeId = targetProteinId;
 		var edgeID = sourceProteinId + "_" + targetProteinId;
 		widthData = getEdgeWidth(scoreData);
 		if(false){
 		if(sourceNodeId in allDomainArray){
			var proteinDomainArray = allDomainArray[sourceNodeId];
			$.each(proteinDomainArray, function( index, domain ) {
				if(interactionId == domain.interaction_id){
				var domainType = domain.type;
				sourceNodeId = sourceNodeId + '_domain_' + domainType;
				}
			});
 		}
 		}
 		
 		edgesJSON.push({
			group: "edges",
			data: { id: edgeID, name: sourceProteinGeneName + ' - ' + targetProteinGeneName, source: sourceNodeId, target: targetNodeId, interaction: sourceProteinGeneName + ' - ' + targetProteinGeneName, score: scoreData, annotation_array: annotationArray, highest_category_status: highestCategoryStatus},
			style: { "line-color": lineColor, 'width': widthData},		
 		});
 		
 	}
 	

 	var cytoscapeJSON = nodesJSON.concat(edgesJSON);

	return cytoscapeJSON;
}

function createCytoscapeNetwork(cytoscapeJSON){
	
	cy = cytoscape({	
		container: document.getElementById('cy'),
	  	elements: cytoscapeJSON,
	  	style: [{
 				selector: '.nodes',
 				css:{
                     'content': 'data(gene_name)',
                     'text-valign': 'center',
                     'color': 'white',
                     'text-outline-width': 1.4,
                     'font-weight': 'bold',
                     'padding-top': '10px',
                     'padding-left': '10px',
                     'padding-bottom': '10px',
                     'padding-right': '10px',
                     'background-color': InteractorNodeColor
     			}},{
 				selector: '.has_domain',
 				css:{
                     'content': 'data(gene_name)',
                     'text-valign': 'top',
     			}},{
				selector: '.domains',
				css:{
                 'content': 'data(type)',
                 'text-valign': 'center',
                 'color': 'white',
                 'text-outline-width': 1,
                 'padding-top': '10px',
                 'padding-left': '10px',
                 'padding-bottom': '10px',
                 'padding-right': '10px',
                 'background-color': '#CCCCCC'
 			   }},{
             	selector: '.edge',
             	css:{
             	  'line-color' : '#AAAAAA'
             	}}]
	});
	
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

//*****************************************************************************************//



function updateSummary(){	
	$("#proteins_found_summary").html(foundProteinSummary);
	$("#proteins_not_found_summary").html(unfoundProteinSummary);
	$("#node_number").html( currentProteinArray.length );
	$("#edge_number").html( currentInteractionArray.length );
	var degreeCount = 0;
 	for (i = 0; i < currentProteinArray.length; ++i) {	
 		var proteinId = currentProteinArray[i].protein_id;
 		var count = proteinInteractionCountsInNetwork[proteinId];
 		degreeCount = degreeCount + count;
 	}
	var averageNodeDegree = Math.round(degreeCount/currentProteinArray.length * 100) / 100;	
	$("#average_node_degree").html(averageNodeDegree);
}

function setDownloadPanel(){
	$(".data_request_links").on('click', function(){
		var unpublished = false;
	 	for (i = 0; i <  currentInteractionArray.length; ++i) {
			var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];
			if(highestCategoryStatus != 'Published'){
				unpublished = true;
			}
	 	}	
		if(loggedIn == true || unpublished == false){
			$("#overlay_network_data_request_logged_in").fadeIn( "fast", function() {});
			var download_format = $(this).attr('data');
			$("#download_data_link").unbind( "click" );
			$("#download_data_link").on('click', function(){
				if($('#recieve_updates_on_interaction_network').is(":checked")){
					$.ajax({
					    type: "POST",
					    url:  Url + "app.php/save_interaction_network",
					    data: {        
							'json_data' : JSON.stringify(currentInteractionArray),
					        },
					    crossDomain: true,
					    dataType: 'json',
					    async: false, 
						success:function(){console.log('yes');}
					});	
				}
				returnDataFile(download_format);
				$("#overlay_network_data_request_logged_in").fadeOut( "fast", function() {});
			});
			$(".cancel_data_request").on('click', function(){
				$("#overlay_network_data_request_logged_in").fadeOut( "fast", function() {});
			});	
		}else{
			$("#overlay_network_data_request_logged_out").fadeIn( "fast", function() {});
			$(".cancel_data_request").on('click', function(){
				$("#overlay_network_data_request_logged_out").fadeOut( "fast", function() {});
			});
		}
	    $(".qtip").addClass("hidden");
	});
}



function showDataDownload(){
	
	$("#direct_download_message").show();
	$("#file_download").on('click', function(){
		download_format = $('#direct_download_format').val();
		console.log(download_format);
		returnDataFile(download_format);
	});
	$(".cancel_many_interactions_message").on('click', function(){
		$("#direct_download_message").hide();
	});
	
}

function downloadFile(filename, text) {
  $("#data_download").attr('href','');
  $("#data_download").attr('download', '');	
  $("#data_download").attr('href','data:text/plain;charset=utf-8,' + encodeURIComponent(text));
  $("#data_download").attr('download', filename);
  $("#data_download").get(0).click();
}

function returnDataFile(download_format){	

	var dataFile = '';
	var fileName = '';

	switch (download_format) {
    case 'psi_mi_tab':
    	dataFile = getPSIMITabFile();
    	fileName = getFileName('psi_mi_tab');
        break;
    case 'sif':
    	dataFile = getSIFFile();
    	fileName = getFileName('sif');
        break;
    case 'interactions_csv':
    	dataFile = getInteractionsCSVFile();
    	fileName = getFileName('interactions_csv');
        break;
    case 'interactors_csv':
    	dataFile = getInteractorsCSVFile();
    	fileName = getFileName('interactors_csv');
        break;
    case 'fasta':
    	dataFile = getFASTAFile();
    	fileName = getFileName('fasta');
    	break;
        
	}

	downloadFile(fileName, dataFile);

}

function getFileName(download_format){
	
    var d = new Date();
    var n = d.toString();
    var array = n.split(" ");
    var dateString = array[1].toLowerCase() + '_' + array[2] + '_' + array[3] + '_' + array[4];
	fileName = '';
	
	switch (download_format) {
    case 'psi_mi_tab':
    	fileName = 'HuRI_download_psi_mi_tab'  + '_' +  dateString + '.tab';
        break;
    case 'sif':
    	fileName = 'HuRI_download_sif'  + '_' +  dateString + '.sif';
        break;
    case 'interactions_csv':
    	fileName = 'HuRI_download_interactions'  + '_' +  dateString + '.csv';
        break;
    case 'interactors_csv':
    	fileName = 'HuRI_download_interactors'  + '_' +  dateString + '.csv';
        break;
    case 'fasta':
    	fileName = 'HuRI_download_fasta'  + '_' +  dateString + '.fasta';
    	break;
        
	}

	return fileName;
		
}

function getDownloadFileFooter(dataFile){
    var d = new Date();
    var n = d.toString();
    var array = n.split(" ");
    var categoryArray = [];
    $.each(CategoryParameterArray, function(category, selected){if(selected[0]){categoryArray.push(category);}});
    var categoryString = categoryArray.join(',');
    var annotationArray = [];
    $.each(AnnotationParameterArray, function(annotation, selected){if(selected){annotationArray.push(annotation);}});
    var annotationString = annotationArray.join(',');
    
 	dataFile = dataFile + "##\r\n";
 	dataFile = dataFile + "## Date Downloaded: " + array[1] + ' ' + array[2] + ' ' + array[3] + "\r\n";
 	dataFile = dataFile + "## Database Version: " + Version + "\r\n";
 	dataFile = dataFile + "##\r\n";
 	dataFile = dataFile + "## Query Parameters\r\n";
 	
 	if(ScoreParameter.length > 0 ){
 		dataFile = dataFile +  "## Score Filter: " + ScoreParameter + "\r\n";
 	}else{
 		dataFile = dataFile +  "## Score Filter: 0\r\n";
 	}
 	
 	if(categoryString.length > 0 ){
 		dataFile = dataFile +  "## Interaction Catagories Included: " +  categoryString + "\r\n";
 	}else{
 		dataFile = dataFile +  "## Interaction Catagories Included: None\r\n";
 	}
 	
 	if(annotationString.length > 0 ){
 		dataFile = dataFile +  "## Tissue Filter: " + annotationString + "\r\n";
 	}else{
 		dataFile = dataFile +  "## Tissue Filter: None\r\n";
 	}
 	
	return dataFile;
}


function getPSIMITabFile(){
	var dataFile = "ID(s) interactor A\tID(s) interactor B\tAlt. ID(s) interactor A\tAlt. ID(s)interactor B\tAlias(es) interactor A\tAlias(es) interactor B\tInteraction detection method(s)\tPublication 1st author(s)\tPublication Identifier(s)\tTaxid interactor A\tTaxid interactor B\tInteraction type(s)\tSource database(s)\tInteraction identifier(s)\tConfidence value(s)\tExpansion method(s)\tBiological role(s)interactor A\tBiological role(s) interactor B\tExperimental role(s) interactor A\tExperimental role(s) interactor B\tType(s) interactor A\tType(s) interactor B\tXref(s) interactor A\tXref(s) interactor B\tInteraction Xref(s)\tAnnotation(s) interactor A\tAnnotation(s) interactor B\tInteraction annotation(s)\tHost organism(s)\tInteraction parameter(s)\tCreation date\tUpdate date\tChecksum(s) interactor A\tChecksum(s) interactor B\tInteraction Checksum(s)	Negative\tFeature(s) interactor A\tFeature(s) interactor B\tStoichiometry(s) interactor A\tStoichiometry(s) interactor B\tIdentification method participant A\tIdentification method participant B\r\n";
 	for (i = 0; i <  currentInteractionArray.length; ++i) {
 		var interactionId = currentInteractionArray[i]['interaction_id']
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceProteinName = currentInteractionArray[i]['interactor_A']['protein_uniprot_id'];
 		var sourceProteinGeneName = currentInteractionArray[i]['interactor_A']['protein_gene_name'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
 		var targetProteinName = currentInteractionArray[i]['interactor_B']['protein_uniprot_id'];
 		var targetProteinGeneName = currentInteractionArray[i]['interactor_B']['protein_gene_name'];
 		var scoreData = currentInteractionArray[i]['score'];
 		var annotationArray = currentInteractionArray[i]['annotation_array'];
		var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];
 		var sourceNodeId = sourceProteinId;
 		
 		
 		
 		
 		dataFile = dataFile + sourceProteinName + "\t" + targetProteinName + "\t" + sourceProteinGeneName + "\t" + targetProteinGeneName + "\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t" + scoreData + "\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\t-\r\n";
 	}
 	
 	dataFile = getDownloadFileFooter(dataFile);
 	
 	return dataFile;
	
}

function getSIFFile(){
	
	var dataFile = "Interactor A\tInteraction Type\tInteractor B\n";
 	for (i = 0; i <  currentInteractionArray.length; ++i) {
 		var interactionId = currentInteractionArray[i]['interaction_id']
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceProteinName = currentInteractionArray[i]['interactor_A']['protein_uniprot_id'];
 		var sourceProteinGeneName = currentInteractionArray[i]['interactor_A']['protein_gene_name'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
 		var targetProteinName = currentInteractionArray[i]['interactor_B']['protein_uniprot_id'];
 		var targetProteinGeneName = currentInteractionArray[i]['interactor_B']['protein_gene_name'];
 		var scoreData = currentInteractionArray[i]['score'];
 		var annotationArray = currentInteractionArray[i]['annotation_array'];
		var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];
 		var sourceNodeId = sourceProteinId;
 		dataFile = dataFile + sourceProteinGeneName + "\t" + 'pp' + "\t" + targetProteinGeneName + "\n";
 	}	
 	
 	dataFile = getDownloadFileFooter(dataFile);
 	
 	return dataFile;	
}

function getInteractionsCSVFile(){
	
	var dataFile = "Interactor A Gene Name,Interactor B Gene Name,Interactor A Ensembl ID,Interactor B Ensembl ID,Interactor A Uniprot ID, Interactor B Uniprot ID,Interactor A Entrez ID,Interactor B Entrez ID,Confidence Score\r\n";
 	for (i = 0; i <  currentInteractionArray.length; ++i) {
 		var interactionId = currentInteractionArray[i]['interaction_id']
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var sourceUniprotId = currentInteractionArray[i]['interactor_A']['protein_uniprot_id'];
 		var sourceProteinGeneName = currentInteractionArray[i]['interactor_A']['protein_gene_name'];
 		var sourceProteinEnsemblId = currentInteractionArray[i]['interactor_A']['protein_ensembl_id'];
 		var sourceProteinEntrezId = currentInteractionArray[i]['interactor_A']['protein_entrez_id'];
 		
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
 		var targetUniprotId = currentInteractionArray[i]['interactor_B']['protein_uniprot_id'];
 		var targetProteinGeneName = currentInteractionArray[i]['interactor_B']['protein_gene_name'];
 		var targetProteinEnsemblId = currentInteractionArray[i]['interactor_B']['protein_ensembl_id'];
 		var targetProteinEntrezId = currentInteractionArray[i]['interactor_B']['protein_entrez_id'];
 		
 		var scoreData = currentInteractionArray[i]['score'];
 		var annotationArray = currentInteractionArray[i]['annotation_array'];
		var highestCategoryStatus = currentInteractionArray[i]['interaction_category_array']['highest_category_status'];
 		var sourceNodeId = sourceProteinId;
 		dataFile = dataFile + sourceProteinGeneName + "," + targetProteinGeneName + "," + sourceProteinEnsemblId + "," + targetProteinEnsemblId + "," + sourceUniprotId + "," + targetUniprotId + "," + sourceProteinEntrezId + "," + targetProteinEntrezId + "," + scoreData + "\n";
 	}	
 	
 	dataFile = getDownloadFileFooter(dataFile);
 	
 	return dataFile; 	
}

function getInteractorsCSVFile(){
	
	var dataFile = "Gene Name,Ensembl ID,Uniprot ID,Entrez ID,Protein Description\r\n";
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinDescription = currentProteinArray[i].protein_description;
 		var nodeProteinId = proteinId;
 		dataFile = dataFile + geneName + "," + ensemblId + "," + uniprotId + "," + entrezId + "," + proteinDescription + "\n";	
 	}	
 	
 	dataFile = getDownloadFileFooter(dataFile);
 	 	
 	return dataFile;	
}

function downloadEnrichedTermProteinsFile(enrichedTermProteins){
	
	fileName = getFileName('interactors_csv');

	var dataFile = "Gene Name,Ensembl ID,Uniprot ID,Entrez ID,Protein Description\r\n";
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinDescription = currentProteinArray[i].protein_description;
 		var nodeProteinId = proteinId;
 		if(enrichedTermProteins.indexOf(nodeProteinId) != -1){
 			dataFile = dataFile + geneName + "," + ensemblId + "," + uniprotId + "," + entrezId + "," + proteinDescription + "\n";	
 		}	
 	}
 	dataFile = getDownloadFileFooter(dataFile);
 	 	
 	downloadFile(fileName, dataFile);
}


function getFASTAFile(){
	
	var dataFile = '';
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinSequence = currentProteinArray[i].protein_sequence;
 		var nodeProteinId = proteinId;
 		dataFile = dataFile + '>gene_name:' + geneName + "|ensembl_id:" + ensemblId + "|uniprot_id:" + uniprotId + "|entrez_id:" + entrezId + proteinSequence + "\n";
 	}	
 	
 	dataFile = getDownloadFileFooter(dataFile);
 	
 	return dataFile;
}


function setFilterEvents(){
	$('#filter_update').on('click', function(){
		$("#overlay_network_loader_image").show();
		$("#overlay_network_table").show();
		updateCytoscapeNetwork();
		$("#overlay_network_loader_image").fadeOut( "fast", function() {});
		$("#overlay_network_table").fadeOut( "fast", function() {});
		$('#interaction_info').collapse("hide");
		$('#collapse_menu').collapse("hide");
	
	});
}

function createInteractionTable(){
	
	if(currentInteractionArray.length > 0){
		resetProteinInteractionCountsInNetwork();

		$('#interaction_rows').empty();
		$.each(currentInteractionArray, function(i, interaction){
			var protein_A = interaction['interactor_A']['protein_id'];
			var protein_B = interaction['interactor_B']['protein_id'];
			
			if(protein_A != protein_B){
				proteinInteractionCountsInNetwork[interaction['interactor_A']['protein_id']] = proteinInteractionCountsInNetwork[interaction['interactor_A']['protein_id']] + 1;
				proteinInteractionCountsInNetwork[interaction['interactor_B']['protein_id']] = proteinInteractionCountsInNetwork[interaction['interactor_B']['protein_id']] + 1;
			}else{
				proteinInteractionCountsInNetwork[interaction['interactor_A']['protein_id']] = proteinInteractionCountsInNetwork[interaction['interactor_A']['protein_id']] + 1;
			}
			var score = '';			
			if(interaction['score']){score = interaction['score'];}		
			var uniprot_id_A = interaction['interactor_A']['protein_uniprot_id'];
			var uniprot_id_B = interaction['interactor_B']['protein_uniprot_id'];
			if(uniprot_id_A){uniprot_id_A = uniprot_id_A.replace(/,/g, '_')}
			if(uniprot_id_B){uniprot_id_B = uniprot_id_B.replace(/,/g, '_')}
			var queryProteinA = false;
			if($.inArray( +interaction['interactor_A']['protein_id'], queryProteinIdArray ) != -1){queryProteinA = true;}			
			var queryProteinB = false;
			if($.inArray( +interaction['interactor_B']['protein_id'], queryProteinIdArray ) != -1){queryProteinB = true;}
			
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
					interaction_row = interaction_row + '<a class="link" href="http://www.ncbi.nlm.nih.gov/pubmed/' +  dataset['dataset_reference'] + '" target="_blank">' + dataset['name'] + '</a></br>'; 
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
			var count_in_network = proteinInteractionCountsInNetwork[protein.protein_id];
			var protein_qtip =  '<div class= "' + uniprotIdString + '_' + protein.protein_gene_name + '" hidden>' +
				'<div class="container" style="padding-top: 20px; min-width: 400px;">' +
					'<div class="row" style="margin-bottom: 0px;">' +
						'<h3 style="margin-bottom: 0px;font-weight: bold; color: ' + MainColorScheme + '">' + protein.protein_gene_name + '</h3>' +
					'</div>' +
					'<div class="row" style="margin-bottom: 0px;">' +
						'<h5 style="font-weight: bold; color: ' + MainColorScheme + '">' + protein.protein_protein_name + '</h5>' +
					'</div>' +
					'<div class="row" style="margin-bottom: 12px;">' +
						'<div class="shadow"></div>'+
					'</div>' +
					'<div class="row">'+
						'<h4 style="font-weight: bold; color: ' + MainColorScheme + '">Actions</h4>' +
					'</div>' +
					'<div class="row">'+
						'<a href="' + Url + 'app_dev.php/search/' + protein.protein_gene_name + '"  target="_blank">Search HuRI for ' + protein.protein_gene_name + '</a>' +
					'</div>' +
					'<div class="row">'+
						'<a class="remove_protein_from_network" style="cursor: pointer" data="' + protein.protein_id + '">Remove ' + protein.protein_gene_name + ' From Network</a>' +
					'</div>' +
					'<div class="row">'+
						'<h4 style="font-weight: bold; color: ' + MainColorScheme + '">Links</h4>' +
					'</div>' +					
					'<div class="row">'+
						'<table>' +
						    '<tr style="height:32px;">' +
						       '<td style="padding-right:40px;">' +
								'<a href="https://www.ncbi.nlm.nih.gov/gene/' + protein.protein_entrez_id + '" class="link" target="_blank">' +
								'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/ncbi.png"/>' +
								'<strong style="color: #666666">NCBI Gene</strong>' +
								'</a>' +
						        '</td>' +
						        '<td>' +
								'<a href="https://www.proteinatlas.org/' + protein.protein_ensembl_id + '-' + protein.protein_gene_name + '" class="link" target="_blank">' +
								'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/hpa.png"/>' +
								'<strong style="color: #666666">Human Protein Atlas</strong></div><div class="row" style="padding-left: 30px;">' +
								'</a>' +
						        '</td>' +
						    '</tr>' +
						    '<tr style="height:32px;">' +
						        '<td>' +
								'<a href="http://www.ensembl.org/id/' + protein.protein_ensembl_id + '" class="link" target="_blank">' +
								'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/ensembl.png"/>' +
								'<strong style="color: #666666">Ensembl</strong>' +
								'</a>' +
						        '</td>' +
						        '<td>' +
								'<a href="https://www.genecards.org/cgi-bin/carddisp.pl?gene=' + protein.protein_gene_name + '" class="link" target="_blank">' +
								'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/gene_cards.png"/>' +
								'<strong style="color: #666666">Gene Cards</strong></div><div class="row" style="padding-left: 30px;">' +
								'</a>' +
						        '</td>' +
						   '</tr>' +
						    '<tr style="height:32px;">' +
						        '<td>' +
						        	'<a href="http://www.uniprot.org/uniprot/' + protein.protein_uniprot_id + '" class="link" target="_blank">' +
									'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/uniprot.png"/>' +
									'<strong style="color: #666666">Uniprot</strong>' +
									'</a>' +
								'</td>' +
						        '<td>' +
					        	'<a style="display:none;" href="https://www.yeastgenome.org/locus/' + protein.protein_ensembl_id + '" class="link" target="_blank">' +
								'<img height="20" width="20" style="margin: 2px 10px 0px 5px; vertical-align:middle;" src="' + Url + 'assets/images/sgd.png"/>' +
								'<strong style="color: #666666">SGD</strong>' +
								'</a>' +
								'</td>' +
							'</tr>' +
						'</table>'+
					'</div>' +
					'<div class="row">'+
						'<h4 style="font-weight: bold; color: ' + MainColorScheme + '">Number of Interactions</h4>' +
					'</div>' +	
					'<div class="row" style="margin:0px;">'+
						'<p style="margin:0px;">Interactions in Network: ' + count_in_network + '</p>' +
					'</div>' +
					'<div class="row">'+
						'<p style="margin:0px;">Interactions in Database: ' + protein.number_of_interactions_in_database + '</p>' +
					'</div>' +
					'<div class="row">'+
						'<h4 style="font-weight: bold; color:' + MainColorScheme + '">Description</h4>'+
					'</div>' +
					'<div class="row">';	
					if(protein.protein_description != null){				
						var description = protein.protein_description
						protein_qtip = protein_qtip + '<div class="row"><div style="max-height: 200px; padding: 5px; overflow-y:auto; border: 1px solid #ccc"><span class="more ' + uniprotIdString + '_' + protein.protein_gene_name + '_description">' + description + '</span></div></div>';
					
					}else{
						protein_qtip = protein_qtip + '<div class="row"><span class="more">' + 'N/A' + '</span></div>';
					}
					protein_qtip = protein_qtip + '</div>';
			$('#protein_qtips').prepend(protein_qtip);
		});
		
	}else{
		$('#interaction_rows').prepend('<p style="margin-top: 10px;">No Interactions</p>');
	}
}


function createInteractorTable(cy){
	
	$('#interactor_rows').empty();
	if(currentProteinArray.length > 0){		
		$.each(currentProteinArray, function(i, interactor){
			var gene_name = '';			
			if(interactor['protein_gene_name']){
				gene_name = interactor['protein_gene_name'];
			}
			var protein_id = '';			
			if(interactor['protein_id']){
				protein_id = interactor['protein_id'];
			}
			var number_of_interactions_in_database = '';
			if(interactor['number_of_interactions_in_database']){
				number_of_interactions_in_database = interactor['number_of_interactions_in_database'];
			}
			

			var queryProtein = false;
			
			if($.inArray( +protein_id, queryProteinIdArray ) != -1){
				queryProtein = true;
			}

			var protein_uniprot_id = '';			
			if(interactor['protein_uniprot_id']){
				protein_uniprot_id = interactor['protein_uniprot_id'];
			}
			var interactorID = '#' + protein_id;

			var number_of_interactions_in_network = proteinInteractionCountsInNetwork[protein_id];
			

			protein_uniprot_id = protein_uniprot_id.replace(/,/g, "_");
			
			var interactor_row = '<tr id="' + protein_id  +  '_table" protein_id="' + protein_id + '" class="interactor_row">' +
			
			'<td><a data="' + protein_uniprot_id + '_' +  gene_name + '" class="interactor_qtip link"'
			
			if(queryProtein){				
				interactor_row = interactor_row + " style='color:" + QueryNodeColor + "'>";
			}else{
				interactor_row = interactor_row + " style='color: #3C78D8'>";
			}
			
			var ratio_interactions_in_network_to_interactions_in_database = number_of_interactions_in_network / number_of_interactions_in_database;
			ratio_interactions_in_network_to_interactions_in_database = ratio_interactions_in_network_to_interactions_in_database.toFixed(2);
			
			interactor_row = interactor_row + gene_name + '</a></td><td>' + number_of_interactions_in_network + '</td><td>' + number_of_interactions_in_database + '</td><td>' + ratio_interactions_in_network_to_interactions_in_database + '</td></tr>';
			
			$('#interactor_rows').prepend(interactor_row);
			
		});
	}else{
		$('#interactor_rows').prepend('<p style="margin-top: 10px;">No Interactors</p>');
	}	
}


function updateInteractionsTable(){

	$(".interaction_row").appendTo("#hide_rows");

	for (i = 0; i <  currentInteractionArray.length; ++i) {
		
 		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
 		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		var interactionID = sourceProteinId  + "_" + targetProteinId;		

		$("#" + interactionID).appendTo("#interaction_rows");

	}
}


function setNetworkTableCollapseEvents(){
	$(".network_table_tab").on('click', function(){
		$("#interaction_info").collapse();
	});
}


function sendDataRequestQuery(){
	
	SearchResultsJSONt = '';
	
	//console.log(queryParameters.SearchTermParameter);
	//console.log(queryParameters.SearchTermParameter);
	//console.log(queryParameters.FilterParameter);
	//console.log(queryParameters.SearchTermArray);
	console.log('Please check Url redirection here for any errors');
	// Url='http://localhost:8000/'
	console.log(Url);
	$.ajax({
	    type: "GET",
	    url:  Url + "app.php/search_results_interactions",
	    data: {
	        
			'query_interactor' : 'query',
			'page' : 'results',
			'query_id_array' : queryParameters.SearchTermParameter,
			'search_term_parameter' : queryParameters.SearchTermParameter,
			'filter_parameter' : queryParameters.FilterParameter,
			'search_term_array' : queryParameters.SearchTermArray,
			'search_organism' : queryParameters.searchOrganism,

	        },
	    crossDomain: true,
	    dataType: 'json',
	    async: false, 
		success:function(result){			
	        SearchResultsJSONt = JSON.parse(result);
	    }
	});
	console.log('wrapping up ajax');
	return SearchResultsJSONt;
	
}

function sendDataRequestInteractor(){
	
	SearchResultsJSON = '';

	$.ajax({
	    type: "GET",
	    url:  Url + "app.php/search_results_interactions",
	    data: {
	        
	    	'query_interactor' : 'interactor',
			'page' : 'results',
	    	'query_id_array' : queryParameters.queryProteinIdArray,
			'search_term_parameter' : queryParameters.SearchTermParameter,
			'filter_parameter' : queryParameters.FilterParameter,
			'search_term_array' : queryParameters.SearchTermArray,
			
	        },
	    crossDomain: true,
	    dataType: 'json',
	    async: false, 
		success:function(result){
	        
	        SearchResultsJSON = JSON.parse(result);
	    }

	});
	
	return SearchResultsJSON;
	
}

function setUpdateQuery(){
	
	$("#submit_query").on("click", function(){			
		$("#overlay_network_loader_image").css('visibility', 'visible');
		$("#overlay_network_table").show();
		
		searchOrganism=$("#form_organism_select").val();
		console.log({searchOrganism})
		// searchOrganism = 0
		searchQuery = $("#search_identifier").val();
		searchQueryArray = searchQuery.split(/[;,\s\t\n]/);	
		searchQueryArray = searchQueryArray.filter(function(value) {return value !== ''});
		searchQueryString =  searchQueryArray.join(',');
		// console.log(searchQueryString);
		queryParameters.FilterParameter = getFilterParameter();
		queryParameters.queryProteinIdArray = queryProteinIdArray;
		queryParameters.SearchTermParameter = searchQueryString;
		queryParameters.SearchTermArray = searchQueryArray;
		queryParameters.searchOrganism = searchOrganism
		
		$('#interactions_tab').trigger('click');
		SearchResultsJSON = sendDataRequestQuery();
		removedProteins = [];
		main();
		$("#overlay_network_loader_image").fadeOut( "fast", function() {});
		$("#overlay_network_table").fadeOut( "fast", function() {});
		 $('#interaction_info').collapse("hide");
	});

}
function setUpdateInteractors(){
	
	$("#submit_interactors").on("click", function(){
		$("#overlay_network_loader_image").show();
		$("#overlay_network_table").show();

		previousQueryProteinIdArray = queryProteinIdArray;
		
		searchQuery = $("#interactor_list").val();
		searchQueryArray = searchQuery.split(/[;,\s\t\n]/);
		searchQueryArray = searchQueryArray.filter(function(value) {return value !== ''});
		searchQueryString =  searchQueryArray.join(',');
		
		queryParameters.FilterParameter = searchQueryString;	
		queryParameters.queryProteinIdArray = queryProteinIdArray;
		queryParameters.SearchTermParameter = searchQueryString;
		queryParameters.SearchTermArray = searchQueryArray;
		
		$('#interactions_tab').trigger('click');
		SearchResultsJSON = sendDataRequestInteractor();
		SearchResultsJSON['query_protein_id_array'] = previousQueryProteinIdArray;
		queryParameters.queryProteinIdArray = previousQueryProteinIdArray;
		queryProteinIdArray = previousQueryProteinIdArray;
		removedProteins = [];
		main();

		$("#overlay_network_loader_image").fadeOut( "fast", function() {});
		$("#overlay_network_table").fadeOut( "fast", function() {});
		$('#interaction_info').collapse("hide");
	});
}


function getFilterParameter(){	
	
	var filter_parameter = 'None';
	
	if($('#filter_parameter_query_query').is(':checked')){
		filter_parameter = 'query_query';	
	}else if($('#filter_parameter_query_interactor').is(':checked')){
		filter_parameter = 'query_interactor';	
	}else{
		filter_parameter = 'None';	
	}
	
	return filter_parameter;
}

function setRemoveProteinFromNetworkEvents(){
	$(document).delegate(".remove_protein_from_network","click",function () { 	
		var protein_id = $(this).attr('data');
		$(".qtip").addClass("hidden");
		removedProteins.push(protein_id);
		updateCytoscapeNetwork();
	});
}

//*****************************************************************************************//

function getLayout(){
	var layout = '';
	if(allInteractionArray.length > 200){
		layout = 'cose';
	}else{
		layout = 'cola';	
	}
	return layout;
}


function getComplexesContainingMoreThanOneInteractor(){

	var complexContainingOneInteractorArray = [];
	var complexesContainingMoreThanOneInteractorArray = [];
	
	for (i = 0; i < currentProteinArray.length; ++i) {	
		var proteinId = currentProteinArray[i].protein_id;
		if (typeof allProteinComplexArray !== 'undefined'){
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
	currentProteinArray = filterProteinAnnotation();	
	currentProteinArray = Array.from(new Set(currentProteinArray));	
	currentInteractionArray = filterInteractionCatagoryAndScore();	
	currentInteractionArray = Array.from(new Set(currentInteractionArray));
	currentInteractionArray = filterInteractionsWithMissingProteins(currentProteinArray, currentInteractionArray);	
	currentInteractionArray = Array.from(new Set(currentInteractionArray));	
	currentInteractionArray = filterInteractionsNotIncludingQueryProteins(currentInteractionArray);
	currentProteinArray = filterProteinsWithNoInteractions(currentProteinArray, currentInteractionArray);	
	currentProteinArray = Array.from(new Set(currentProteinArray));
	
	var filteredGenesArray = [];
	var currentGeneNameArray = [];
 	for (i = 0; i < currentProteinArray.length; ++i) {	
 		var geneName = currentProteinArray[i]['protein_gene_name'];
 		currentGeneNameArray.push(geneName);
 	}
 	for (i = 0; i < allProteinArray.length; ++i) {	
 		var geneName = allProteinArray[i]['protein_gene_name'];
 		if(currentGeneNameArray.indexOf(geneName) == -1){
 			filteredGenesArray.push(geneName);
 		}
 	}
 	filteredProteinSummary = filteredGenesArray.join("</br>");
	$("#proteins_filtered_out_summary").html(filteredProteinSummary);
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
		queryProteinInteractorArray.push(+queryProteinIdArray[i]);
	}

	for (i = 0; i <  currentInteractionArray.length; ++i) {
		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		
		if ($.inArray(+sourceProteinId, queryProteinIdArray) != -1 || $.inArray(+targetProteinId, queryProteinIdArray) != -1 ){
			queryProteinInteractorArray.push(+sourceProteinId);
			queryProteinInteractorArray.push(+targetProteinId);
		} 
	}
	
	queryProteinInteractorArray = Array.from(new Set(queryProteinInteractorArray));
	
	for (i = 0; i <  currentInteractionArray.length; ++i) {
		var sourceProteinId = currentInteractionArray[i]['interactor_A']['protein_id'];
		var targetProteinId = currentInteractionArray[i]['interactor_B']['protein_id'];
		if ($.inArray(+sourceProteinId, queryProteinInteractorArray) != -1 && $.inArray(+targetProteinId, queryProteinInteractorArray) != -1){
			currentInteractionArray2.push(currentInteractionArray[i]);
		} 
	}
	return currentInteractionArray2;
}


function filterProteinAnnotation(){	
	var currentProteinArray = [];

	for (i = 0; i < allProteinArray.length; ++i){
		var proteinId = allProteinArray[i].protein_id;
		if(!removedProteins.includes(proteinId)){
			var proteinName = allProteinArray[i].protein_uniprot_id;
			var geneName = allProteinArray[i].protein_gene_name;
			var proteinDescription = allProteinArray[i].protein_description;
			var linkArray = allProteinArray[i].protein_external_links;
			var proteinAnnotationArray = allProteinArray[i].annotation_array;
			var removeProtein = false;	
			if(proteinAnnotationArray['tissue_expression']){
				var fields = AnnotationTypesArray['tissue_expression']['fields'];
				var filter = AnnotationTypesArray['tissue_expression']['filter'];
				var proteinTissueArray = JSON.parse(proteinAnnotationArray['tissue_expression']);
				for (var annotation_name in proteinTissueArray) {
					var annotation_value = AnnotationParameterArray[annotation_name];
					if(annotation_value == true){
						if(5 > proteinTissueArray[annotation_name] || typeof proteinTissueArray[annotation_name] == "undefined" ){removeProtein = true;}		
					}	
				}
			}
			if(proteinAnnotationArray['subcellular_location']){
				var proteinLocationArray = JSON.parse(proteinAnnotationArray['subcellular_location']);
				for (var annotation_name in proteinLocationArray) {
					var annotation_value = AnnotationParameterArray[annotation_name];
					if(annotation_value == true){
						if(proteinLocationArray[annotation_name] == "" || typeof proteinLocationArray[annotation_name] == "undefined" ){removeProtein = true;}		
					}	
				}
			}
			if(removeProtein == false){
				currentProteinArray.push(allProteinArray[i]);
			}
		}else{
			removeProtein = true;
		}
	}	
	
	
	return currentProteinArray;
}

function filterProteinTissueExpression(){
	var currentProteinArray = [];	
	for (i = 0; i < allProteinArray.length; ++i) {
		var proteinId = allProteinArray[i].protein_id;
		var proteinName = allProteinArray[i].protein_uniprot_id;
		var geneName = allProteinArray[i].protein_gene_name;
		var proteinDescription = allProteinArray[i].protein_description;
		var linkArray = allProteinArray[i].protein_external_links;
		//annotationArray = allProteinArray[i].annotation_array;
		var tissueExpressionArray = allProteinArray[i].tissue_expression_array;
	    var tissueArray = ['adipose_subcutaneous', 'adipose_visceral_omentum', 'adrenal_gland', 'artery_aorta', 'artery_coronary', 'artery_tibial', 'brain_0', 'brain_1', 'brain_2', 'breast_mammary_tissue', 'colon_sigmoid', 'colon_transverse', 'esophagus_gastroesophageal_junction', 'esophagus_mucosa', 'esophagus_muscularis', 'heart_atrial_appendage', 'heart_left_ventricle', 'kidney_cortex', 'liver', 'lung', 'minor_salivary_gland', 'muscle_skeletal', 'nerve_tibial', 'ovary', 'pancreas', 'pituitary', 'prostate', 'skin', 'small_intestine_terminal_ileum', 'spleen', 'stomach', 'testis', 'thyroid', 'uterus', 'vagina', 'whole_blood'];
	    var removeProtein = false;
		if(removeProtein == false){
	 		tissueArray.forEach(function(tissue){
	 			if(TissueExpressionParameterArray[tissue]){
		        	if( 5.0 > tissueExpressionArray[tissue] || typeof tissueExpressionArray[tissue] == "undefined"){
		        		removeProtein = true;		
		        	} 
	 			}
	        });
		}
		if(removeProtein == false){
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
		var categoryStatus = allInteractionArray[i]['interaction_category_array'];
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



function setNodeResizeAndColorChangeCheckboxEvents(){
	
	$('#tissue_expression_node_size').on('click', function(){

		if($('#tissue_expression_node_size').is(':checked')){
			
			if($('.annotation_checkbox:checkbox:checked').length > 1){
				$('.annotation_checkbox').prop('checked', false);
			}
		    $('.annotation_checkbox').click(function() {
		        $('.annotation_checkbox').not(this).prop('checked', false);
		    });
		}else if($('#tissue_specificity_node_color').is(':checked')){
			
		}else{
		    $('.annotation_checkbox').unbind('click');
		}
	});
	$('#tissue_specificity_node_color').on('click', function(){
		if($('#tissue_specificity_node_color').is(':checked')){
			if($('.annotation_checkbox:checkbox:checked').length > 1){
				$('.annotation_checkbox').prop('checked', false);
			}
		    $('.annotation_checkbox').click(function() {
		        $('.annotation_checkbox').not(this).prop('checked', false);
		    });
		}else if($('#tissue_expression_node_size').is(':checked')){
			
		}else{
		    $('.annotation_checkbox').unbind('click');
		}
	});
}

function setFilterParameterCheckboxEvents(){
	
	$('#filter_parameter_query_query').on('click', function(){
		if($('#filter_parameter_query_interactor').is(':checked')){
			$('#filter_parameter_query_interactor').prop('checked', false);
		}
	});
	$('#filter_parameter_query_interactor').on('click', function(){
		if($('#filter_parameter_query_query').is(':checked')){
			$('#filter_parameter_query_query').prop('checked', false);
		}
	});		
}



function tissueExpressionNodeSize(cy){
	if($('#tissue_expression_node_size').is(':checked')){
		for (i = 0; i < currentProteinArray.length; ++i) {
			var proteinAnnotationArray = currentProteinArray[i].annotation_array;
			var proteinId = currentProteinArray[i].protein_id;
			
			if(proteinAnnotationArray['tissue_expression']){
				var fields = AnnotationTypesArray['tissue_expression']['fields'];
				var filter = AnnotationTypesArray['tissue_expression']['filter'];
				var proteinTissueArray = JSON.parse(proteinAnnotationArray['tissue_expression']);
				var maxExpressionValue = '';
				for (var annotation_name in proteinTissueArray) {
					var annotation_value = AnnotationParameterArray[annotation_name];
					if(annotation_value == true){
						expressionValue = proteinTissueArray[annotation_name] * 3;
						if(expressionValue > maxExpressionValue){
							maxExpressionValue = expressionValue;
						}
					}
				}
				
				nodeID = '#' + proteinId;
				cy.$('#' + proteinId).style({ 'width': maxExpressionValue,	'height': maxExpressionValue});
			}	
		}	
	}
}

function tissueSpecificityNodeColor(cy){
	if($('#tissue_specificity_node_color').is(':checked')){
		for (i = 0; i < currentProteinArray.length; ++i) {
			var proteinAnnotationArray = currentProteinArray[i].annotation_array;
			var proteinId = currentProteinArray[i].protein_id;
			if(proteinAnnotationArray['tissue_specificity']){
				var fields = AnnotationTypesArray['tissue_specificity']['fields'];
				var filter = AnnotationTypesArray['tissue_specificity']['filter'];
				var proteinTissueArray = JSON.parse(proteinAnnotationArray['tissue_specificity']);
				for (var annotation_name in proteinTissueArray) {
					var annotation_value = AnnotationParameterArray[annotation_name];
					if(annotation_value == true){
						nodeColor = "#3c78d8";
						specificityValue = proteinTissueArray[annotation_name];
						nodeColor = getSpecificityColor(specificityValue, proteinId);
						nodeID = '#' + proteinId;
						cy.$('#' + proteinId).style({'background-color': nodeColor});
						
					}
				}	
			}	
		}
	}
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
			var annotationArray = this.data('annotation_array');
	 		var experimentArray = [];
	 		var literatureArray = [];
	 		var experimentTab = '';
	 		var literatureTab = '';
	 		
	 		if(annotationArray['experiment']){
	 			$.each(annotationArray['experiment'], function( index, annotation) {
	 				if(experimentArray.indexOf(JSON.parse(annotation)) == -1){
	 					experimentArray.push(JSON.parse(annotation));
	 				}
	 			});
	 		}
			
	 		if(annotationArray['litbm_interaction']){
	 			$.each(annotationArray['litbm_interaction'], function( index, annotation) {
	 				
	 				literatureArray.push(JSON.parse(annotation));
	 			});
	 		}

			var tabMenu = '<ul class="nav nav-tabs" style="margin: 0px;">';
			var experimentTab = '<div class="tab-content border"  style="pading: 0px; border-top: 0px;">';
			var $num = 0;
			
			var qtipHTML = '<div class="container" style="padding-top: 20px; width: 100%; max-width: 540px;"><div class="row" style="margin-bottom: 20px;"><div class="col-sm-12"><h3 style="font-weight: bold; color:' +  MainColorScheme + ';">' + Interaction + '</h3><div class="shadow" style="height:1px;"></div></div></div><div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Confidence Score</h4></div><div class="row">' + Score + '</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Experiment</h4></div>';

			if(experimentArray.length > 0){
				 
				$.each(experimentArray, function(i, experiment){		
					$num++;
					var screen_plural = ''
					if(experiment['num_screens'] == 1){
						screen_plural = 'screen';
					}else{
						screen_plural = 'screens';
					}
	
					if($num == 1){
						experimentTab = experimentTab + '<div id="' + $num + '" class="tab-pane fade in active" style="padding: 10px; min-width:500px;">';
						tabMenu = tabMenu + '<li class="active"><a data-toggle="tab" href="#'  + $num +  '">' + $num + '</a></li>';
					}else{
						experimentTab = experimentTab + '<div id="' + $num + '" class="tab-pane fade" style=" padding: 10px; min-width:500px;">';
						tabMenu = tabMenu + '<li ><a data-toggle="tab" href="#'  + $num +  '">' + $num + '</a></li>';
					}
					
					
					experimentTab = experimentTab + '<div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Dataset</h4></div><div class="row">' + experiment['dataset'] + 
					'</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Orientation</h4>' + 
					'</div><div class="row">DNA Binding Domain: ' + experiment['dna_binding_domain'] + '</div><div class="row">Activation Domain: ' + experiment['activation_binding_domain'] + 
					'</div><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Open Reading Frames</h4></div><div class="row">Open Reading Frame of ' + 
					experiment['dna_binding_domain_name'] + ': <a href="http://horfdb.dfci.harvard.edu/index.php?page=showdetail&orf=' + experiment['orf_A_id'] + '" target=_blank>' + 
					experiment['orf_A_id'] + '</a></div><div class="row">Open Reading Frame of ' + 
					experiment['activation_domain_name'] + ': <a href="http://horfdb.dfci.harvard.edu/index.php?page=showdetail&orf=' + experiment['orf_B_id'] + '" target=_blank>' + 
					experiment['orf_B_id'] + '</a></div>' +
					'<div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Assay Version</h4></div>' +
					'<div class="row">This interaction was identified in assay version ' + experiment['assay_version'] + '</div>' +
					'<div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Screens</h4></div><div class="row">This interaction was identified in ' + 
					experiment['num_screens'] + ' ' + screen_plural + '</div></div></div>';
	
				});
			}

			if(literatureArray.length > 0){
				$num++;
				experimentTypeArray = defineExperimentTypeArray();
				if($num == 1){
					literatureTab = literatureTab + '<div id="' + $num + '" class="tab-pane fade in active" style="padding: 10px; min-width:500px;">';
					tabMenu = tabMenu + '<li class="active"><a data-toggle="tab" href="#'  + $num +  '">Literature</a></li>';
				}else{
					literatureTab = literatureTab + '<div id="' + $num + '" class="tab-pane fade" style=" padding: 10px; min-width:500px;">';
					tabMenu = tabMenu + '<li ><a data-toggle="tab" href="#'  + $num +  '">Literature</a></li>';
				}
				literatureTab = literatureTab + '<div class="row"><div class="row"><h4  style="font-weight: bold; color: ' +  MainColorScheme + ';">Publications</h4></div>';

				var pmidArray = [];
				var binaryExperimentArray = {};
				var nonbinaryExperimentArray = {};

				$.each(literatureArray, function(i, literature){					
					var pmid = literature['pmid'];					
					var binary_type = literature['binary_type'];
					var experiment_type = literature['experiment_type'];
					var experimentType = experimentTypeArray[experiment_type];
					if(binary_type == 'binary'){
						if (!(experimentType in binaryExperimentArray)){binaryExperimentArray[experimentType] = [];}
						binaryExperimentArray[experimentType].push(pmid);
					}else if(binary_type == 'non_binary'){
						if (!(experimentType in nonbinaryExperimentArray)){nonbinaryExperimentArray[experimentType] = [];}
						nonbinaryExperimentArray[experimentType].push(pmid);
					}	
					pmidArray.push(pmid);
				});

				
				
				var pmidArrayUnique = Array.from(new Set(pmidArray));

				var pmidString = pmidArrayUnique.join('+');
				var ncbiString = "https://www.ncbi.nlm.nih.gov/pubmed/?term=" + pmidString;
				if(false){
				literatureTab = literatureTab + '<div class="row"><a href="' + ncbiString + '" target="_blank">Search Literature</a></div>';
				}
				if(Object.keys(binaryExperimentArray).length > 0){
					literatureTab = literatureTab + '<div class="row" style="margin-bottom:0px; font-weight: bold; color: #a51c30;">Binary</div>';
					$.each(binaryExperimentArray, function(experiment, pmids){
						var pmidString = pmids.join('+');
						literatureTab = literatureTab + '<div class="row" style="margin-bottom:0px;"><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=' + pmidString + '" target="_blank">' + experiment + '</a></div>';					
					});
				}
				if(Object.keys(nonbinaryExperimentArray).length > 0){
					literatureTab = literatureTab + '<div class="row" style="margin-bottom:0px; font-weight: bold; color: #a51c30;">Non Binary</div>';
					$.each(nonbinaryExperimentArray, function(experiment, pmids){
						var pmidString = pmids.join('+');
						literatureTab = literatureTab + '<div class="row" style="margin-bottom:0px;"><a href="https://www.ncbi.nlm.nih.gov/pubmed/?term=' + pmidString + '" target="_blank">' + experiment + '</a></div>';
					});
				}
			}
			
			
			
			if(experimentArray.length == 0 && literatureArray.length == 0){
				qtipHTML = '<div class="row">No Experimental Data Available</div>';
			}
			
			
			tabMenu = tabMenu + '</ul>';
			
			
			qtipHTML = qtipHTML + tabMenu + experimentTab + literatureTab + '<div>';
			
			return qtipHTML;
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


function defineExperimentTypeArray(){

	var experimentTypeArray = {
	"0905":"amplified luminescent proximity homogeneous assay","0678":"antibody array","0008":"array technology","0010":"beta galactosidase complementation","0011":"beta lactamase complementation",
	"0809":"bimolecular fluorescence complementation","0012":"bioluminescence resonance energy transfer","0030":"cross-linking study","0111":"dihydrofolate reductase reconstruction","0034":"display technology",
	"0605":"enzymatic footprinting","0411":"enzyme linked immunosorbent assay","0047":"far western blotting","0048":"filamentous phage display","0052":"fluorescence correlation spectroscopy","0053":"fluorescence polarization spectroscopy",
	"0055":"fluorescent resonance energy transfer","0417":"footprinting","0728":"gal4 vp16 complementation","0065":"isothermal titration calorimetry","0425":"kinase scintillation proximity assay","0066":"lambda phage display",
	"0369":"lex-a dimerization assay","0729":"luminescence based mammalian interactome mapping","0231":"mammalian protein protein interaction trap","0077":"nuclear magnetic resonance","0081":"peptide array",
	"0084":"phage display","0089":"protein array","0090":"protein complementation assay","0031":"protein cross-linking with a bifunctional reagent","0095":"proteinchip(r) on a surface-enhanced laser desorption/ionization",
	"0813":"proximity enzyme linked immunosorbent assay","0726":"reverse two hybrid","0440":"saturation binding","0099":"scintillation proximity assay","0888":"small angle neutron scattering","1204":"split firefly luciferase complementation",
	"1037":"split renilla luciferase complementation","0107":"surface plasmon resonance","0921":"surface plasmon resonance array","0108":"t7 phage display","0370":"tox-r dimerization assay","0232":"transcriptional complementation assay",
	"0018":"two hybrid","0397":"two hybrid array","0399":"two hybrid fragment pooling approach","0398":"two hybrid pooling approach","1112":"two hybrid prey pooling approach","0112":"ubiquitin reconstruction","0114":"x-ray crystallography",
	"0115":"yeast display","0588":"3 hybrid method","0889":"acetylase assay","10020":"affinity capture-RNA","0004":"affinity chromatography technology","0400":"affinity technology","1147":"ampylation assay","0006":"anti bait coimmunoprecipitation",
	"0007":"anti tag coimmunoprecipitation","0257":"antisense rna","0872":"atomic force microscopy","0880":"atpase assay","0947":"bead aggregation assay","0969":"bio-layer interferometry","0401":"biochemical","0013":"biophysical","0968":"biosensor",
	"0276":"blue native page","0402":"chromatin immunoprecipitation assays","0091":"chromatography technology","0016":"circular dichroism","0017":"classical fluorescence spectroscopy","0990":"cleavage assay ","10023":"co-fractionation","0019":"coimmunoprecipitation",
	"0403":"colocalization","0021":"colocalization by fluorescent probes cloning","0022":"colocalization by immunostaining","0023":"colocalization/visualisation technologies","0807":"comigration in gel electrophoresis","0404":"comigration in non denaturing gel electrophoresis",
	"0808":"comigration in sds page","0405":"competition binding","0663":"confocal microscopy","0025":"copurification","0027":"cosedimentation","0028":"cosedimentation in solution","0029":"cosedimentation through density gradient","0406":"deacetylase assay","0870":"demethylase assay",
	"0943":"detection by mass spectrometry","1311":"differential scanning calorimetry","0038":"dynamic light scattering","0894":"electron diffraction","0040":"electron microscopy","0042":"electron paramagnetic resonance","0410":"electron tomography","0413":"electrophoretic mobility shift assay",
	"0412":"electrophoretic mobility supershift assay","0982":"electrophoretic mobility-based method","0415":"enzymatic study","0045":"experimental interaction detection","1022":"field flow fractionation","0049":"filter binding","0416":"fluorescence microscopy","0051":"fluorescence technology",
	"0054":"fluorescence-activated cell sorting","0949":"gdp/gtp exchange assay","0254":"genetic interference","0059":"gst pull down","0419":"gtpase assay","0061":"his pull down","0510":"homogeneous time resolved fluorescence","0428":"imaging techniques","0858":"immunodepleted coimmunoprecipitation",
	"0492":"in vitro","0493":"in vivo","0423":"in-gel kinase assay","0260":"inhibitor small molecules","0859":"intermolecular force","0226":"ion exchange chromatography","1246":"ion mobility mass spectrometry of complexes","0420":"kinase homogeneous time resolved fluorescence",
	"0426":"light microscopy","0067":"light scattering","0069":"mass spectrometry studies of complexes","0944":"mass spectrometry study of hydrogen/deuterium exchange","0515":"methyltransferase assay","0516":"methyltransferase radiometric assay",
	"0071":"molecular sieving","0330":"molecular source","1247":"mst","0893":"neutron diffraction","0434":"phosphatase assay","0841":"phosphotransferase assay","0953":"polymerization ","0435":"protease assay","0424":"protein kinase assay","0437":"protein tri hybrid",
	"10018":"protein-peptide","10021":"protein-RNA","1313":"proximity labelling technology","0096":"pull down","0227":"reverse phase chromatography","0097":"reverse ras recruitment system","1038":"silicon nanowire field-effect transistor","0892":"solid phase assay","1104":"solid state nmr",
	"1103":"solution state nmr","0104":"static light scattering","0105":"structure based prediction","0676":"tandem affinity purification","0020":"transmission electron microscopy","0339":"undetermined sequence position","0826":"x ray scattering","0825":"x-ray fiber diffraction","0512":"zymography",
	"0418":"genetic","0363":"inferred by author","0364":"inferred by curator","0256":"rna interference ","0686":"unspecified method","1356":"validated two hybrid","1314":"proximity-dependent biotin identification","0964":"infrared spectroscopy","1086":"equilibrium dialysis","1203":"split luciferase complementation",
	"0814":"protease accessibility laddering","2189":"avexis","1235":"thermal shift binding","1017":"rna immunoprecipitation","1016":"fluorescence recovery after photobleaching","1024":"scanning electron microscopy","0997":"ubiquitinase assay","0727":"lexa b52 complementation",
	"0920":"ribonuclease assay","1000":"hydroxylase assay","0655":"lambda repressor two hybrid","0991":"lipoprotein cleavage assay","1010":"neddylase assay","1019":"protein phosphatase assay","0963":"interactome parallel affinity capture",
	}
	return experimentTypeArray;

}

function setDataFileCheckboxEvents(){
	$('#return_data_file').change(function () {
	    if ($(this).prop('checked')) {
	        $('#return_data_file_interactor').prop('checked', true);
	    } else {
	        $('#return_data_file_interactor').prop('checked', false);
	    }
	});
	$('#return_data_file').trigger('change');
	
	$('#return_data_file_interactor').change(function () {
	    if ($(this).prop('checked')) {
	        $('#return_data_file').prop('checked', true);
	    } else {
	        $('#return_data_file').prop('checked', false);
	    }
	});
	$('#return_data_file_interactor').trigger('change');
	
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
	url = Url + 'app_dev.php/term_enrichment/' + requestTerm;
	$.getJSON(url, function(JsonData) { 		
		$("#MF_table").empty();	
	 	if(typeof JsonData.MF !== 'undefined' && JsonData.MF.length > 0 ){
		 	JsonData.MF.forEach(function(MF_row, i) {
		 		$("#MF_table").append("<tr class='enrichment_row' data='" + MF_row['list'] + "' term='" + MF_row['GO_term'] + "'><td>" +
		 				"<a href='http://amigo.geneontology.org/amigo/term/"+ MF_row['GO_term_code'] + "' target='_blank'>"
		 				+ MF_row['GO_term_code'] + "</a></td><td>" + MF_row['GO_term'] + "</td>" +
		 						"<td class='row_qtip' data-sort-value='"+ Number(MF_row['p_value']) +"' >" + MF_row['p_value'] + "</td></tr><tr class='hidden'><td></td></tr>");
		 	});
	 	}else{
	 		$("#MF_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#MF_table").trigger('footable_redraw');

	 	$("#CC_table").empty();	 	
	 	if(typeof JsonData.CC !== 'undefined' && JsonData.CC.length > 0 ){
		 	JsonData.CC.forEach(function(CC_row, i) {
				$("#CC_table").append("<tr class='enrichment_row' data='" + CC_row['list'] + "' term='" + CC_row['GO_term'] + "'><td>" +
						"<a href='http://amigo.geneontology.org/amigo/term/"+ CC_row['GO_term_code'] + "' target='_blank'>" + 
						CC_row['GO_term_code'] + "</a></td><td>" + CC_row['GO_term'] + "</td>" +
								"<td data-sort-value='" + Number(CC_row['p_value']) + "' >" +
								CC_row['p_value'] + "</td><td></tr><div class='hidden'></div>");
		 	});
	 	}else{
	 		$("#CC_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");	
	 	}
	 	$("#CC_table").trigger('footable_redraw');
	 	$("#BP_table").empty();
	 	if(typeof JsonData.BP !== 'undefined' && JsonData.BP.length > 0 ){	

		 	JsonData.BP.forEach(function(BP_row, i) {
				$("#BP_table").append("<tr class='enrichment_row' data='" + BP_row['list'] + "' term='" + BP_row['GO_term'] + "'><td>" +
						"<a href='http://amigo.geneontology.org/amigo/term/"+ BP_row['GO_term_code'] + "' target='_blank'>"  + 
						BP_row['GO_term_code'] + "</a></td><td>" + BP_row['GO_term'] + "</td>" +
								"<td data-sort-value='"+ Number(BP_row['p_value']) +"' >" + BP_row['p_value'] + "</td></tr><div class='hidden'></div>");	 
		 	});
	 	}else{
	 		$("#BP_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");		
	 	}
	 	$("#BP_table").trigger('footable_redraw');
	 	$("#rea_table").empty();
	 	if(typeof JsonData.rea !== 'undefined' && JsonData.rea.length > 0){	
		 	JsonData.rea.forEach(function(rea_row, i) {
				var reac_id = rea_row['GO_term_code'].replace("REAC:", '');
				$("#rea_table").append("<tr class='enrichment_row' data='" + rea_row['list'] + "' term='" + rea_row['GO_term'] + "'><td>" +
						"<a href='http://www.reactome.org/content/detail/"+ reac_id + "' target='_blank'>"  + 
						rea_row['GO_term_code'] + "</a></td><td>" + rea_row['GO_term'] + "</td>" +
								"<td data-sort-value='"+ Number(rea_row['p_value']) +"' >" + rea_row['p_value'] + "</td></tr><div class='hidden'></div>");
		 	});
	 	}else{
	 		$("#rea_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#rea_table").trigger('footable_redraw');
	 	
	 	$("#cor_table").empty();
	 	if(typeof JsonData.cor !== 'undefined' && JsonData.cor.length > 0){
		 	JsonData.cor.forEach(function(cor_row, i) {
	 			var cor_id = cor_row['GO_term_code'].replace("CORUM:", '');
	 			$("#cor_table").append("<tr class='enrichment_row' data='" + cor_row['list'] + "' term='" + cor_row['GO_term'] + "'><td>" +
	 					"<a href='http://mips.helmholtz-muenchen.de/corum/?id="+ cor_id + "' target='_blank'>"  + 
	 					cor_row['GO_term_code'] + "</a></td><td>" + cor_row['GO_term'] + "</td>" +
	 							"<td data-sort-value='"+ Number(cor_row['p_value']) +"' >" + cor_row['p_value'] + "</td></tr><div class='hidden'></div>");
		 	});
	 	}else{
	 		$("#cor_table").append("<tr><td colspan='3'>No Significantly Enriched Terms</td></tr>");
	 	}
	 	$("#cor_table").trigger('footable_redraw');



	});

}


function downloadEnrichedTermProteinsFile(enrichedTermProteins){
	
	fileName = getFileName('interactors_csv');

	var dataFile = "Gene Name,Ensembl ID,Uniprot ID,Entrez ID,Protein Description\r\n";
 	for (i = 0; i < currentProteinArray.length; ++i) {
 		
 		var proteinId = currentProteinArray[i].protein_id;
 		var uniprotId = currentProteinArray[i].protein_uniprot_id;
 		var ensemblId = currentProteinArray[i].protein_ensembl_id;
 		var entrezId = currentProteinArray[i].protein_entrez_id;
 		var geneName = currentProteinArray[i].protein_gene_name;
 		var proteinDescription = currentProteinArray[i].protein_description;
 		var nodeProteinId = proteinId;
 		if(enrichedTermProteins.indexOf(geneName) != -1){
 			dataFile = dataFile + geneName + "," + ensemblId + "," + uniprotId + "," + entrezId + "," + proteinDescription + "\n";	
 		}	
 	}
 	dataFile = getDownloadFileFooter(dataFile);
 	 	
 	downloadFile(fileName, dataFile);
}


function setLayoutClickEvent(cy){
	
 	$('.layout').on("click", function(event){
 	    
 		var layoutType = event.target.getAttribute('data');
 		$("#grid2").css("background-color: #f1f1f1;");
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
	    	 queryParameters.ScoreParameter = ui.value;

	     },
	     slide: function( event, ui ) {
	       $("#min_interaction_score_handle").html(ui.value);
	     }
	 });
	
	 $("#min_interaction_score_handle").html($( "#min_interaction_score" ).slider( "value" ));
	 $("#min_interaction_score").draggable();
}


function setAnnotationCheckboxEvents(){

	for (var key in AnnotationTypesArray) {
	    var annotationType = AnnotationTypesArray[key];
		var fieldsArray = JSON.parse(annotationType['fields']);
		var type = annotationType['type'];
		var showInFilter = annotationType['show_in_filter'];

		if(showInFilter == 1){
			
			for (var fieldName in fieldsArray) {
			    var field = fieldsArray[fieldName];
			    var checkBoxId = "#" + field + "_checkbox";
			    $(checkBoxId).on('change', createCheckBoxEvent(checkBoxId, type, field));

			}
		}		
	}
}

function createCheckBoxEvent(checkBoxId, _type, _field) {
    return function() { 	
	    	if($(checkBoxId).is(':checked')){
				AnnotationParameterArray[_field] = true;
				
		 	}else if(!$(checkBoxId).is(':checked')){		
		 		AnnotationParameterArray[_field] = false;
		 	}   	
    	}
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
			$("#overlay_network_cy_rest").fadeIn( "fast", function() {});
		    $(".qtip").addClass("hidden");
		    $("body").addClass("noscroll");
			$(".cancel_cy_message ").on('click', function(){
				$("#overlay_network_cy_rest").fadeOut( "fast", function() {});
			});
		}		
	});
}

function setTooManyInteractionsEvent(){
	$("#too_many_interactions_message").removeClass("hidden");	
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
	}).success(function(networkId){networkSUID = networkId.networkSUID;console.log(networkSUID)});
	
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
		$("#toggle_hover_highlighting_cy").removeClass('hidden');
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
		$("#toggle_hover_highlighting_cy").qtip({
            content: {
                text: "Toggle node highlighting on hover"
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
    	        event: 'mouseenter',
    	        delay: 700,
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

function setPngDownloadClickEvent(){
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

function setExampes(){
	
	$("#random_query").on('click', function(){	
		var proteins = ["UBE2V1","GSTO2","ZSCAN16","IMP3","ZYX","ZNF547","NMU","TBC1D3B","RIC8A","ZNF512B","MITD1","BOLA1","USP25","KIAA0907","TACO1","ZNF639","SFMBT1","PATL1","DHX15","RBM17","KRT74","KRT2","TSSC4","ZBTB33","VHL","MPPED2","UBL4A","LSM1","LSM3","TUFM","SSBP3","RNF20","ENPP7","RPL22","GOLGA6L2","SMAP2","ADAMTSL3","PPIB","RAPGEF3","POP5","USO1","CFHR5","CTAGE5","FKBP1A","ZSCAN18","PTS","SLC6A20","CETN3","PBX1","HNRNPCL1","LCOR","S100A1","SPDYE4","ATP5O","CCDC28B","ZNF341","CDK4","CCND3","ZNF503","ZNF337","GDAP1","CIAO1","CBSL","CBS","GCA","ZNF114","CCNG1","ZNF558","WASF1","CXCR2","C11orf68","PTPRN","TIMM23","CDK6","ZNF266","CALN1","ZNF232","ARNT2","NIPAL4","TRIM26","MRM3","PSPC1","SKA1","DUSP4","ZNF80","MAP1LC3B","ERCC3","MS4A4A","MYDGF","FST","CLNS1A","MCMBP","NGB","USP15","MAB21L2","ABT1","PELO","SORT1","HOXC9","MAGEA8","gene_name","HDX","SAPCD2","SMOC1","TRIM10","KRT32","ACY1","ARL6IP4","INPP5K","MAD2L1BP","SBK3","ZSCAN26","ESM1","ANKHD1","FAM221B","TRAF3IP2","CD68","ANKRD28","HOXD12","CLDN4","SH3GLB2","CCDC158","SLC22A23","LARP4","PLEKHA2","WWP1","BAIAP2L2","PCBP3","STK3","CD302","OOEP","PDCD6","APEX2","HBA1","UBA52","CAGE1","TTC25","HNF1B","AK8","COL4A3BP","SNRPF","CRLF3","TADA3","SLC25A6","SCYL1","KRTAP22-1","KCNF1","STRA8","HPRT1","JUP","SENP2","HSPD1","CCT3","CCER1","KCTD10","C3orf62","MVP","NGLY1","SLC14A2","NELFA","IER3","FAM118A","DDX17","ZNF578","TFAP4","PSMB5","TNR","PACRGL","HOXB2","SLC31A2","SETBP1","APOA5","NUDT14","ZBTB22","SLC25A48","RNF40","PKNOX1","NAXD","LRRC73","PROSER3","NDUFB11","MEAF6","ID3","KCTD21","LAPTM4B","TNFAIP3","PRC1","LGALS4","PTH1R","TSPAN18","ASZ1","CLRN2","EXOC4","ZG16","KCNIP3","MAGOH","PKD2","TAP1","CFL2","FLYWCH1","RNF115","gene_name","ZNF77","NICN1","ERH","SIVA1","CD69","JADE2","PMF1","CCDC106","LNP","HAT1","CES1","RTL8B","P2RY6","FAM46D","KIF24","HOXB6","PRAP1","MATR3","RORB","NLK","HDDC3","PIM1","SUMO3","RNF41","CCDC92","RING1","CBY1","MATR3","AOC1","ZC2HC1A","KLK8","ALKBH4","MIC13","RMDN2","SAP30BP","KRT82","OAZ3","UBE2Z","TEX9","ARHGEF9","SLC25A10","TBC1D30","RNF24","ADAM15","CDK5R1","TSFM","SERPINE1","POF1B","TINAGL1","NKD1"];
		var index = Math.floor(Math.random() * (250 - 1 + 1)) + 1;
		var query_protein = proteins[index];

		$("#search_identifier").val(query_protein);
		$("#filter_parameter_query_query").prop('checked', false);
		$("#filter_parameter_query_interactor").prop('checked', false);
	});
	
	$("#example_query_1").on('click', function(){	
	
		$("#search_identifier").val("BAD\nBAK");
		$("#filter_parameter_query_query").prop('checked', false);
		$("#filter_parameter_query_interactor").prop('checked', false);
	});

	$("#example_query_2").on('click', function(){	
		$("#search_identifier").val("BAD\nBAK");
		$("#filter_parameter_query_query").prop('checked', false);
		$("#filter_parameter_query_interactor").prop('checked', true);

		
	});
	
	$("#example_query_3").on('click', function(){	
		$("#search_identifier").val("BAD\nBAK");
		$("#filter_parameter_query_query").prop('checked', true);
		$("#filter_parameter_query_interactor").prop('checked', false);
	});
}




function setInteractorRowClickEvent(cy){
    $('.interactor_row').on("click", function(){
        	if($(this).hasClass("selected")){
        		$(this).removeClass("selected");
        		clearNetworkTableHighlightling(cy);
				deactivateToggleHoverHighlighting(cy);

            }else{
            	clearNetworkTableHighlightling(cy);
        		$(this).addClass("selected");
    			$(this).css('background', '#d9d9d9');
    			var id = $(this).attr('protein_id');
	    		cy.nodes().style({ 'opacity' : 0.1});
	    		cy.edges().style({ 'opacity' : 0.1});

	    		cy.$('#' + id).style({ 'opacity' : 1});
	    		cy.$('#' + id).neighborhood().style({ 'opacity' : 1});

	    		var active = $('#toggle_hover_highlighting_cy').hasClass('active');
	    		if(active == false){
	    			activateToggleHoverHighlighting(cy);
	    		}
            }
        }
     );
    $('.interactor_row').on("mouseover", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#eeeeee');
    	}
    });
    $('.interactor_row').on("mouseout", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#ffffff');
    	}
    });
    
}

function setInteractionRowClickEvent2(){

    $('.interaction_row').on("click", function(){		
    	if($(this).hasClass("selected")){
    		$(this).removeClass("selected");
    		$(this).css('background', '#ffffff');
    		var id = $(this).attr('id');
    		var index = selectedRows.indexOf(id);
    		if (index > -1) {
    			selectedRows.splice(index, 1);
    		}
        }else{
    		$(this).addClass("selected");
			$(this).css('background', '#d9d9d9');
			var id = $(this).attr('id');
			selectedRows.push(id);
        }
    	
    	console.log(selectedRows);
    	
    	if(selectedRows.length > 0){   	
	    	cy.nodes().style({ 'opacity' : 0.1});
	    	cy.edges().style({ 'opacity' : 0.1});
	    	$.each(selectedRows, function(i, selectedRowId){
	    		cy.$('#' + selectedRowId).style({ 'opacity' : 1});
	    		cy.$('#' + selectedRowId).neighborhood().style({ 'opacity' : 1});
	    		cy.$('#' + selectedRowId).connectedNodes().style({ 'opacity' : 1});
	    	});
			var active = $('#toggle_hover_highlighting_cy').hasClass('active');
			if(active == false){
				activateToggleHoverHighlighting(cy);
			}
    	}else{
	    	cy.nodes().style({ 'opacity' : 1});
	    	cy.edges().style({ 'opacity' : 1}); 	
	    	deactivateToggleHoverHighlighting(cy);
    	}    	
    });
    
    $('.interaction_row').on("mouseover", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#eeeeee');
    	}
    });
    
    $('.interaction_row').on("mouseout", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#ffffff');
    	}
    });
}



function setInteractionRowClickEvent(cy){

    $('.interaction_row').on("click", function(){

        	if($(this).hasClass("selected")){
        		$(this).removeClass("selected");
        		clearNetworkTableHighlightling(cy);
				deactivateToggleHoverHighlighting(cy);

            }else{
            	clearNetworkTableHighlightling(cy);
        		$(this).addClass("selected");
    			 $(this).css('background', '#d9d9d9');
    			 var id = $(this).attr('id');
	    		cy.nodes().style({ 'opacity' : 0.1});
	    		cy.edges().style({ 'opacity' : 0.1});
	    		cy.$('#' + id).style({ 'opacity' : 1});
	    		cy.$('#' + id).connectedNodes().style({ 'opacity' : 1});
	    		
	    		var active = $('#toggle_hover_highlighting_cy').hasClass('active');
	    		if(active == false){
	    			activateToggleHoverHighlighting(cy);
	    		}
            }
        }
     );
    $('.interaction_row').on("mouseover", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#eeeeee');
    	}
    });
    $('.interaction_row').on("mouseout", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#ffffff');
    	}
    });

}



function setInteractorRowClickEvent2(){
	
    $('.interactor_row').on("click", function(){
    	if($(this).hasClass("selected")){
    		$(this).removeClass("selected");
    		$(this).css('background', '#ffffff');
    		var id = $(this).attr('protein_id');
    		var index = selectedRows.indexOf(id);
    		if (index > -1) {
    			selectedRows.splice(index, 1);
    		}
        }else{
    		$(this).addClass("selected");
			$(this).css('background', '#d9d9d9');
			var id = $(this).attr('protein_id');
			selectedRows.push(id);
        }
    	
    	if(selectedRows.length > 0){   	
	    	cy.nodes().style({ 'opacity' : 0.1});
	    	cy.edges().style({ 'opacity' : 0.1});
	    	$.each(selectedRows, function(i, selectedRowId){
	    		cy.$('#' + selectedRowId).style({ 'opacity' : 1});
	    		cy.$('#' + selectedRowId).neighborhood().style({ 'opacity' : 1});
	    		cy.$('#' + selectedRowId).connectedNodes().style({ 'opacity' : 1});
	    	});
	    	var active = $('#toggle_hover_highlighting_cy').hasClass('active');
			if(active == false){
				activateToggleHoverHighlighting(cy);
			}
    	}else{
	    	cy.nodes().style({ 'opacity' : 1});
	    	cy.edges().style({ 'opacity' : 1}); 
	    	deactivateToggleHoverHighlighting(cy);
    	} 
    });
    $('.interactor_row').on("mouseover", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#eeeeee');
    	}
    });
    $('.interactor_row').on("mouseout", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#ffffff');
    	}
    });
}



function setEnrichmentRowClickEvent(){

	console.log('set');
	//annotation table rows
	$(document).on('click', ".enrichment_row, .tissue_expression_row", function(){
		console.log("click");
    	console.log($(this).hasClass("selected"));
	 	if($(this).hasClass("selected")){
	 		$(this).removeClass("selected");
	 		clearNetworkTableHighlightling(cy);
			deactivateToggleHoverHighlighting(cy);
	
	     }else{
	    	 clearNetworkTableHighlightling(cy);
	 		$(this).addClass("selected");
			 $(this).css('background', '#d9d9d9');
			 var id = $(this).attr('id');
			 var data = $(this).attr('data');
			 var proteins = data.split(",");
			 
			cy.nodes().style({ 'opacity' : 0.1});
			cy.edges().style({ 'opacity' : 0.1});
	
	
			var highlightednodes_array = [];
			console.log(proteins);
			$.each(proteins, function(i, protein){
	
				var nodeArray = cy.nodes().filter(function(ele){ return ele.data('gene_name') == protein});
				var node = nodeArray[0];
				if(typeof node != undefined){
					node.style({ 'opacity' : 1});	
					highlightednodes_array.push("#" + node.data('id'));
				}
	    	});
			
			var highlightednodes_string = highlightednodes_array.join();
			var subgraphNodes = cy.$(highlightednodes_string);		
			var edgeArray = subgraphNodes.edgesWith(subgraphNodes);		
			$.each(edgeArray, function(i, edge){
				
				edge.style({ 'opacity' : 1});
			});
    		var active = $('#toggle_hover_highlighting_cy').hasClass('active');
    		if(active == false){
    			activateToggleHoverHighlighting(cy);
    		}
       }
   });
	$(document).on("mouseover", ".enrichment_row, .tissue_expression_row", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#eeeeee');
    	}
    });
	$(document).on("mouseout", ".enrichment_row, .tissue_expression_row", function(){
    	if($(this).hasClass('selected') == false){
    		$(this).css('background', '#ffffff');
    	}
    });
    
}





function removeNodeHoverEvent(cy){
	$('#toggle_hover_highlighting_cy').unbind('click').click(function(){
		var active = $(this).hasClass('active');
		if(active == true){
			selectedRows = [];
			clearNetworkTableHighlightling(cy);
			deactivateToggleHoverHighlighting(cy);
		}else if(active == false){
			clearNetworkTableHighlightling(cy);
			activateToggleHoverHighlighting(cy);
		}
	});
}

function setNodeHoverEvent(cy){
 	cy.nodes().on("mouseover", function(e){	
 		clearNetworkTableHighlightling(cy);
 	    timer = setTimeout(function(){
     		cy.nodes().style({ 'opacity' : 0.1});
     		cy.edges().style({ 'opacity' : 0.1});
     		e.target.style({ 'opacity' : 1});
     		e.target.neighborhood().style({ 'opacity' : 1});
 	    }, 700);

 	}).on("mouseout", function(){
 	    clearTimeout(timer);
 		cy.nodes().style({ 'opacity' : 1});
 		cy.edges().style({ 'opacity' : 1});
 	    
 	});
}


function activateToggleHoverHighlighting(cy){
	$('#toggle_hover_highlighting_cy').addClass('active');
	$('#toggle_hover_highlighting_cy').css('border', '2px solid #3c78d8');
	cy.nodes().unbind('mouseout mouseover');
	
}

function deactivateToggleHoverHighlighting(cy){
	$('#toggle_hover_highlighting_cy').css('border', '1px solid #ccc');
	$('#toggle_hover_highlighting_cy').removeClass('active');
	setNodeHoverEvent(cy);
	
}

function clearNetworkTableHighlightling(cy){
	$( '.interaction_row' ).each(function(){ $(this).css('background', '#ffffff');});
	$( '.interactor_row' ).each(function(){ $(this).css('background', '#ffffff');});
	$( '.enrichment_row' ).each(function(){ $(this).css('background', '#ffffff');});
	$( '.tissue_expression_row' ).css('background', '#ffffff');
	$( '.subcellular_location_row' ).css('background', '#ffffff');
	cy.nodes().style({ 'opacity' : 1});
	cy.edges().style({ 'opacity' : 1});
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


function setTissueFilterQtips(){
	
	$("#tissue_expression_info").qtip({
        content: {
            text: "Reflect the level of tissue expression in node size."
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
	$("#tissue_specificity_info").qtip({
        content: {
            text: "Reflect the tissue specificity in node color."
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
	$("#score_info").qtip({
        content: {
            text: "Select a score cutoff to filter out PPIs from the results that display a score below that threshold. See the About section for more details."
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
	$("#interaction_status_info").qtip({
        content: {
            text: "<strong>Published:</strong> Include all interactions from datasets that are published with an associated publication.<br/>" +
            		"<strong>Validated:</strong> Include all interactions that are not yet published but that originate from datasets " +
            		"that have been validated by successfully testing a representative subset of these interactions in at" +
            		" least one orthogonal binary interaction detection assay.<br/>" +
            		"<strong>Verified:</strong> Verified: Include all interactions that are neither published nor validated but that " +
            		"were identified in pooled Y2H screens, tested positive in Y2H pairwise test and sequence confirmed.<br/>" +
            		"<strong>Literature:</strong> Include interactions that were curated from small-scale studies with at least" +
            		" two pieces of experimental evidences of which at least one stems from a binary interaction " +
            		"detection assay.Reflect the tissue specificity in node color."
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
	$("#tissue_expression_filter_info").qtip({
        content: {
            text: "Select the tissue(s) by which you want to filter the results, i.e. only display proteins known to be " +
            		"expressed in the selected tissues (based on GTEx data). See the About section for more details. " +
            		"Select the tissue(s) by which you want to filter the results, i.e. only display proteins known to be" +
            		" expressed in the selected tissues (based on GTEx data). See the About section for more details." +
            		" Select the tissue(s) by which you want to filter the results, i.e. only display proteins known" +
            		" to be expressed in the selected tissues (based on GTEx data). See the About section for more details." +
            		" Select the tissue(s) by which you want to filter the results, i.e. only display proteins known to be" +
            		" expressed in the selected tissues (based on GTEx data). See the About section for more details. "
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
}


function setSearchQtips(){
	
	$("#query_query_info").qtip({
        content: {
            text: "Only show interactions among query proteins."
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
	$("#query_interactor_info").qtip({
        content: {
            text: "Only show direct interactions with query proteins."
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
	
	$("#data_file_query_info").qtip({
        content: {
            text: "Return the results of your query in downloadable file format."
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
	
	$("#data_file_interactor_info").qtip({
        content: {
            text: "Return the results of your query in downloadable file format, useful if big queries and network display too slow. "
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

	$('.footable').footable({
		"paging": {
			"enabled": true,
			"current": 10
		}
	});

	$('#change-page-size').change(function (e) {
		e.preventDefault();
		var pageSize = $(this).val();
		$('.footable').data('page-size', pageSize);
		$('.footable').trigger('footable_redraw');
	});
	$('#change-page-size_interactor').change(function (e) {
		e.preventDefault();
		var pageSize = $(this).val();
		$('#search_result_table_interactor').data('page-size', pageSize);
		$('#search_result_table_interactor').trigger('footable_redraw');
	});
	
	$('#interactions_tab').on( 'shown.bs.tab', function () {
	    $('#search_result_table').trigger('footable_redraw');
	});

	$('#interactor_tab').on( 'shown.bs.tab', function () {
	    $('#search_result_table_interactor').trigger('footable_redraw');
	});
	
	
	$('#search_result_table').trigger('footable_redraw');
	
}

function setQueryNodeColor(cy){
	for (i = 0; i < queryProteinIdArray.length; ++i) {

		var queryProteinId = queryProteinIdArray[i];
		var selectID = '#' + queryProteinId;	
		cy.$(selectID).style({'background-color': QueryNodeColor });
		cy.$(selectID).data({'query' : 'query'});
	}
}

function updateSearchForm(){
	var queryGeneNameArray = [];
	var interactorGeneNameArray = [];
	
	for (i = 0; i < currentProteinArray.length; ++i) {	
		var currentProtein = currentProteinArray[i];
		var geneName = currentProtein["protein_gene_name"];
		var proteinId = currentProtein["protein_id"];
		interactorGeneNameArray.push(geneName);
		var a = queryProteinIdArray.indexOf(+proteinId);
		if(a != -1){
			
			queryGeneNameArray.push(geneName);
		}
	}
	var interactorProteins = interactorGeneNameArray.join("\n");
	
	var queryProteins = queryGeneNameArray.join("\n");
	$("#interactor_list").val(interactorProteins);
	$("#search_identifier").val(queryProteins);
}

function reloadPageSize(){

	var current = $("#change-page-size").val();
	$("#change-page-size").val(current).change();

}

function enableScroll(){
	if(allInteractionArray.length > 100){

	}else{

	}
}




function updateAnnotationTable(){
	
	for(type in AnnotationTypesArray){
		
		var annotation = AnnotationTypesArray[type];
		var fields_json = annotation['fields'];
		var show_in_table = annotation['show_in_table'];
		var fields = JSON.parse(fields_json);
		$('#' + type + '_table').empty();
		if(show_in_table == 1){
			for(name in fields){
				
				var value = fields[name];
					
				var data = getAnnotatedProteinString(value);	
				if(data != ''){
					annotation_row = '<tr class="' + type + '_row" data="' + data + '"term="' + value + '" style="display: table-row;"><td><span class="footable-toggle"></span>' + name + '</td></tr>';
					$('#' + type + '_table').append(annotation_row);
				}
			}
		}
	}
}

function getAnnotatedProteinString(annotation_name){

	var genes = [];

	for (i = 0; i < currentProteinArray.length; ++i) {
		
		var proteinId = currentProteinArray[i].protein_id;
		var proteinName = currentProteinArray[i].protein_uniprot_id;
		var geneName = currentProteinArray[i].protein_gene_name;
		var proteinDescription = currentProteinArray[i].protein_description;
		var linkArray = currentProteinArray[i].protein_external_links;
		var proteinAnnotationArrayJSON = currentProteinArray[i].annotation_array;

		if(typeof proteinAnnotationArrayJSON[type] != "undefined"){
			var proteinAnnotationArray = JSON.parse(proteinAnnotationArrayJSON[type]);

			if(type == 'tissue_expression'){
				
				if( proteinAnnotationArray[annotation_name] > 5 && typeof  proteinAnnotationArray[annotation_name] != "undefined"){
					
					genes.push(geneName);
				}
			}
			if(type == 'subcellular_location'){
				if(proteinAnnotationArray[annotation_name] != '' && typeof  proteinAnnotationArray[annotation_name] != "undefined"){
					
					genes.push(geneName);
				}	
			}
		}
	}

	var data = genes.join();
	
	return data;
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
		
		if($.inArray( +protein.protein_id, queryProteinIdArray ) != -1){
			intAct = intAct +  protein.protein_gene_name + '%20';
			
		}

	});


	
	stringUrl =  stringUrl + '&species=9606';
	davidUrl = davidUrl + '&tool=summary';
	

	$("#gene_mania_link_li").html('<a href="' + geneManiaUrl + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/gene_mania.png"/><div style="padding: 3px 5px;">GeneMania</div></div></a>');
	$("#string_link_li").html('<a href="' + stringUrl + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/string.png"/><div style="padding: 3px 5px;">STRING</div></div></a>');
	$("#reactome_link_li").html('<a id="reactome_link" style="cursor: pointer; padding: 0px;" data="' + reactomeUrl + '"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/reactome.png"/><div style="padding: 3px 5px;">Reactome</div></div></a>');
	$("#pathway_commons_link_li").html('<a href="' + pathwayCommonsUrl + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/pathway_commons.png"/><div style="padding: 3px 5px;">Pathway Commons</div></div></a>');
	$("#david_link_li").html('<a href="' + davidUrl + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/david.png"/><div style="padding: 3px 5px;">DAVID</div></div></a>');
	$("#gprofiler_link_li").html('<a href="' + gProfiler + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/gprofiler.png"/><div style="padding: 3px 5px;">gProfiler</div></div></a>');
	$("#cbioportal_link_li").html('<a href="' + cBioPortal + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/cbioportal.png"/><div style="padding: 3px 5px;">cBioPortal</div></div></a>');
	$("#intact_link_li").html('<a href="' + intAct + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/ebi.png"/><div style="padding: 3px 5px;">IntAct (Query)</div></div></a>');
	$("#complex_portal_link_li").html('<a href="' + complexPortal + '" style="padding: 0px;" target="_blank"><div style="display:inline-flex; width: 100%;"><img height="20" width="20" style="margin: 2px 5px 0px 5px; vertical-align:middle;" src="' + Url + '/assets/images/ebi.png"/><div style="padding: 3px 5px;">Complex Portal</div></div></a>');


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

function setSearchAutocomplete(){
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
		
		
		return $( "<li class='autocomplete_row'>" )
		.attr( "data-value", item.value)
		.append( "<span style='float:left'>" + item.label + "</span>" + "<span style='float:right'>" + item.num_interactions + "</span>" )
		.appendTo( ul );
		
	};
}

function setValidateSearchTerm(){
	$( "#search_identifier" ).on("change keyup paste", validateSearchTerms);
}

function setRemoveInvalidTerm(){
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
	var index = termCountArray.indexOf('');
	if (index > -1) {
		termCountArray.splice(index, 1);
	}
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
			$(".search_terms_not_found_query").removeClass('hidden');
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
			if(validTermCount == 1){
				$(".number_present_terms").html("1 Term");
			}else{
				
				$(".number_present_terms").html(validTermCount + ' Terms');
			}
			
		}
	});
}


function setSearchAutocompleteInteractor(){
	$("#interactor_list").autocomplete({
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
}

function preventDropDownMenuClose(){
    var isBootstrapEvent = false;
    if (window.jQuery) {
        var all = jQuery('*');
        jQuery.each(['hide.bs.dropdown', 
            'hide.bs.collapse', 
            'hide.bs.modal', 
            'hide.bs.tooltip',
            'hide.bs.popover'], function(index, eventName) {
            all.on(eventName, function( event ) {
                isBootstrapEvent = true;
            });
        });
    }
    var originalHide = Element.hide;
}

function setValidateSearchTermInteractor(){
	$( "#interactor_list" ).on("change keyup paste keydown keypress", validateSearchTermsInteractor());
}

function setRemoveInvalidTermInteractor(){
	$( "#remove_invalid_terms_interactor" ).on("click", function(){
		var invalidTerms = $('#invalid_terms_array_interactor').attr('data');
		var searchIdentifierValue = $("#interactor_list").val();
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
		$("#interactor_list").val(searchIdentifierValue);
		validateSearchTermsInteractor();
	});
}



function validateSearchTermsInteractor() {   
	var searchIdentifierValue = "/" + $("#interactor_list").val();
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
	var index = termCountArray.indexOf('');
	if (index > -1) {
	  array.splice(index, 1);
	}
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
			$("#all_terms_valid_interactor").addClass('hidden');
			$(".search_terms_not_found_interactor").removeClass('hidden');
			$("#invalid_terms_array_interactor").removeClass('hidden');
			$("#remove_invalid_terms_interactor").removeClass('hidden');
			$("#invalid_terms_array_interactor").attr('data', invalidTermsString);
			$("#invalid_terms_array_interactor").html(invalidTerms);
			$(".number_present_terms_interactor").html(validTermCount);
			$(".number_not_present_terms_interactor").html(invalidTermCount);
		}else{
			if($("#interactor_list").val() != ''){
				$("#all_terms_valid_interactor").removeClass('hidden');
			}
			$(".search_terms_not_found_interactor").addClass('hidden');
			$("#invalid_terms_array_interactor").addClass('hidden');                			
			$("#remove_invalid_terms_interactor").addClass('hidden');
			$(".number_present_terms_interactor").html(validTermCount);
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

function setProteinInteractionCountsArray(){
	$.each(allProteinArray, function(i, protein){
		proteinInteractionCountsInNetwork[protein.protein_id] = 0;
	});	
}

function resetProteinInteractionCountsInNetwork(){
	proteinInteractionCountsInNetwork.fill(0);
}



function getSwitch(){
	var switch_value = '';	
	if($('#return_data_file').is(':checked')){
		switch_value = 'return_data_file';		
	}else if(allInteractionArray.length > 8000){
		switch_value = 'too_many_interactions';	
	}else{
		switch_value = 'display_network';
	}
	return switch_value;
}





function setNetworkMenuDropdowns(){
	
	$(document).on('mouseup', function (e) {
		   if (
		    !$('.autocomplete_row').is(e.target)
		    && $('.autocomplete_row').has(e.target).length === 0 
			&& !$('.network_dropdown').is(e.target) // if the target of the click isn't the container...
		    && $('.network_dropdown').has(e.target).length === 0 // ... nor a descendant of the container
		    ){
			 $('.network_dropdown').removeClass('open');
			 $('.network_dropdown').removeClass('active');
		  }
		 });
	
	
	$('#search_dropdown_toggle').on('click', function(){	
		if($('#search_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#search_dropdown_toggle_li').addClass('open');
		}
	});
	$('#submit_query').on('click', function(){	
		$('.network_dropdown').removeClass('open');
		$('.network_dropdown').removeClass('active');	
	});
	$('#submit_interactors').on('click', function(){	
		$('.network_dropdown').removeClass('open');
		$('.network_dropdown').removeClass('active');
	});
	
	$('#filter_dropdown_toggle').on('click', function(){	
		if($('#filter_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#filter_dropdown_toggle_li').addClass('open');
		}
	});
	$('#filter_update').on('click', function(){	
		$('.network_dropdown').removeClass('open');
	});
	
	$('#layout_dropdown_toggle').on('click', function(){	
		if($('#layout_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#layout_dropdown_toggle_li').addClass('open');
		}
	});
	
	$('#download_dropdown_toggle').on('click', function(){	
		if($('#download_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#download_dropdown_toggle_li').addClass('open');
		}
	});
	
	$('#external_links_dropdown_toggle').on('click', function(){	
		if($('#external_links_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#external_links_dropdown_toggle_li').addClass('open');
		}
	});
	
	$('.close_dropdown').on('click', function(){
		$('.network_dropdown').removeClass('open');	
		$('.network_dropdown').removeClass('active');
	});
	
	$('#summary_dropdown_toggle').on('click', function(){	
		if($('#summary_dropdown_toggle_li').hasClass('open')){		
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
		}else{
			$('.network_dropdown').removeClass('open');
			$('.network_dropdown').removeClass('active');
			$('#summary_dropdown_toggle_li').addClass('open');
		}
	});
	
	
	$('#legend_dropdown_toggle_li').on('click', function(){	
		if($('#legend_dropdown_toggle_li').hasClass('open')){	
			$('.network_dropdown').removeClass('active');
			$('#legend_dropdown_toggle_li').removeClass('open');
		}else{
			$('.network_dropdown').removeClass('active');
			$('#legend_dropdown_toggle_li').addClass('open');
		}
	});
}


function getSpecificityColor(specificityValue, proteinId){	
	var nodeColor = "";
	if(queryProteinIdArray.includes(+proteinId) == false){
		if(specificityValue < -10){
			nodeColor = "#b1c9ef";		
		}else if(specificityValue < -8 && specificityValue > -10){
			nodeColor = "#8baee7";
		}else if(specificityValue < -5 && specificityValue > -8){
			nodeColor = "#6494e0";
		}else if(specificityValue < -2 && specificityValue > -5){
			nodeColor = "#3d79d8";
		}else if(specificityValue < 2 && specificityValue > -2){
			nodeColor = "#3c78d8";
		}else if(specificityValue > 2 && specificityValue < 5){
			nodeColor = "#2662c1";
		}else if(specificityValue > 5 && specificityValue < 8){
			nodeColor = "#1e4e9a";
		}else if(specificityValue > 8 && specificityValue < 10){
			nodeColor = "#173a73";
		}else if(specificityValue > 10){
			nodeColor = "#0f274d";
		}
	}else if(queryProteinIdArray.includes(+proteinId) == true){
		if(specificityValue < -10){
			nodeColor = "#ffd0d0";		
		}else if(specificityValue < -8 && specificityValue > -10){
			nodeColor = "#ffa2a2";
		}else if(specificityValue < -5 && specificityValue > -8){
			nodeColor = "#ff7373";
		}else if(specificityValue < -2 && specificityValue > -5){
			nodeColor = "#fe4545";
		}else if(specificityValue < 2 && specificityValue > -2){
			nodeColor = "#cc0000";
		}else if(specificityValue > 2 && specificityValue < 5){
			nodeColor = "#bb0000";
		}else if(specificityValue > 5 && specificityValue < 8){
			nodeColor = "#b90000";
		}else if(specificityValue > 8 && specificityValue < 10){
			nodeColor = "#8b0000";
		}else if(specificityValue > 10){
			nodeColor = "#5c0000";
		}	
	}
	return nodeColor;
}


