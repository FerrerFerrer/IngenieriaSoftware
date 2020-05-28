/**
 * Javascript file for Page Settings.
 *
 * @package Zakra
 */

jQuery(
	function ( $ ) {

		// Generate tabs.
		var metaBoxWrap = $( '#page-settings-tabs-wrapper' );
		metaBoxWrap.tabs();

		// Image Uploader.
		var frame,
		    addImgLink = metaBoxWrap.find( '.upload-custom-img' ),
		    delImgLink = metaBoxWrap.find( '.delete-custom-img' );

		addImgLink.on(
			'click',
			function ( event ) {

				event.preventDefault();

				self = $( this );

				if ( frame ) {
					frame.open();
					return;
				}

				frame = wp.media(
					{
						title   : 'Select or Upload Media',
						button  : {
							text: 'Use this image'
						},
						library : {
							type: ['image']
						},
						multiple: false
					}
				);

				frame.on(
					'select',
					function () {
						var imgContainer = self.parents( '.zakra-ui-field' ).find( '.tg-upload-img' ),
						    input        = self.parents( '.zakra-ui-field' ).find( '.tg-upload-input' ),
						    attachment   = frame.state().get( 'selection' ).first().toJSON(),
						    delLink      = self.siblings( '.delete-custom-img' ),
						    uploadLink   = self;

						imgContainer.append( '<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>' );

						input.val( attachment.id );

						// Hide upload link.
						uploadLink.addClass( 'hidden' );
						// Show remove link.
						delLink.removeClass( 'hidden' );
					}
				);

				frame.open();
			}
		);

		delImgLink.on(
			'click',
			function ( event ) {

				event.preventDefault();

				var imgContainer = $( this ).parents( '.zakra-ui-field' ).find( '.tg-upload-img' ),
				    input        = $( this ).parents( '.zakra-ui-field' ).find( '.tg-upload-input' ),
				    delLink      = $( this ),
				    uploadLink   = $( this ).siblings( '.upload-custom-img' );

				imgContainer.html( '' );

				// Show upload link.
				uploadLink.removeClass( 'hidden' );

				// Hide remove link.
				delLink.addClass( 'hidden' );

				input.val( '' );

			}
		);

		/**
		 * Color Picker.
		 */
		function initColorPicker( metabox ) {
			metabox.find( '.tg-color-picker' ).wpColorPicker();
		}

		$( '#page-settings-tabs-wrapper:has(.tg-color-picker)' ).each(
			function () {
				initColorPicker( $( this ) );
			}
		);

		/**
		 * Conditional toggle visibility.
		 */
		( function () {
			var optionsEnabler = $( '#zakra-menu-item-style input[type="radio"][name="zakra_primary_menu_item_style"]' );

			optionsEnabler.on(
				'click',
				function () {

					var $meta_val       = $( this ).val(),
					$customizer_val = $( this ).parents( '.options-group' ).data( 'customizer' );

					// If Button in meta or customizer.
					if ( 'button' === $meta_val || ( 'customizer' === $meta_val && 'button' === $customizer_val ) ) {
						$( this ).parents( '.options-group' ).siblings( '.show-default' ).fadeIn( 100 ).fadeOut( 100 );
						$( this ).parents( '.options-group' ).siblings( '.show-button' ).fadeOut( 100 ).fadeIn( 100 );
					} else if ( 'default' === $meta_val || ( 'customizer' === $meta_val && 'default' === $customizer_val ) ) { // If Default in meta or customizer.
						$( this ).parents( '.options-group' ).siblings( '.show-default' ).fadeOut( 100 ).fadeIn( 100 );
						$( this ).parents( '.options-group' ).siblings( '.show-button' ).fadeIn( 100 ).fadeOut( 100 );
					}

				}
			);

			$( '#zakra-menu-item-style input[type="radio"][name="zakra_primary_menu_item_style"]:checked' ).click();

		} )();

	}
);
