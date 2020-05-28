<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Zakra_Dashboard {
	private static $instance;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		$this->setup_hooks();
	}

	private function setup_hooks() {
		add_action( 'admin_menu', array( $this, 'create_menu' ) );
	}

	public function create_menu() {
		if ( ! is_child_theme() ) {
			$theme = wp_get_theme();
		} else {
			$theme = wp_get_theme()->parent();
		}

		/* translators: %s: Theme Name. */
		$theme_page_name = sprintf( esc_html__( '%s Options', 'zakra' ), $theme->Name );

		add_theme_page( $theme_page_name, $theme_page_name, 'edit_theme_options', 'zakra-options', array(
			$this,
			'option_page'
		) );
	}

	public function option_page() {
		$theme        = wp_get_theme();
		$support_link = ( zakra_is_zakra_pro_active() ) ? 'https://zakratheme.com/support-ticket/' : 'https://wordpress.org/support/theme/zakra/';
		?>
        <div class="wrap">
            <div class="zakra-header">
                <h1>
                    <?php
                    /* translators: %s: Theme version. */
                    echo sprintf( esc_html__( 'Zakra %s', 'zakra' ), ZAKRA_THEME_VERSION );
                    ?>
                </h1>
            </div> <!-- /.zakra-header -->

            <div class="welcome-panel">
                <div class="welcome-panel-content">
                    <h2>
                        <?php
                        /* translators: %s: Theme Name. */
                        echo sprintf( esc_html__( 'Welcome to %s!', 'zakra' ), $theme->Name );
                        ?>
                    </h2>

                    <p class="about-description"><?php esc_html_e( 'Important links to get you started with Zakra', 'zakra' ); ?></p>

                    <div class="welcome-panel-column-container">
                        <div class="welcome-panel-column">
                            <h3><?php esc_html_e( 'Get Started', 'zakra' ); ?></h3>
                            <a class="button button-primary button-hero"
                               href="<?php echo esc_url( 'https://docs.zakratheme.com/en/category/getting-started-1470csx/' ); ?>"
                               target="_blank"><?php esc_html_e( 'Learn Basics', 'zakra' ); ?>
                            </a>
                        </div>

                        <div class="welcome-panel-column">
                            <h3><?php esc_html_e( 'Next Steps', 'zakra' ); ?></h3>
                            <ul>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-media-text">' . esc_html__( 'Documentation', 'zakra' ) . '</a>', esc_url( 'https://docs.zakratheme.com/en/' ) ); ?></li>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-layout">' . esc_html__( 'Starter Demos', 'zakra' ) . '</a>', esc_url( 'https://zakratheme.com/demos/' ) ); ?></li>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-migrate">' . esc_html__( 'Premium Version', 'zakra' ) . '</a>', esc_url( 'https://zakratheme.com/pro/' ) ); ?></li>
                            </ul>
                        </div>

                        <div class="welcome-panel-column">
                            <h3><?php esc_html_e( 'Further Actions', 'zakra' ); ?></h3>
                            <ul>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-businesswoman">' . esc_html__( 'Got theme support question?', 'zakra' ) . '</a>', esc_url( $support_link ) ); ?></li>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-groups">' . esc_html__( 'Join Zakra Facebook Community', 'zakra' ) . '</a>', esc_url( 'https://www.facebook.com/groups/zakratheme/' ) ); ?></li>
                                <li><?php printf( '<a target="_blank" href="%s" class="welcome-icon dashicons-thumbs-up">' . esc_html__( 'Leave a review', 'zakra' ) . '</a>', esc_url( 'https://wordpress.org/support/theme/zakra/reviews/' ) ); ?></li>
                            </ul>
                        </div>
                    </div> <!-- /.welcome-panel-column-container -->
                </div> <!-- /.welcome-panel-content -->
            </div> <!-- /.welcome-panel -->
		<?php
	}
}

Zakra_Dashboard::instance();
