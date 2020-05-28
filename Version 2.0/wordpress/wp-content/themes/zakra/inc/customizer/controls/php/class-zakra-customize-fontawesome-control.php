<?php
/**
 * Customize Fontawesome control class.
 *
 * @package zakra
 *
 * @since   1.2.4
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Fontawesome_Control
 */
class Zakra_Customize_Fontawesome_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-fontawesome';

	/**
	 * Zakra_Customize_Typography_Control constructor.
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
	 * Enqueues scripts
	 */
	public function enqueue() {
		parent::enqueue();

		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome.min.css', false, '4.7.0' );
	}

	/**
	 * Localize google fonts to controls.js file.
	 *
	 * @access public
	 */
	public function localize_script() {

		// Get choices.
		$fontawesome_array = $this->choices;

		// Pass fontawesome array to controls.js file.
		wp_localize_script( 'zakra-controls', 'zakraFontAwesome' . $this->id, $fontawesome_array );

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

		$this->json['choices'] = $this->choices;

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
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>

		</label>
		<div class="zakra-fontawesome-wrapper">
			<select {{{ data.inputAttrs }}}  id="zakra-fontawesome-{{{ data.id }}}"></select>
		</div> <!-- /.zakra-fontawesome-wrapper -->
		<?php
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
