<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define( 'ITSEC_ENCRYPTION_KEY', 'YC9ie0dmVHg7akdnYjd3P1RyL1BENW9JICMyJD5kQW1deTA3R0VEYmR3e0pDY3hYaWc6Y1RTTz52JURZVCZ2Wg==' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'phoenix' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'iy$Nk%:NaJx$7qOMbwpTU2,ZQ^YgTw#O[>X_#UDK,,`=/DhP+=jw!fE@>#VrPhWJ' );
define( 'SECURE_AUTH_KEY',  'EN^Uqf2jw:=Mjk>j;lMK3eg|64$]gIh5FAfo(L0&Qgh,CYnH/g5$7jhYdgW=:7}^' );
define( 'LOGGED_IN_KEY',    'uaScR24j]T^aEj`.O3f-R s!!P@57a1K*LW~kiHS597 S{H57u<h2-!8R@V|;EaD' );
define( 'NONCE_KEY',        '?F_{m%JMq[7Y!Z71g(3XW=DdsVXpiXDEZq?T RdiZ%o2g?`M-rpyTHD7z=0R)66}' );
define( 'AUTH_SALT',        '^1f-k:L}|:>py9:P=tx3W.R!;)h,C5,,,K29( IQb>H/>RkXCWKjwEerqp5:3*xT' );
define( 'SECURE_AUTH_SALT', 'F>G[z;c~4P7.]<@c+@Y@urZZ$s$/KUuX+Q-[k@9({kBG}FyM~iN,E-Ixa+f3e.P&' );
define( 'LOGGED_IN_SALT',   'L:Oyo|HIWG+0a]K4ME^zFC^xz4]JNE8j;9MYISlb*jy4`m8GR*UoFqUF.L2O6_8X' );
define( 'NONCE_SALT',       'qMfk4zNa_QhKK5rd7wQAaSm*Jo,i?)9L7Oa(*~eh=dIC!^~X[z]6x:7J`(/@Z+/R' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
