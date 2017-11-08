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
	var left_column_fields = '#field_3_1, #field_3_2, #field_3_4, #field_3_5';
	$grid.append(
		jQuery('<div>', { class: 'cell' }).append(
			$div_fields.find('.gfield').filter(left_column_fields)
		)
	).append(
		jQuery('<div>', { class: 'cell' }).append(
			$div_fields.find('.gfield').not(left_column_fields) // Right column uses not() operation to add all other fields.
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
	jQuery('#field_4_67').find('.gfield_label').html(function() {
		var html = jQuery(this).html();

		html = html.replace( 'within 15 days of your first payment.', '<span class="no-italic">within 15 days of your first payment.</span>');

		return html;
	});
});

// Create a parallax effect for some areas
jQuery(function($) {
	var parallax_items = jQuery('.ff-background.motion-parallax');
	if ( parallax_items.length < 1 ) return;

	// Initialize the parallax items
	var rellax = new Rellax( '.ff-background.motion-parallax .ff-background-image', {
		speed: 2,
		center: true,
		round: true
	});

	parallax_items.each( function() {
		jQuery(this).removeClass('parallax-not-initialized').addClass('parallax-initialized');
	} );
});

// Add the functionality to the registration form to choose program, dates, occupancy.
jQuery(function($) {
	if ( typeof aa_register_data === 'undefined' ) return;

	var ids = aa_register_data.ids;
	var r = aa_register_data.ids.registration_form;

	var $_program = jQuery('#input_'+r+'_'+ids.program);        // morocco
	var $_date = jQuery('#input_'+r+'_'+ids.date);              // morocco_march-4-13-2018
	var $_occupancy = jQuery('#input_'+r+'_'+ids.occupancy);    // morocco_march-4-13-2018_single
	var $_price = jQuery('#ginput_base_price_'+r+'_'+ids.price);// $7880
	var $_total = jQuery('#input_'+r+'_'+ids.total);            // $7880

	var $_date_options = $_date.find('option'); // Will be filtered
	var $_occupancy_options = $_occupancy.find('option'); // Will be filtered

	console.log($_date_options);

	var update_register_price = function( new_price ) {
		if ( new_price <= 0 ) {
			$_total.closest('.gfield_price').css('display', 'none');
			$_total.val('').trigger('change');
			$_price.val('').trigger('change');
		}else{
			$_total.closest('.gfield_price').css('display', '');
			$_total.siblings('.ginput_total').html( '$' + number_format(new_price, 2, '.', ',').toString().replace('.00','') );
			$_total.val(parseFloat(new_price)).trigger('change');
			$_price.val(parseFloat(new_price)).trigger('change');
		}
	};

	$_program.on('change', function(e) {
		var program_value = jQuery(this).val(); // eg: amalfi
		var date_value = $_date.val(); // eg: morocco

		console.log( 'date bef: ', date_value );

		$_date_options

			// Detach all options from this select, re-attach only those that belong to the selected program.
			.detach()

			// Loop through each option
			.each(function() {
				var opt_value = jQuery(this).val(); // eg:  morocco_march-4-13-2018

				// Determine if this option should appear in the dropdown. It must belong to the selected program.
				var show_option = false;
				if ( opt_value === "" ) show_option = true; // Always show the empty option so we can leave it blank.
				if ( program_value && program_value && (opt_value.indexOf(program_value) === 0) ) show_option = true; // If this date belongs to the program, show it.

				if ( show_option ) {
					// List the option within the dropdown.
					$_date.append(this);

					// Re-set the select value because the option was detached.
					if ( date_value === opt_value ) date_value = opt_value;
				}else{
					// Don't include this date. If it was selected, clear the select
					if ( $_date.val() === opt_value ) date_value = '';
				}
			});

		console.log( 'date aft: ', date_value );

		$_date
			// .val(date_value)
			.trigger('change'); // Update the select

	});

	$_date.on('change', function(e) {
		var date_value = jQuery(this).val(); // eg: morocco_march-4-13-2018

		// Hide dates that aren't used by this option.
		$_occupancy
			.find('option')
				.each(function() {
					var opt_value = jQuery(this).val(); // eg:  morocco_march-4-13-2018_single

					if ( date_value && (opt_value.indexOf(date_value) === 0) ) {
						// This date should be visible
						jQuery(this).css('display', 'block');
					}else{
						// Hide this date, clear it if it was selected
						jQuery(this).css('display', 'none');
						if ( $_occupancy.val() === opt_value ) $_occupancy.val('');
					}
				})
			.end()
			.trigger('change'); // Update the select
	});

	$_occupancy.on('change', function(e) {
		var occupancy_value = jQuery(this).val(); // eg: morocco_march-4-13-2018_single

		if ( !occupancy_value) {
			update_register_price(0);
			return;
		}

		// Find the price within the register  data variable, from destinations.php
		for ( var a in aa_register_data.destinations ) {
			if ( !aa_register_data.destinations.hasOwnProperty(a) ) continue;

			// a might be:
			// amalfi
			// seville

			// Occupancy value must start with "a"
			if ( occupancy_value.indexOf(a) < 0 ) continue;

			for ( var b in aa_register_data.destinations[a].programs ) {
				if ( !aa_register_data.destinations[a].programs.hasOwnProperty(b) ) continue;

				// b might be:
				// amalfi_june-9-16-2018
				// seville_april-28-may-5-2018

				// Occupancy value must start with "b"
				if ( occupancy_value.indexOf(b) < 0 ) continue;

				for ( var c in aa_register_data.destinations[a].programs[b].options ) {
					if ( !aa_register_data.destinations[a].programs[b].options.hasOwnProperty(c) ) continue;

					// c might be:
					// amalfi_june-9-16-2018_single
					// seville_april-28-may-5-2018_double

					// Occupancy value should be an exact match
					if ( occupancy_value === c ) {
						update_register_price( aa_register_data.destinations[a].programs[b].options[c].price );
						return;
					}

				}
			}
		}

		// Occupancy was not found, clear price.
		update_register_price(0);
	});

	// Initialize field selection
	$_program.trigger('change');

});


