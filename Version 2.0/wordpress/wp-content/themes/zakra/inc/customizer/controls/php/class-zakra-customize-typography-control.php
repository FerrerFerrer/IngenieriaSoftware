<?php
/**
 * Customize Typography control class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Typography_Control
 */
class Zakra_Customize_Typography_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-typography';

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
	}

	/**
	 * Localize google fonts to controls.js file.
	 *
	 * @access public
	 */
	public function localize_script() {

		$custom_fonts_array = ( isset( $this->choices['fonts'] ) && ( isset( $this->choices['fonts']['standard'] ) || isset( $this->choices['fonts']['google'] ) ) && ( ! empty( $this->choices['fonts']['standard'] ) || ! empty( $this->choices['fonts']['google'] ) )
		); // check if at lease one of standard or google array for font is set and not empty.

		$localize_script_var = ( $custom_fonts_array ) ? 'zakraFonts' . $this->id : 'zakraAllFonts';

		wp_localize_script(
			'zakra-controls', $localize_script_var, array(
				'standard' => $this->get_standard_fonts(),
				'google'   => $this->get_google_fonts(),
			)
		);

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

		if ( is_array( $this->json['value'] ) ) {
			foreach ( array_keys( $this->json['value'] ) as $key ) {
				if ( ! in_array( $key, array( 'variant' ), true ) && ! isset( $this->json['default'][ $key ] ) ) {
					unset( $this->json['value'][ $key ] );
				}

				if ( isset( $this->json['default'][ $key ] ) && false === $this->json['default'][ $key ] ) {
					unset( $this->json['value'][ $key ] );
				}
			}
		}

		$this->json['languages'] = Zakra_Fonts::get_google_font_subsets();

		$this->json['choices'] = array();
		if ( ! array_key_exists( 'fonts', $this->choices ) ) {
			$this->json['choices'] = array(
				'fonts' => array(
					'google'   => array(),
					'standard' => array(),
				),
			);
		} else {
			$this->json['choices'] = $this->choices;
		}

		$this->json['languages'] = Zakra_Fonts::get_google_font_subsets();

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

		<div class="zakra-customizer-title-wrapper toggle-title">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<div class="zakra-toggle-button">
				<a href="#">
					<span class="dashicons dashicons-edit"></span>
				</a>
			</div> <!-- /.zakra-toggle-button -->
		</div>


		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="zakra-group-fields zakra-typography-wrapper toggle-content">
			<# if ( data.default['font-family'] ) { #>
			<# data.value['font-family'] = data.value['font-family'] || data['default']['font-family']; #>

			<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
			<div class="zakra-single-field font-family">
				<h5 class="zakra-field-title"><?php esc_html_e( 'Font family', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<select {{{ data.inputAttrs }}} id="zakra-typography-font-family-{{{ data.id }}}"></select>
				</div>
			</div>

			<# if ( false !== data.default.variant ) { #>
			<div class="zakra-single-field variant">
				<h5 class="zakra-field-title"><?php esc_attr_e( 'Variant', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<select {{{ data.inputAttrs }}} id="zakra-typography-variant-{{{ data.id }}}"></select>
				</div>
			</div>
			<# } #>

			<div class="zakra-single-field subsets">
				<h5 class="zakra-field-title"><?php esc_attr_e( 'Subset(s)', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<select {{{ data.inputAttrs }}} id="zakra-typography-subsets-{{{ data.id }}}"
					<# if ( _.isUndefined( data.choices['disable-multiple-variants'] ) || false === data.choices['disable-multiple-variants'] ) { #> multiple<# } #>>
					<# _.each( data.value.subsets, function( subset ) { #>
					<option value="{{ subset }}" selected="selected">{{ data.languages[ subset ] }}</option>
					<# } ); #>
					</select>
				</div>
			</div>
			<# } #> <!-- END data.default['font-family'] -->

			<# if ( data.default['font-size'] ) { #>
			<# data.value['font-size'] = data.value['font-size'] || data['default']['font-size']; #>
			<div class="zakra-single-field font-size">
				<h5 class="zakra-field-title"><?php esc_html_e( 'Font size', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['font-size'] }}"/>
				</div>
			</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['color'] ) && false !== data.default['color'] ) { #>
			<# data.value['color'] = data.value['color'] || data['default']['color']; #>
			<div class="zakra-single-field color">
				<h5 class="zakra-field-title"><?php esc_attr_e( 'Color', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<input {{{ data.inputAttrs }}} type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="zakra-color-control"/>
				</div>
			</div>
			<# } #>

			<# if ( data.default['line-height'] ) { #>
			<# data.value['line-height'] = data.value['line-height'] || data['default']['line-height']; #>
			<div class="zakra-single-field line-height">
				<h5 class="zakra-field-title"><?php esc_attr_e( 'Line Height', 'zakra' ); ?></h5>
				<div class="zakra-field-content">
					<input {{{ data.inputAttrs }}} type="number" value="{{ data.value['line-height'] }}"/>
				</div>
			</div>
			<# } #>

		</div> <!-- /.zakra-typography-wrapper -->

		<input class="typography-hidden-value" type="hidden" {{{ data.link }}}>

		<?php
	}

	/**
	 * Formats variants.
	 *
	 * @access protected
	 *
	 * @param array $variants The variants.
	 *
	 * @return array
	 */
	protected function format_variants_array( $variants ) {

		$all_variants   = Zakra_Fonts::get_all_variants();
		$final_variants = array();
		foreach ( $variants as $variant ) {
			if ( is_string( $variant ) ) {
				$final_variants[] = array(
					'id'    => $variant,
					'label' => isset( $all_variants[ $variant ] ) ? $all_variants[ $variant ] : $variant,
				);
			} elseif ( is_array( $variant ) && isset( $variant['id'] ) && isset( $variant['label'] ) ) {
				$final_variants[] = $variant;
			}
		}

		return $final_variants;

	}

	/**
	 * Gets standard fonts properly formatted for control.
	 *
	 * @access protected
	 * @return array
	 */
	protected function get_standard_fonts() {

		$standard_fonts = Zakra_Fonts::get_standard_fonts();

		$std_user_keys = array();
		if ( isset( $this->choices['fonts'] ) && isset( $this->choices['fonts']['standard'] ) ) {
			$std_user_keys = $this->choices['fonts']['standard'];
		}

		$standard_fonts_final = array();
		$default_variants     = $this->format_variants_array(
			array(
				'400',
				'italic',
				'500',
				'500italic',
				'700italic',
			)
		);
		foreach ( $standard_fonts as $key => $font ) {
			if ( ( ! empty( $std_user_keys ) && ! in_array( $key, $std_user_keys, true ) ) || ! isset( $font['stack'] ) || ! isset( $font['label'] ) ) {
				continue;
			}
			$standard_fonts_final[] = array(
				'family'      => $font['stack'],
				'label'       => $font['label'],
				'subsets'     => array(),
				'is_standard' => true,
				'variants'    => ( isset( $font['variants'] ) ) ? $this->format_variants_array( $font['variants'] ) : $default_variants,
			);
		}

		return $standard_fonts_final;

	}

	/**
	 * Gets google fonts properly formatted for control.
	 *
	 * @access protected
	 * @return array
	 */
	protected function get_google_fonts() {

		// Get formatted array of google fonts.
		$google_fonts = Zakra_Fonts::get_google_fonts();
		$all_variants = Zakra_Fonts::get_all_variants();
		$all_subsets  = Zakra_Fonts::get_google_font_subsets();

		$gf_user_keys = array();

		// Check if custom google fonts passed.
		if ( isset( $this->choices['fonts'] ) && isset( $this->choices['fonts']['google'] ) ) {
			$gf_user_keys = $this->choices['fonts']['google'];
		}

		// Ready final array for google fonts.
		$google_fonts_final = array();

		foreach ( $google_fonts as $family => $args ) {
			if ( ! empty( $gf_user_keys ) && ! in_array( $family, $gf_user_keys, true ) ) {
				continue;
			}

			// Get label, variants, subsets of individual font.
			$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
			$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( '400', '700' );
			$subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array();

			$available_variants = array();
			if ( is_array( $variants ) ) {
				foreach ( $variants as $variant ) {
					if ( array_key_exists( $variant, $all_variants ) ) {
						$available_variants[] = array(
							'id'    => $variant,
							'label' => $all_variants[ $variant ],
						);
					}
				}
			}

			$available_subsets = array();
			if ( is_array( $subsets ) ) {
				foreach ( $subsets as $subset ) {
					if ( array_key_exists( $subset, $all_subsets ) ) {
						$available_subsets[] = array(
							'id'    => $subset,
							'label' => $all_subsets[ $subset ],
						);
					}
				}
			}

			$google_fonts_final[] = array(
				'family'   => $family,
				'label'    => $label,
				'variants' => $available_variants,
				'subsets'  => $available_subsets,
			);

		}

		return $google_fonts_final;

	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
