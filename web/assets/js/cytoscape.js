/**
 * 
 */

$(function(){

	var cy = cytoscape({
		
	  container: document.getElementById('cy'),
	  
	  elements: {
	      nodes: [],      
	      edges: []
	    },
 
	  style: [
	          {
			    selector: '$node',
			    css: {
			      'padding-top': '10px',
			      'padding-left': '10px',
			      'padding-bottom': '10px',
			      'padding-right': '10px',
			      'text-valign': 'top',
			      'text-halign': 'center',
			      'background-color': '#55ACEE'
			    }
			  },
	          {
	            selector: '$node > node',
	            css: {
	              'content': 'data(protein_name)',
	              'padding-top': '10px',
	              'padding-left': '10px',
	              'padding-bottom': '10px',
	              'padding-right': '10px',
	              'text-valign': 'top',
	              'text-halign': 'center',
	              'background-color': '#ddd',

	            }
	          },
	          {
	            selector: 'edge',
	            css: {

	            	  'line-color' : '#aaa'
	            }
	          },
	          {
	            selector: ':selected',
	            css: {
	              'background-color': 'black',
	              'line-color': 'black',
	              'target-arrow-color': 'black',
	              'source-arrow-color': 'black'
	            }
	          }
	      ]
	});

	$.getJSON({{}}, function(result){
		alert("yes");
		var domainsString = result.domains;
		alert(domainsString);
		var domainsArray = domainsString.split(";");
		var proteinOfIntrestString = result.protein_of_intrest;
		var proteinOfIntrestArray = proteinOfIntrestString.split(";");
		var interactingProteinNodesString = result.interacting_protein_nodes;
		var interactingProteinNodesArray = interactingProteinNodesString.split(";");
	    var edgeString = result.edges;
		var edgeArray = edgeString.split(";");
		
		for (i = 0; i < proteinOfIntrestArray.length; ++i) {
			
			var proteinOfIntrestData = proteinOfIntrestArray[i].split(",");
			var proteinId = proteinOfIntrestData[0];
			var proteinName = proteinOfIntrestData[1];
			var domainId = proteinOfIntrestData[2]; 
			var domainName = proteinOfIntrestData[3]; 
			

			cy.add([{ 
				group: "nodes",
				data: { id: proteinId, protein_name: proteinName },
				classes: "protein_of_intrest"
			}]);
			
			cy.add([{ 
				group: "nodes",
				data: { id: domainId, name_domain: domainId, domain_name: domainName, protein_name: proteinName, parent: proteinId},
				id: domainId,
				classes: "domain"
			}]);
		}

		
		for (i = 0; i < interactingProteinNodesArray.length; ++i) {
			
			var interactingProteinNodesData = interactingProteinNodesArray[i].split(",");
			var proteinId = interactingProteinNodesData[0];
			var proteinName = interactingProteinNodesData[1];
			

			cy.add([{ 
				group: "nodes",
				data: { id: proteinId, protein_name: proteinName },
				classes: "interacting_protein_node"
			}]);

		}
		
		
		for (i = 0; i < edgeArray.length; ++i) {
			
			//foreach edge split into array containing data about the edge
			var edgeData = edgeArray[i].split(",");
			var sourceDomainId = edgeData [0];
			var domainName = edgeData [1];
			var targetProteinId = edgeData [2];
			var sourceProteinName = edgeData [3];
			var targetProteinName = edgeData [4];
			var modeData = edgeData[5];
			var scoreData = edgeData[6];
			
		
	
			//add edge data to cytoscape

	    	

		}
		
		var domain_colours = ["black", "#ca0020", "#f4a582", "#0571b0", "#92c5de", "#ffffbf"];
		
		
		for (i = 0; i < domainsArray.length; ++i) {
			
			var domainID = domainsArray[i];
			
			cy.$('#' + domainID).neighborhood( 'edge' ).style({'line-color' : domain_colours[domainID]});
			cy.$('#' + domainID).neighborhood( 'node' ).style({'background-color': domain_colours[domainID]});
			cy.$('#' + domainID).roots().style({'background-color': domain_colours[domainID]});
		}

		cy.$('.protein_of_intrest').style({'background-color': '#CCCCCC'});

		cy.center();
		
		cy.layout({ 
			name: 'concentric',
			avoidOverlap: true,
			equidistant: true,
			minNodeSpacing: 50,
		});
		
		cy.$('.protein_of_intrest').on('click', function(event){

			var target = event.cyTarget;

			cy.$('.protein_of_intrest').on('qtip', function(event){
				cy.$('.protein_of_intrest').qtip({
					content: function(){ 
						return 'Protein Name: ' + this.data('protein_name')	
						},
					position: {
						my: 'bottom center',
						at: 'top center'
					},
					style: {
						classes: 'qtip-bootstrap',
						tip: {
							width: 16,
							height: 8
						}
					}
				});
				
			});
			
			if( event.cyTarget === this && target.id() == 4){

				cy.$('.protein_of_intrest').trigger('qtip');
			}

		});


		

		cy.$('.domain').qtip({
			    show: {
		            solo: true,
			    },
				content: function(){ 
					
					return 'Protein Name: ' + this.data('protein_name')	+ '</br>' +
					'Domain Name: ' + this.data('domain_name')	
				},
				position: {
					my: 'top center',
					at: 'bottom center'
				},
				style: {
					classes: 'qtip-bootstrap',
					tip: {
						width: 16,
						height: 8
					}
				},

			});
	
		cy.$('.interacting_protein_node').qtip({

			content: function(){ 
				return 'Protein Name: ' + this.data('protein_name')	
			},
			position: {
				my: 'top center',
				at: 'bottom center'
			},
			style: {
				classes: 'qtip-bootstrap',
				tip: {
					width: 16,
					height: 8
				}
			},
		});
		
		cy.edges().qtip({
			content: function(){ 
				return 'Interaction: ' + this.data('interaction') + '<br/>' + 
				'Domain: ' + this.data('domain') + '<br/>' + 
				'Mode: ' + this.data('mode') + '<br/>' + 
				'Score: ' + this.data('score') 		
			},
			position: {
				my: 'top center',
				at: 'bottom center'
			},
			style: {
				classes: 'qtip-bootstrap',
				tip: {
					width: 16,
					height: 8
				}
			}
		});
		
	});
	
	$(".layout-select").on("click", function(){
		if ($(this).hasClass("active")) {
		}else {
			layout_type = $(this).html().toLowerCase();
		
			$(".layout-select").removeClass("active");
			$(this).addClass("active");
			cy.layout({ 
				name: layout_type,
				avoidOverlap: true,
				equidistant: true,
				minNodeSpacing: 50,
				
			}); 
		}
	});

});