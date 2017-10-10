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