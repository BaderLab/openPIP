$("#slideshow > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow > div:first')

    .next()
    .fadeIn(4000)
    .fadeOut(4000)
    .end()
    .appendTo('#slideshow');
},  8000);

