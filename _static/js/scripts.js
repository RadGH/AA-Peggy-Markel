/*  -------------------------------------------------------
	Javascript helper document insert any simple JS functions here.
------------------------------------------------------- */





/*  -------------------------------------------------------------
		DEFAULT JS FUNCTIONS BELOW THIS LINE
------------------------------------------------------------- */
/*SLIDE OUT MENU*/	
jQuery(function($) {
		// Slideout Menu
	"use strict";
    $('#slideout-trigger').on('click', function(event){
    	event.preventDefault();
    	// create menu variables
    	var slideoutMenu = $('#slideout-menu');
    	var slideoutMenuWidth = $('#slideout-menu').outerWidth();

    	// toggle open class
    	slideoutMenu.toggleClass("open");

    	// slide menu
    	if (slideoutMenu.hasClass("open")) {
	    	slideoutMenu.animate({
		    	right: "0px"
	    	});
    	} else {
	    	slideoutMenu.animate({
		    	right: -slideoutMenuWidth
	    	}, 250);
    	}
    });

		$('#nav-close').on('click', function(event){
			event.preventDefault();
			// create menu variables
    	var slideoutMenu = $('#slideout-menu');
    	var slideoutMenuWidth = $('#slideout-menu').outerWidth();

    	// toggle open class
    	slideoutMenu.toggleClass("open");

    	// slide menu
    	if (slideoutMenu.hasClass("open")) {
	    	slideoutMenu.animate({
		    	right: "0px"
	    	});
    	} else {
	    	slideoutMenu.animate({
		    	right: -slideoutMenuWidth
	    	}, 250);
    	}
    });
	
	/*SLIDE OUT MENU DROPDOWN*/	
    $('#slideout-menu ul ul').hide();
    if ($('#slideout-menu .menu-item-has-children').length > 0) {
        $('#slideout-menu .menu-item-has-children').click(

        function () {
            $(this).addClass('toggled');
            if ($(this).hasClass('toggled')) {
                $(this).children('ul').slideToggle();
            }
            //return false;

        });
    }
});
  
//Scrolling Anchor Link
jQuery(function($) {
	"use strict";
		$('a[href*=#]:not([href=#])').click(function() {
		
    if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
           if (target.length) {
             $('html,body').animate({
                 scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
});
});