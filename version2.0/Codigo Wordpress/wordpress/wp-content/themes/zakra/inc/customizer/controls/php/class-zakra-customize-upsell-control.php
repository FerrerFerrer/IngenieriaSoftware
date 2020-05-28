<?php
/**
 * Customize Upsellcontrol class.
 *
 * @package zakra
 *
 * @see     WP_Customize_Control
 * @access  public
 */

/**
 * Class Zakra_Customize_Upsell_Control
 */
class Zakra_Customize_Upsell_Control extends Zakra_Customize_Base_Control {

    /**
     * Customize control type.
     *
     * @access public
     * @var    string
     */
    public $type = 'zakra-upsell';

    /**
     * Zakra_Customize_Upsell_Control constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      An specific ID of the section.
     * @param array                $args    Section arguments.
     */
    public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {

        parent::__construct( $manager, $id, $args );

    }

    /**
     * Enqueues scripts
     */
    public function enqueue() {
        parent::enqueue();
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

        <div class="zakra-upsell-wrapper">
            <ul class="upsell-features">
                <h3 class="upsell-heading"><?php esc_html_e( 'More Awesome Features', 'zakra' ); ?></h3>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( 'Advanced Header Options', 'zakra' ); ?>
                </li>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( 'Flexible Menu Designs', 'zakra' ); ?>
                </li>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( 'Grid, Masonry, Thumbnail Blog', 'zakra' ); ?>
                </li>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( '10+ Footer Layouts', 'zakra' ); ?>
                </li>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( '100+ Customizer Options', 'zakra' ); ?>
                </li>
                <li class="upsell-feature"><span
                            class="dashicons dashicons-yes"></span><?php esc_html_e( '30+ Page Settings', 'zakra' ); ?>
                </li>
            </ul>

            <div class="launch-offer">
		        <?php
		        printf(
		            /* translators: %1$s discount coupon code., %2$s discount percentage */
			        esc_html__( 'Use the coupon code %1$s to get %2$s discount (limited time offer). Enjoy!', 'zakra' ),
			        '<span class="coupon-code">save10</span>',
			        '10%'
		        );
		        ?>
            </div>
        </div> <!-- /.zakra-upsell-wrapper -->

        <a class="upsell-cta" target="_blank"
           href="<?php echo esc_url( 'https://zakratheme.com/pricing/?utm_source=zakra-customizer&utm_medium=view-pro-link&utm_campaign=zakra-pricing' ); ?>"><?php esc_html_e( 'View Pricing', 'zakra' ); ?></a>

		<?php
	}

    /**
     * Render content is still called, so be sure to override it with an empty function in your subclass as well.
     */
    protected function render_content() {

    }

}
