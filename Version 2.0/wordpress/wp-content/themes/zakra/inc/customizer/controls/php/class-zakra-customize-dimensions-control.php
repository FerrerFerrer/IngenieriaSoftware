<?php
/**
 * Customize Dimensions control class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Dimensions_Control
 */
class Zakra_Customize_Dimensions_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-dimensions';

	/**
	 * Zakra_Customize_Dimensions_Control constructor.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      An specific ID of the section.
	 * @param array                $args    Section arguments.
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {

		parent::__construct( $manager, $id, $args );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'localize_script' ) );

	}

	/**
	 * Localize google fonts to controls.js file.
	 *
	 * @access public
	 */
	public function localize_script() {

		wp_localize_script( 'zakra-controls', 'dimensionszakraL10n', $this->l10n() );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see    WP_Customize_Control::to_json()
	 * @access public
	 * @return void
	 */
	public function to_json() {

		parent::to_json();

		$this->json['l10n'] = $this->l10n();

		if ( is_array( $this->json['default'] ) ) {
			foreach ( $this->json['default'] as $key => $value ) {
				$this->json['choices']['controls'][ $key ] = true;
			}
		}

		if ( is_array( $this->json['default'] ) ) {
			foreach ( $this->json['default'] as $key => $value ) {
				if ( isset( $this->json['choices'][ $key ] ) && ! isset( $this->json['value'][ $key ] ) ) {
					$this->json['value'][ $key ] = $value;
				}
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

		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><#
			} #>
			<div class="wrapper">
				<div class="control">
					<# for ( choiceKey in data.default ) { #>
					<div class="{{ choiceKey }}">
						<h5>
							<# if ( ! _.isUndefined( data.choices.labels ) && ! _.isUndefined( data.choices.labels[
							choiceKey ] ) ) { #>
							{{ data.choices.labels[ choiceKey ] }}
							<# } else if ( ! _.isUndefined( data.l10n[ choiceKey ] ) ) { #>
							{{ data.l10n[ choiceKey ] }}
							<# } else { #>
							{{ choiceKey }}
							<# } #>
						</h5>
						<div class="{{ choiceKey }} input-wrapper">
							<# var val = ( ! _.isUndefined( data.value ) && ! _.isUndefined( data.value[ choiceKey ] ) )
							? data.value[ choiceKey ].replace( '%%', '%' ) : ''; #>
							<input {{{ data.inputAttrs }}} type="text" data-choice="{{ choiceKey }}" value="{{ val }}"/>
						</div>
					</div>
					<# } #>
				</div>
			</div>
		</label>

		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @return array
	 */
	protected function l10n() {
		return array(
			'top'    => esc_attr__( 'Top', 'zakra' ),
			'right'  => esc_attr__( 'Right', 'zakra' ),
			'bottom' => esc_attr__( 'Bottom', 'zakra' ),
			'left'   => esc_attr__( 'Left', 'zakra' ),
		);
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
