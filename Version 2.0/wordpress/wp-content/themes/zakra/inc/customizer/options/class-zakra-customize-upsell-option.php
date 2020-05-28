<?php
/**
 * Archive/ blog layout.
 *
 * @package     zakra
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*========================================== POST/PAGE/BLOG > ARCHIVE/ BLOG ==========================================*/
if ( ! class_exists( 'Zakra_Customize_Upsell_Option' ) ) :

    /**
     * Archive/Blog option.
     */
    class Zakra_Customize_Upsell_Option extends Zakra_Customize_Base_Option {

        /**
         * Arguments for options.
         *
         * @return array
         */
        public function elements() {

            return array(

                'zakra_upsell'        => array(
                    'setting' => array(),
                    'control' => array(
                        'type'     => 'upsell',
                        'priority' => 10,
                        'section'  => 'zakra_customize_upsell_section',
                    ),
                )


            );

        }

    }

    new Zakra_Customize_Upsell_Option();

endif;
