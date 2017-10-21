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

	var $body = jQuery('body').addClass('slideout-menu-hidden');

	var $trigger = jQuery('#slideout-trigger');

	var $menu = jQuery('#slideout-menu');
	var $collapse = $menu.find('.slideout-collapse');
	var $content = $menu.find('.slideout-content');

	var updateSlideoutHeight = function() {
		$collapse.css('height', $content.outerHeight());
	};

	// Toggle the menu by adding a body class, adjust a max-height value for proper transitions
	$trigger.on('click', function(event){
    	event.preventDefault();

		updateSlideoutHeight();

	    $body
		    .toggleClass('slideout-menu-visible')
		    .toggleClass('slideout-menu-hidden');
    });
	
	/*SLIDE OUT MENU DROPDOWN*/
	var $submenus = $content.find('ul ul');
	var $item_with_children = $content.find('.menu-item-has-children');

	$submenus.css('display', 'none');

    if ($item_with_children.length > 0) {
	    $item_with_children.click(function () {
	    	var $this = jQuery(this);

		    $this.toggleClass('toggled');
		    if ( $this.hasClass('toggled') ) {
			    $this.children('ul').slideToggle();
		    }

		    updateSlideoutHeight();

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

// Gallery flexible fields lightbox
jQuery(function($) {
	$('.swipebox').swipebox({
		loopAtEnd: true,
		afterMedia: function(e) {
			var $slider = jQuery('#swipebox-slider');
			var page_url = [location.protocol, '//', location.host, location.pathname].join('');

			$slider.find('.slide').each(function() {
				// Don't create a link multiple times.
				if ( jQuery(this).data('linked') ) return false;

				var $img = jQuery(this).find('img');

				var pinit_url = "http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}"
									.replace('{{url}}', page_url)
									.replace('{{image_url}}', $img.attr('src'))
									.replace('{{text}}', $img.attr('alt'));

				var $a = jQuery('<a>').attr({ href: pinit_url, title: 'Pin It', target: '_blank', rel: 'external', class: "image-overlay-label"});

				$img.wrap($a).after(jQuery('<span class="overlay">Pin it</span>'));

				// Remember that we created a link for this slide.
				jQuery(this).data('linked', 1);
			});
		}
	});
});

// Allow sidebar to be toggled on mobile
jQuery(function($) {
	var $sidebar = jQuery('#sidebar');
	if ( $sidebar.length < 1 ) return;

	var $toggle_button = jQuery('.mobile-sidebar-button');

	$toggle_button.find('a').on('click', function() {

		$toggle_button.toggleClass('msb-active');
		$sidebar.toggleClass('msb-active');

		return false;

	});
});

// Reorganize the structure of the Contact Us Gravity Form
jQuery(function($) {
	var $form = jQuery('#gform_3');
	if ( $form.length < 1 ) return;

	// Quick fix: Make the label for the checkbox to add to mailing list have a clickable label.
	jQuery('#field_3_6').find('label.gfield_label').attr('for', 'choice_3_6_1');

	// The body element contains all of the fields.
	var $body = $form.find('.gform_body');
	var $field_ul = $body.find('ul.gform_fields');

	// Detach the field_ul so it does not compete over IDs
	$field_ul.detach();

	// Prepare fields. They should be <div> elements for our purposes.
	var $li_fields = $field_ul.find('li.gfield');
	var $div_fields = jQuery('<div>');

	$li_fields.each(function() {
		var $li = jQuery(this);

		$li.detach();

		$div_fields.append(
			jQuery('<div>', { id: $li.attr('id'), class: $li.attr('class') })
				.append( $li.children() )
		);
	});

	// Add our currently unattached div_fields to a new grid layout
	var $grid = jQuery('<div>', { class: 'gf_contact grid grid-2-cols' });

	// Copy data from the fields <ul> to the new column grid <div>
	$grid.addClass( $field_ul.attr('class') ).attr('id', $field_ul.attr('id') );

	// Clear the old fields out of the body element.
	$li_fields.remove();
	$body.html('');

	// Make a two column layout and add fields to the left/right column as necessary.
	$grid.append(
		jQuery('<div>', { class: 'cell' }).append(
			$div_fields.find('.gfield').filter('#field_3_1, #field_3_2, #field_3_3, #field_3_4, #field_3_5')
		)
	).append(
		jQuery('<div>', { class: 'cell' }).append(
			$div_fields.find('.gfield').not('#field_3_1, #field_3_2, #field_3_3, #field_3_4, #field_3_5') // OTHER FIELDS, using a not() operation.
		)
	);

	// Add the new layout to the page
	$body.append( $grid );
});

// Wrap all checkboxes in a span so that we can style the checkbox
jQuery(function($) {
	jQuery('input:checkbox').wrap( jQuery('<label class="aa-cb"></label>') ).after( jQuery('<span class="aa-ind"></span>') );
	jQuery('input:radio').wrap( jQuery('<label class="aa-rd"></label>') ).after( jQuery('<span class="aa-ind"></span>') );
});

// Add class to indicate checkbox/radio status on parent elements for gravity forms
jQuery(function($) {
	jQuery('.gform_body')
		.on('change', '.gfield_checkbox input:checkbox', function() {
			jQuery(this).closest('li').toggleClass('checked', jQuery(this).prop('checked'));
		})
		.on('change', '.gfield_radio input:radio', function( e, internal ) {
			jQuery(this).closest('li').toggleClass('checked', jQuery(this).prop('checked'));

			// Uncheck other radios by triggering the change event
			// Note that this could trigger an infinite loop, so we pass an internal parameter that reads "do not recurse" so we know we're triggering this programmatically.
			if ( internal !== "do not recurse" ) {
				jQuery(this).closest('ul').find('input:radio').not(this).trigger('change', "do not recurse");
			}
		})
		.find('input:checkbox, input:radio').trigger('change');
});

// Add span tag to "We strongly recommend you purchase travel insurance..." field on register form
jQuery(function($) {
	jQuery('#field_4_54').find('.gfield_label').html(function() {
		var html = jQuery(this).html();

		html = html.replace( 'within 15 days of your first payment.', '<span class="no-italic">within 15 days of your first payment.</span>');

		return html;
	});
});

// Create a parallax effect for some areas
jQuery(function($) {
	var parallax = {
		item_index: 0,
		items: [],
		browser_top: false,
		browser_height: false,
		browser_bottom: false
	};

	var _item_template = {
		wrap: false,
		image: false,
		area_top: 0,
		area_height: 0,
		area_bottom: 0,
		area_width: 0,
		natural_width: 0,
		natural_height: 0,
		scaled: {
			width: 0,
			width_excess: 0,
			height: 0,
			height_excess: 0
		},
		target: {
			start: 0,
			end: 0
		},
		offset_top: 0,
		is_at_start: false,
		is_at_end: false
	};

	// Necessary after the window or any parallax elements have been resized.
	var recalculateAllSizes = function() {
		console.log( 'Recalculate all positions' );

		// Parallax system
		parallax.browser_top = jQuery(window).scrollTop();
		parallax.browser_height = jQuery(window).height();
		parallax.browser_bottom = parallax.browser_top + parallax.browser_height;

		// Items
		for ( var i in parallax.items ) {
			if ( !parallax.items.hasOwnProperty(i) ) continue;
			recalculateSingleItemSize(i);
		}
	};

	var recalculateSingleItemSize = function( index ) {
		console.log( 'Recalculate item size:', index );

		if ( typeof parallax.items[index] === 'undefined' ) {
			console.error( 'Invalid parallax item:', index );
			return;
		}

		var item = parallax.items[index];

		// Container details
		item.area_top = item.wrap.offset().top;
		item.area_height = item.wrap.height();
		item.area_bottom = item.area_top + item.area_height;
		item.area_width = item.wrap.width();

		// Image scaling details
		item.scaled.width = item.wrap.width(); // 500
		item.scaled.height = item.scaled.width * (item.natural_height / item.natural_width); // aspect ratio

		if ( item.scaled.height < (item.area_height * 1.3) ) {
			// Image height not tall enough, use height instead. Height must be at least 130% of the container.
			item.scaled.height = item.area_height * 1.3;
			item.scaled.width = item.scaled.height * (item.natural_width / item.natural_height); // aspect ratio
		}

		item.scaled.width_excess = item.scaled.width - item.area_width;
		item.scaled.height_excess = item.scaled.height - item.area_height;

		// Scroll targets
		item.target.start = item.area_top - parallax.browser_top; // When the image top is at browser bottom.
		item.target.end = item.area_top + item.area_height; // When the image bottom is at browser top.
	};

	// Necessary only when scrolling the page - when elements and the page size do not change.
	var recalculateAllPositions = function() {
		console.log( 'Recalculate scroll position' );

		// Parallax System
		parallax.browser_top = jQuery(window).scrollTop();
		parallax.browser_bottom = parallax.browser_top + parallax.browser_height;

		// Items
		for ( var i in parallax.items ) {
			if ( !parallax.items.hasOwnProperty(i) ) continue;
			recalculateSingleItemPosition(i);
		}

		console.log( parallax );
	};

	var recalculateSingleItemPosition = function( index ) {
		console.log( 'Recalculate item position:', index );

		if ( typeof parallax.items[index] === 'undefined' ) {
			console.error( 'Invalid parallax item:', index );
			return;
		}

		var item = parallax.items[index];

		if ( item.is_at_end && parallax.browser_top > item.target.end ) return;
		if ( item.is_at_start && parallax.browser_bottom < item.target.start ) return;

		var item_position_percentage = (parallax.browser_top - item.area_top) / (parallax.browser_top / item.area_bottom);

		item.offset_top = (item_position_percentage * (item.scaled.height_excess * 2)) - item.scaled.height_excess;

		if ( item_position_percentage < 0 ) {
			item.is_at_start = true;
			item.offset_top = item.scaled.height_excess;
		}

		if ( item_position_percentage > 1 ) {
			item.is_at_end = true;
			item.offset_top = -1 * item.scaled.height_excess;
		}

		updateSingleItem( index );
	};

	var updateSingleItem = function( index ) {
		console.log( 'Updating item in DOM:', index );

		if ( typeof parallax.items[index] === 'undefined' ) {
			console.error( 'Invalid parallax item:', index );
			return;
		}

		var item = parallax.items[index];

		// Update elements
		item.image.css({
			top: item.offset_top,
			width: item.scaled.width,
			height: item.scaled.height,
			'margin-left': -1 * item.scaled.width_excess
		});
	};

	// The scroll event and resize events are rate limited based on a framerate which is converted to a millisecond delay for use with timeouts.
	var rateLimitSpeed = 1000 / 30;

	// Scroll event
	// -> This triggers recalculateScrollPosition() when you start scrolling, and when you've stopped scrolling, and also at each ratelimit interval.
	var rateLimitScroll = false;
	var rateLimitScrollAttempted = false;
	jQuery(window).scroll(function() {
		// Block repeat events for rate limiting.
		if ( typeof rateLimitScroll === true ) {
			rateLimitScrollAttempted = true; // Will repeat the process after rate limit expires
			return;
		}
		
		rateLimitScroll = true;
		
		// Process the positions
		recalculateAllPositions();
		
		// Clear the ratelimit and optionally trigger again after a delay.
		setTimeout(function() {
			if ( rateLimitScrollAttempted ) recalculateAllPositions();
			rateLimitScrollAttempted = false;
			rateLimitScroll = false;
		}, rateLimitSpeed);
	});

	// Resize event
	// -> This triggers recalculateAllSizes() when you start resizing the browser, and when you've stopped resizing, and also at each ratelimit interval.
	var rateLimitResize = false;
	var rateLimitResizeAttempted = false;
	jQuery(window).resize(function() {
		// Block repeat events for rate limiting.
		if ( typeof rateLimitResize === true ) {
			rateLimitResizeAttempted = true; // Will repeat the process after rate limit expires
			return;
		}
		
		rateLimitResize = true;
		
		// Process the positions
		recalculateAllSizes();
		
		// Clear the ratelimit and optionally trigger again after a delay.
		setTimeout(function() {
			if ( rateLimitResizeAttempted ) recalculateAllSizes();
			rateLimitResizeAttempted = false;
			rateLimitResize = false;
		}, rateLimitSpeed);
	});

	// Set up the parallax object (without any items yet)
	recalculateAllSizes();
	recalculateAllPositions();

	// Initialize the parallax items
	jQuery('.ff-background.motion-parallax').each( function() {
		var $wrap = jQuery(this);
		var $image = $wrap.find('.ff-background-image');

		var new_item = _item_template;
		var new_item_index = parallax.item_index++;

		new_item.wrap = $wrap;
		new_item.image = $image;
		new_item.natural_width = parseInt( $image.attr('data-img-width') );
		new_item.natural_height = parseInt( $image.attr('data-img-height') );

		parallax.items[ new_item_index ] = new_item;

		recalculateSingleItemSize( new_item_index );
		recalculateSingleItemPosition( new_item_index );

		$wrap.removeClass('parallax-not-initialized').addClass('parallax-initialized');

		console.log( 'only doing 1!!!!');return false;
	} );

});