$(function() {


var nodesJSON = new Object();
var edgesJSON = new Object();

nodesJSON = [];
edgesJSON = [];

function reloadPageSize(){

	var current = $("#change-page-size").val();
	$("#change-page-size").val(current).change();

}

function setFootable(){
	$('table').footable({
		"columns": [{

		}]});
	
	$('#change-page-size').change(function (e) {
		e.preventDefault();
		var pageSize = $(this).val();
		$('.footable').data('page-size', pageSize);
		$('.footable').trigger('footable_redraw');
	});
}


var array_1  = [];
var array_2 = [];


$.each(EdgeArray, function( key, value ) {
	var id_1 = value[0];
	var id_2 = value[1];
	
	array_1.push(id_1);
	array_2.push(id_2);
	
	edgesJSON.push({
		group: "edges",
		data: { id: value[0] + '_' + value[1], name: value[0] + '_' + value[1], color: 'red', source: 'node_' + value[0], target: 'node_' + value[1]},
		style: { "line-color": 'red'},
	});
	
});

function countInArray(array, what) {
    var count = 0;
    for (var i = 0; i < array.length; i++) {
        if (array[i] === what) {
            count++;
        }
    }
    return count;
}

$.each(NodeArray, function( key, value ) {
	
	var pmid = value[0];
	var year = value[1];
	var title = value[2];

	
	nodesJSON.push({"data": {"id": 'node_' + pmid, "layer": year, "year": year,  "name": pmid, "title": title, "color": "#33CC33"}, "group": "nodes", "classes": "nodes" });
	$('#qtips').append('<div id="' + pmid + '_qtip" class="hidden"><h3>' +  pmid + '</h3></br><h3>' +  title + '</h3></br><a href="http://localhost/workspace/openPIP/web/test/' + pmid + '" target="_blank">Search</a></br><a href="https://www.ncbi.nlm.nih.gov/pubmed/' + pmid + '" target="_blank">NCBI</a></div>')

});




//Map with the color of each layer ({layer1:color1, layer2:color2})


// Ordered list of layers from top to bottom 
var layers = YearArray;

//Name of the attribute that contains the information of the node layer
var layer_attribute_name = "layer";




//Background color
var backgroundColor = "#ffffff";

//Widht of the line between layers
var gridLineWidth = 0.2;
var gridColor = '#bbbbbb'
options = {
	    name: 'cerebral',
	    layer_attribute_name: layer_attribute_name, 
	    layers: layers, 
	    edgeColor: 'red',
	    edgeWidth: '0.5px',
	    edgeLabel: '#111f2d',
	    background: backgroundColor,
	    lineWidth: gridLineWidth, 
	    strokeStyle: gridColor,
	    font: font
	};

var cytoscapeJSON = nodesJSON.concat(edgesJSON);

var cy = cytoscape({

	container: document.getElementById('cy'),
    layout: options,
    showOverlay: false,
    zoom: 1,
    style: cerebral_style,
    elements: cytoscapeJSON,
    ready: function() {
        cy = this;
        cerebral_ready(cy);
    }

});

cy.$('.nodes').qtip({
	
	content: 
		function(){ 
		var name = this.data('name');
		var returnVar = $('#' + name + '_qtip').html();
		return returnVar;
		
	},
	position: {
	   my: 'center',
	   at: 'center',
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


cy.remove( "[[degree < 3]]" );


$.each(cy.$('.nodes'), function( key, node ) {

	$('#table').append('<tr class=""><td><a href="https://www.ncbi.nlm.nih.gov/pubmed/' + node.data('name') + '" target="_blank">' + node.data('name') + '</a></td><td>' + node.data('title') + '</td><td>' + node.data('year') + '</td><td>' + node.indegree() + '</td><td>' + node.outdegree() + '</td>');

});

setFootable();
reloadPageSize();



/** MODIFY THESE VARIABLES TO CUSTOMIZE YOUR NETWORK **/ 
/*
//Map with the color of each layer ({layer1:color1, layer2:color2})
var colors = {"Layer A": "#0f79ea", "Layer B": "#0F7C0B", "Layer C": "#DDDF04"};

//Ordered list of layers from top to bottom 
var layers = ['Layer A', 'Layer B', 'Layer C'];

//Name of the attribute that contains the information of the node layer
var layer_attribute_name = "layer";

//Color of hihglighted elements
var highLighColor = "#ADFF2F"; 

//Edges color, width and label color
var edgeColor = 'red'; 
var edgeWidth = '0.5px';
var edgeLabel = '#111f2d';

//Background color
var backgroundColor = "#a8a8a8";

//Widht of the line between layers
var gridLineWidth = 0.2;

//Color of the line between layers
var gridColor = '#ffffff';

//Font of the labels of each layer
var font = "12pt Arial";

//Node label color
var nodeLabel = 'white';
var borderNodeLabel = 'black';

/* DO NOT MODIFY CODE BELOW THIS LINE 
options = {
 name: 'cerebral',
 colors: colors, 
 layer_attribute_name: layer_attribute_name, 
 layers: layers, 
 background: backgroundColor,
 lineWidth: gridLineWidth, 
 strokeStyle: gridColor,
 font: font
};


$(loadCy = function() {


	cytoscape({	
		container: document.getElementById('cy'),
         layout: options,
         showOverlay: false,
         zoom: 1,
         style: cerebral_style,
         elements: elements,
         ready: function() {
             cy = this;
             cerebral_ready(cy);
         }
     });
 });

 $(window).resize(function() {
     loadCy();
 });

elements=[
{
  "data": {
   "id": "1",
   "name": "Node 1",
   "layer": "Layer B",
   "color": "#33CC33"
 },
 "group": "nodes"
},
{
 "data": {
   "id": "2",
   "name": "Node 2",
   "layer": "Layer A",
   "color": "#499DF5"
 },
 "group": "nodes"
},
{
 "data": {
   "id": "3",
   "name": "Node 3",
   "layer": "Layer C",
   "color": "#FBEC5D"
 },
 "group": "nodes"
},
{
 "data": {
   "id": "12",
   "name": "name of interaction 12",
   "source": "1",
   "target": "2",
   "idgroup": "12"
 },
 "group": "edges"
},
{
 "data": {
   "id": "23",
   "name": "name of interaction 23",
   "source": "2",
   "target": "3",
   "idgroup": "23"
 },
 "group": "edges"
},
{
 "data": {
   "id": "22",
   "name": "name of interaction 22",
   "source": "2",
   "target": "2",
   "idgroup": "22"
 },
 "group": "edges"
},
];
             
*/

	
});
	
	
	
	
	