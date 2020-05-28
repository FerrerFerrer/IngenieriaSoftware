<?php
/**
 * Customize Sortable control class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Sortable_Control
 */
class Zakra_Customize_Sortable_Control extends Zakra_Customize_Base_Control {

	/**
	 * Customize control type.
	 *
	 * @access public
	 * @var    string
	 */
	public $type = 'zakra-sortable';

	/**
	 * Renders the Underscore template for this control.
	 *
	 * @see    WP_Customize_Control::print_template()
	 * @access protected
	 * @return void
	 */
	protected function content_template() {
		?>

		<label class='zakra-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<ul class="sortable">
				<# _.each( data.value, function( choiceID ) { #>
				<li {{{ data.inputAttrs }}} class='zakra-sortable-item' data-value='{{ choiceID }}'>
					<span class='dashicons dashicons-menu'></span>
					<span class="dashicons dashicons-visibility visibility"></span>
					{{{ data.choices[ choiceID ] }}}
				</li>
				<# }); #>
				<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
				<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
				<li {{{ data.inputAttrs }}} class='zakra-sortable-item invisible' data-value='{{ choiceID }}'>
					<span class='dashicons dashicons-menu'></span>
					<span class="dashicons dashicons-visibility visibility"></span>
					{{{ data.choices[ choiceID ] }}}
				</li>
				<# } #>
				<# }); #>
			</ul>
		</label>

		<?php
	}

	/**
	 * Render content is still called, so be sure to override it with an empty function in your subclass as well.
	 */
	protected function render_content() {

	}

}
