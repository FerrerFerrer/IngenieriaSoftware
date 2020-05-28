<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dib' );

/** MySQL database username */
define( 'DB_USER', 'admin-suser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'NaNo2324!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~J&+3bRXEHA%wvU]McOA@Pd!3tN5i&s2gOe%XG@0D#<p2Vj1vRG>$_}K92w#:JGq' );
define( 'SECURE_AUTH_KEY',  'BlD`<V`dOl*|8g~,[LY?4F>?0P5, oN{:%It6.Baagm@zPd%B8#F)~67A$K|V^.y' );
define( 'LOGGED_IN_KEY',    '6~E?[ xc!BBT%[EO,_n@]aPe-@`&?HU:h$;B>V:G.TIG:x<@V5p&iPY;D83p,>N3' );
define( 'NONCE_KEY',        'Z};$`*Q;HSAqqm|*Nr(is7^eU&7nF5[|AzI(OAA74`1]{+#M-B:h]kF^ *J2U{SS' );
define( 'AUTH_SALT',        'Tb 4/0ohp=XsFRhiH3EpGV`hRO~e3W-yh1s;n/VSU2B?-C{nf6i>/8DMvq9:2$6k' );
define( 'SECURE_AUTH_SALT', '4hk:qhtR-Whl^WlPEC1Da3^2tt+URj(O#,s;(IL~MUo3,^fHeO/pOql;$:,.DW>Z' );
define( 'LOGGED_IN_SALT',   '=$n4|m,!0>z7,}$1jyN+V[54RTjOBW2uVUa]5t=a.H:vi5|m^}I1oi*6XOgb@LpX' );
define( 'NONCE_SALT',       'c SqDjS;8pkGM)^j}5!M]TJJ}V}|lO%uNk`Vgb8[g7`y]qi$Lg^/8yzc_0p8L|j>' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
