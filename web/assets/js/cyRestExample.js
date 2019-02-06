/**
 * 
 */

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
	}).success(alert('yes'));
}