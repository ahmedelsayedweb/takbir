/* ==============================================
Functions
=============================================== */
//
//// Random video
//function randomVideo(){
//	//Videos IDs
//	//var videos = ["a4sS0SB5WKU", "BWx9uT7wLJg", "8cxAlOZOpG0", "8OS2cNXwLxA"];
//	var videos = ["asser_yassin", "ahmed_hatem", "aly_mazhar", "ramy_ashour"];
//	//Get a random number between 0 and number of videos
//	var randomNumber = Math.floor( Math.random() * videos.length );
//
//	//return 'https://www.youtube.com/embed/' + videos[randomNumber] + '?VQ=HD720&loop=1&' + 'playlist=' + videos[randomNumber] + '&autoplay=1&loop=1&rel=0&controls=0&showinfo=0';
//	return '/assets/videos/' +  videos[randomNumber] + '.mp4';
//}
//
//// Accordion
//var acc = document.getElementsByClassName("accordion");
//var i;
//for (i = 0; i < acc.length; i++) {
//	acc[i].onclick = function() {
//    	this.classList.toggle("active");
//    	var panel = this.nextElementSibling;
//	    if (panel.style.maxHeight){
//	    	panel.style.maxHeight = null;
//	    } else {
//	    	panel.style.maxHeight = panel.scrollHeight + "px";
//	    }
//  	}
//}
//
//// Go back
//function goBack() {
//    window.history.back()
//}

// Sound control
$("#sound-control").click( function (){
    $('#video').prop('muted', !$('#video').prop('muted'));
    $('#sound-control i').toggleClass( "mute" );
});

/* ==============================================
	Jquery
=============================================== */
$(document).ready(function(){
	//Header scroll effect
	var header = $('#main_nav');
	var vH = 150;
	$(window).scroll( function() {
	  if ($(window).scrollTop() > vH) {
	    header.addClass('fixed');
	    header.fadeIn(300);
	  } else {
	    header.removeClass('fixed');
	  }
	});

//	// home page video
//	if ( $('body').hasClass('home') ) {
//		//$('#embed_video').attr('src', randomVideo()) ;
//		$('#video').attr('src', randomVideo()) ;
//	}

	// Category carousel
	if ( $('body').hasClass('category') ) {
		var owl = $('.owl-carousel');
		owl.owlCarousel({
		    loop:true,
		    margin:0,
		    nav:false,
		    dots: true,
		    items: 3,
		lazyLoad:true,
		    responsive: false,
		    navText: ["",""],
		})
		
		$('.customNextBtn').click(function() {
		    owl.trigger('next.owl.carousel');
		})
		$('.customPrevBtn').click(function() {
		    owl.trigger('prev.owl.carousel');
		})
		// Initialize the Lightbox for any links with the 'fancybox' class
		$(".fancybox").fancybox();
	}

	
	// To Top
	// browser window scroll (in pixels) after which the "back to top" link is shown
	  var offset = 300,
	    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
	    offset_opacity = 1200,
	    //duration of the top scrolling animation (in ms)
	    scroll_top_duration = 700,
	    //grab the "back to top" link
	    $back_to_top = $('#toTop');

	  //hide or show the "back to top" link
	  $(window).scroll(function(){
	    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
	    if( $(this).scrollTop() > offset_opacity ) { 
	      $back_to_top.addClass('fade-out');
	    }
	  });

	  //smooth scroll to top
	  $back_to_top.on('click', function(event){
	    event.preventDefault();
	    $('body,html').animate({
	      scrollTop: 0 ,
	      }, scroll_top_duration
	    );
	  });

}); // Jquery
jQuery(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = jQuery(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion(jQuery('#accordion'), false);
});
jQuery(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = jQuery(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion(jQuery('#accordion2'), false);
});
jQuery(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = jQuery(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion(jQuery('#accordion1'), false);
});