// Function to format numbers
// https://stackoverflow.com/a/2901136/470480
function number_format(number, decimals, dec_point, thousands_sep) {
	// http://kevin.vanzonneveld.net
	// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +     bugfix by: Michael White (http://getsprink.com)
	// +     bugfix by: Benjamin Lupton
	// +     bugfix by: Allan Jensen (http://www.winternet.no)
	// +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +     bugfix by: Howard Yeend
	// +    revised by: Luke Smith (http://lucassmith.name)
	// +     bugfix by: Diogo Resende
	// +     bugfix by: Rival
	// +      input by: Kheang Hok Chin (http://www.distantia.ca/)
	// +   improved by: davook
	// +   improved by: Brett Zamir (http://brett-zamir.me)
	// +      input by: Jay Klehr
	// +   improved by: Brett Zamir (http://brett-zamir.me)
	// +      input by: Amir Habibi (http://www.residence-mixte.com/)
	// +     bugfix by: Brett Zamir (http://brett-zamir.me)
	// +   improved by: Theriault
	// +   improved by: Drew Noakes
	// *     example 1: number_format(1234.56);
	// *     returns 1: '1,235'
	// *     example 2: number_format(1234.56, 2, ',', ' ');
	// *     returns 2: '1 234,56'
	// *     example 3: number_format(1234.5678, 2, '.', '');
	// *     returns 3: '1234.57'
	// *     example 4: number_format(67, 2, ',', '.');
	// *     returns 4: '67,00'
	// *     example 5: number_format(1000);
	// *     returns 5: '1,000'
	// *     example 6: number_format(67.311, 2);
	// *     returns 6: '67.31'
	// *     example 7: number_format(1000.55, 1);
	// *     returns 7: '1,000.6'
	// *     example 8: number_format(67000, 5, ',', '.');
	// *     returns 8: '67.000,00000'
	// *     example 9: number_format(0.9, 0);
	// *     returns 9: '1'
	// *    example 10: number_format('1.20', 2);
	// *    returns 10: '1.20'
	// *    example 11: number_format('1.20', 4);
	// *    returns 11: '1.2000'
	// *    example 12: number_format('1.2000', 3);
	// *    returns 12: '1.200'
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		toFixedFix = function (n, prec) {
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			var k = Math.pow(10, prec);
			return Math.round(n * k) / k;
		},
		s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}