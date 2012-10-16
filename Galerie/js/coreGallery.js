function matchOrder(a, b) {
   return parseInt($(a).attr('order')) - parseInt($(b).attr('order'));
}

function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}

function initSlideShow() {

  // initialize the slideshow
  $('.image img').fullscreenslides();
  
  // All events are bound to this container element
  var $container = $('#fullscreenSlideshowContainer');
  
  $container
    //This is triggered once:
    .bind("init", function() { 

      // The slideshow does not provide its own UI, so add your own
      // check the fullscreenstyle.css for corresponding styles
      $container
        .append('<div class="ui" id="fs-close">&times;</div>')
        .append('<div class="ui" id="fs-loader">Chargement...</div>')
        .append('<div class="ui" id="fs-prev">&lt;</div>')
        .append('<div class="ui" id="fs-next">&gt;</div>')
        .append('<div class="ui" id="fs-caption"><span></span></div>');
      
      // Bind to the ui elements and trigger slideshow events
      $('#fs-prev').click(function(){
        // You can trigger the transition to the previous slide
        $container.trigger("prevSlide");
      });
      $('#fs-next').click(function(){
        // You can trigger the transition to the next slide
        $container.trigger("nextSlide");
      });
      $('#fs-close').click(function(){
        // You can close the slide show like this:
        $container.trigger("close");
      });
      
    })
    // When a slide starts to load this is called
    .bind("startLoading", function() { 
      // show spinner
      $('#fs-loader').show();
    })
    // When a slide stops to load this is called:
    .bind("stopLoading", function() { 
      // hide spinner
      $('#fs-loader').hide();
    })
    // When a slide is shown this is called.
    // The "loading" events are triggered only once per slide.
    // The "start" and "end" events are called every time.
    // Notice the "slide" argument:
    .bind("startOfSlide", function(event, slide) { 
      // set and show caption
      $('#fs-caption span').text(slide.title);
      $('#fs-caption').show();
    })
    // before a slide is hidden this is called:
    .bind("endOfSlide", function(event, slide) { 
      $('#fs-caption').hide();
    });

}

function initScreen(xml){

    var sorted = sortGalleryXml(xml);
    readGalleryImages(sorted);
    initSlideShow();
}
function initSort(xml){

    var sorted = sortGalleryXml(xml);
    readGalleryImages(sorted);
}

function sortGalleryXml(xml) {
	
	var sorted = $(xml).find('image').sort(matchOrder);
	
	return $(sorted);
}

function readGalleryImages(images){

    $(images).each(function(){
      if($(this).attr('display') == '1') {
        var sFilename = $(this).attr('filename');
        var sOrder = $(this).attr('order');
        var sCaption = $(this).find('caption').text();
        var sHtml = "<li class='image'><a rel='gallery' title='" + sCaption + "' href='" + sFilename + "'><img src='" + sFilename + "' /></a></li>"
        $("#container").append(sHtml);
      }
    });
	
}