<?php
/**
 * Customize Slider control class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Slider_Control
 */
class Zakra_Customize_Slider_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-slider';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see    WP_Customize_Control::to_json()
	 * @access public
	 * @return void
	 */
	public function to_json() {

		parent::to_json();

		if ( is_array( $this->json['default'] ) ) {
			foreach ( $this->json['default'] as $key => $value ) {
				$this->json['choices']['controls'][ $key ] = true;
			}
		}

	}

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		?>

		<# if ( data.label ) { #>
		<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="customize-control-content">
			<div class="zakra-slider">
				<div id="custom-handle" class="ui-slider-handle"></div>
			</div>
			<div class="zakra-slider-input">
				<input {{{ data.inputAttrs }}} type="number" class="slider-input" value="{{ data.value['slider'] }}"/>
				<input type="text" value="{{ data.default['suffix'] }}" hidden>
				<span class="suffix">{{ data.default['suffix'] }}</span>
				<span class="slider-reset dashicons dashicons-image-rotate"><span
							class="screen-reader-text"><?php esc_html_e( 'Reset', 'zakra' ); ?></span></span>
			</div>
		</div>

		<?php
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
