/**
 * 
 */

function showDatasetRequestForm(event){

	if(loggedIn == true){

		$("#data_request_logged_in").removeClass("hidden");
		$("#form_request_dataset").val($(event.target).attr('data'));
	    $("#form_request_file_format").val($(event.target).attr('format'));
		
	}else{

		$("#data_request_logged_out").removeClass("hidden");
		
	}

    $(".qtip").addClass("hidden");
    $("body").addClass("noscroll");
}

function hideDatasetRequestForm(event){
    $("#dataset_request").addClass("hidden");
    $("body").removeClass("noscroll");
}


particlesJS(
		"particles-js1", 
		{
			"particles":
			{
				"number":{"value":150,"density":{"enable":true,"value_area":1000}},
				"color":{"value":"#ffffff"},
				"shape":{"type":"circle","stroke":{"width":1,"color":"#ffffff"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},
				"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},
				"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},
				"line_linked":{"enable":true,"distance":80,"color":"#ffffff","opacity":0.4,"width":1},
				"move":{"enable":true,"speed":1,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}
			},
			"interactivity":
			{
				"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"push"},"resize":true},
				"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":74.27764985515863,"size":4,"duration":2,"opacity":10,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}
			},
			"retina_detect":true
		});

particlesJS(
		"particles-js2", 
		{
			"particles":
			{
				"number":{"value":80,"density":{"enable":true,"value_area":875}},
				"color":{"value":"#ffffff"},
				"shape":{"type":"circle","stroke":{"width":1,"color":"#ffffff"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},
				"opacity":{"value":1,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},
				"size":{"value":5,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},
				"line_linked":{"enable":true,"distance":120,"color":"#ffffff","opacity":0.8,"width":3},
				"move":{"enable":true,"speed":1,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}
			},
			"interactivity":
			{
				"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"push"},"resize":true},
				"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":74.27764985515863,"size":4,"duration":2,"opacity":10,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":3},"remove":{"particles_nb":2}}
			},
			"retina_detect":true
		});



particlesJS(
		"particles-js4", 
		{
			"particles":
			{
				"number":{"value":150,"density":{"enable":true,"value_area":1000}},
				"color":{"value":"#ffffff"},
				"shape":{"type":"circle","stroke":{"width":1,"color":"#ffffff"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},
				"opacity":{"value":0.5,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},
				"size":{"value":3,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},
				"line_linked":{"enable":true,"distance":80,"color":"#ffffff","opacity":0.4,"width":1},
				"move":{"enable":true,"speed":1,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}
			},
			"interactivity":
			{
				"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"push"},"resize":true},
				"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":74.27764985515863,"size":4,"duration":2,"opacity":10,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":3},"remove":{"particles_nb":2}}
			},
			"retina_detect":true
		});

particlesJS(
		"particles-js3", 
		{
			"particles":
			{
				"number":{"value":80,"density":{"enable":true,"value_area":875}},
				"color":{"value":"#ffffff"},
				"shape":{"type":"circle","stroke":{"width":1,"color":"#ffffff"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},
				"opacity":{"value":1,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},
				"size":{"value":5,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},
				"line_linked":{"enable":true,"distance":120,"color":"#ffffff","opacity":0.8,"width":3},
				"move":{"enable":true,"speed":1,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}
			},
			"interactivity":
			{
				"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"push"},"resize":true},
				"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":74.27764985515863,"size":4,"duration":2,"opacity":10,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}
			},
			"retina_detect":true
		});





