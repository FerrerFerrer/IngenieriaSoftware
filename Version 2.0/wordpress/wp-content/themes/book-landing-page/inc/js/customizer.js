( function( api ) {

    // Extends our custom "example-1" section.
    api.sectionConstructor['pro-section'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );
jQuery(document).ready(function($) {
	/* Move widgets to their respective sections */

	if( true == book_landing_page_data.newsletter ){
		wp.customize.section( 'sidebar-widgets-bottom-widget' ).panel( 'book_landing_page_home_page_settings' )
		wp.customize.section( 'sidebar-widgets-bottom-widget' ).priority( '51' );
    }

      // Scroll to Home section starts
    $('body').on('click', '#sub-accordion-panel-book_landing_page_home_page_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    });
    
    function scrollToSection( section_id ){
    var preview_section_id = "banner_section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
        
        case 'book_landing_page_banner_settings':
        preview_section_id = "banner_section";
        break;

        case 'accordion-section-book_landing_page_features_settings':
        preview_section_id = "features_section";
        break;

        case 'accordion-section-book_landing_page_testimonial_settings':
        preview_section_id = "testimonial_section";
        break;

        case 'accordion-section-book_landing_page_review_settings':
        preview_section_id = "review_section";
        break;

        case 'accordion-section-book_landing_page_tabmenu_settings':
        preview_section_id = "tabmenu_section";
        break;

        case 'accordion-section-book_landing_page_about_settings':
        preview_section_id = "about_section";
        break;

        case 'accordion-section-book_landing_page_promotional_settings':
        preview_section_id = "promotional_section";
        break;
    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
	}

});