<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'altum' );

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
define( 'AUTH_KEY',         'jUGnVl[wRB46*]&q4CACDq4|x|+qC!40_DP9_N2VE^HZ.hlC~],<%^@,w5r$8RvK' );
define( 'SECURE_AUTH_KEY',  '}-[HKV.`-&)-@wqY+4<X5+1IcR$M>{C|-fVm?;G$<r>u_|@p^t4>Q&y?UOX]) _m' );
define( 'LOGGED_IN_KEY',    'IxnZy*v>@(X tt,+q3oBt0H!;7_n_x:5HJlv/E?zj|Z@%d4dw?el=wAJ };qdVP_' );
define( 'NONCE_KEY',        'lfQkE3$@_b$]:taqEfS7T;JngayxX{%4o<{{#f)nVD`F0ShMnAxNOoW%V8A5U$Rq' );
define( 'AUTH_SALT',        '&~N5 3xW _cWAO}S:cj!N18fY&8_yhqBzz`[>/cWARC]If(!VW~+vk|{)&J`F ]#' );
define( 'SECURE_AUTH_SALT', 'eA-xzHmeW-CXoiE]7<XGL?S(0?=/}8&=sl!bE!NLEgH!5p*}Sef[D_8_2iTExR,I' );
define( 'LOGGED_IN_SALT',   'L%BioQ; YrR3O}8G%C*iCo]8-!L>YHjq6zwCJRO!CH#)?XCC-w(;H`2:)_$ERrqh' );
define( 'NONCE_SALT',       '$R1YM<Qbpn(DW@R3c0]43Iw&a[/w6uaAGnHU#vw4o3LP$m#[qsmvsUM%XG:GU&ZO' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
