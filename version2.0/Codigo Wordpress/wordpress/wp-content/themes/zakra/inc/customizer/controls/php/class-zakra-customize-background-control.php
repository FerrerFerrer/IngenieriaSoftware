<?php
/**
 * Customize Background control class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Background_Control
 */
class Zakra_Customize_Background_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-background';

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="background-wrapper">

			<# if ( 'background-color' in data.default ) { #>
				<!-- background-color -->
				<div class="background-color">
					<# if ( 'background-image' in data.default ) { #>
						<h4><?php esc_attr_e( 'Background Color', 'zakra' ); ?></h4>
					<# } #>
					<input type="text" data-default-color="{{ data.default['+ $color +'] }}" data-alpha="true"
							value="{{ data.value['background-color'] }}" class="zakra-color-control"/>
				</div>
			<# } #>

			<# if ( 'background-image' in data.default ) { #>
				<!-- background-image -->
				<div class="background-image">
					<# if ( 'background-color' in data.default ) { #>
						<h4><?php esc_attr_e( 'Background Image', 'zakra' ); ?></h4>
					<# } #>
					<div class="attachment-media-view background-image-upload">
						<# if ( data.value['background-image'] ) { #>
						<div class="thumbnail thumbnail-image"><img src="{{ data.value['background-image'] }}" alt=""/>
						</div>
						<# } else { #>
						<div class="placeholder"><?php esc_attr_e( 'No File Selected', 'zakra' ); ?></div>
						<# } #>
						<div class="actions">
							<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>"><?php esc_attr_e( 'Remove', 'zakra' ); ?></button>
							<button type="button"
									class="button background-image-upload-button"><?php esc_attr_e( 'Select File', 'zakra' ); ?></button>
						</div>
					</div>
				</div>
			<# } #>

			<!-- background-repeat -->
			<div class="background-repeat">
				<h4><?php esc_attr_e( 'Background Repeat', 'zakra' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="no-repeat"
					<# if ( 'no-repeat' === data.value['background-repeat'] ) { #> selected <# }
					#>><?php esc_attr_e( 'No Repeat', 'zakra' ); ?></option>
					<option value="repeat"
					<# if ( 'repeat' === data.value['background-repeat'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Repeat All', 'zakra' ); ?></option>
					<option value="repeat-x"
					<# if ( 'repeat-x' === data.value['background-repeat'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Repeat Horizontally', 'zakra' ); ?></option>
					<option value="repeat-y"
					<# if ( 'repeat-y' === data.value['background-repeat'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Repeat Vertically', 'zakra' ); ?></option>
				</select>
			</div>

			<!-- background-position -->
			<div class="background-position">
				<h4><?php esc_attr_e( 'Background Position', 'zakra' ); ?></h4>
				<select {{{ data.inputAttrs }}}>
					<option value="left top"
					<# if ( 'left top' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Left Top', 'zakra' ); ?></option>
					<option value="left center"
					<# if ( 'left center' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Left Center', 'zakra' ); ?></option>
					<option value="left bottom"
					<# if ( 'left bottom' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Left Bottom', 'zakra' ); ?></option>
					<option value="right top"
					<# if ( 'right top' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Right Top', 'zakra' ); ?></option>
					<option value="right center"
					<# if ( 'right center' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Right Center', 'zakra' ); ?></option>
					<option value="right bottom"
					<# if ( 'right bottom' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Right Bottom', 'zakra' ); ?></option>
					<option value="center top"
					<# if ( 'center top' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Center Top', 'zakra' ); ?></option>
					<option value="center center"
					<# if ( 'center center' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Center Center', 'zakra' ); ?></option>
					<option value="center bottom"
					<# if ( 'center bottom' === data.value['background-position'] ) { #> selected <# }
					#>><?php esc_attr_e( 'Center Bottom', 'zakra' ); ?></option>
				</select>
			</div>

			<!-- background-size -->
			<div class="background-size">
				<h4><?php esc_attr_e( 'Background Size', 'zakra' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="cover"
							name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}cover" <# if ( 'cover' === data.value['background-size'] ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( 'cover' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>"
							for="{{ data.id }}cover"><?php esc_attr_e( 'Cover', 'zakra' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="contain"
							name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}contain" <# if ( 'contain' === data.value['background-size'] ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( 'contain' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>"
							for="{{ data.id }}contain"><?php esc_attr_e( 'Contain', 'zakra' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="auto"
							name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}auto" <# if ( 'auto' === data.value['background-size'] ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( 'auto' === data.value['background-size'] ) { #>on <# } else { #>off<# } #>"
							for="{{ data.id }}auto"><?php esc_attr_e( 'Auto', 'zakra' ); ?></label>
					</input>
				</div>
			</div>

			<!-- background-attachment -->
			<div class="background-attachment">
				<h4><?php esc_attr_e( 'Background Attachment', 'zakra' ); ?></h4>
				<div class="buttonset">
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="scroll"
							name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}scroll" <# if ( 'scroll' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( 'scroll' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>"
							for="{{ data.id }}scroll"><?php esc_attr_e( 'Scroll', 'zakra' ); ?></label>
					</input>
					<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="fixed"
							name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}fixed" <# if ( 'fixed' === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( 'fixed' === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>"
							for="{{ data.id }}fixed"><?php esc_attr_e( 'Fixed', 'zakra' ); ?></label>
					</input>
				</div>
			</div>
			<input class="background-hidden-value" type="hidden" {{{ data.link }}}>
		</div>
		<?php
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
