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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bd_vitale');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'I.A<SRz;,lbTB12KA@*mhzYn}A#KG_FC.NGC }CSB3eTj2h>4ojFR-LD:p={+W>?');
define('SECURE_AUTH_KEY',  '3Oj8K5Qh!nL{RO=iP5o|E=G8@}4_]o/~;VK1Esz@`TdUYSuVf3c;uAF`esy`>qFN');
define('LOGGED_IN_KEY',    '1+yW3%0|7T^-,mqrbK0F-6WFuq5T~b*vl{aK.QI_8FZ#:*!lC!!9f}>r3W7ttY|s');
define('NONCE_KEY',        'vxgHI`N{]{4}pO;f@4V|m0ntEI$yUsBhKmqTb^(JcIt#=r:k5k1=ELfcL.u(J{V&');
define('AUTH_SALT',        ',IM=Y]X:cO0k0f$PA5XLL~Ed s@P&a&jPt=.QQj Zc^L]*2u^eabbAp|0]3OnCC~');
define('SECURE_AUTH_SALT', 'VI}7m,-w,XUL<h)]-(u^ZfHWkJ%>eNH?Ify^jlNfH_}!B0daxeWg(eT!iXlU_Ta{');
define('LOGGED_IN_SALT',   'rLT==`cx2:$0oeJnU-G[1(c;.mB?ti4pwnclK-P*=T0pK6qAU~-wytw&,+rqY! `');
define('NONCE_SALT',       ',;399!s(9U$3 Upm3 |KyzXq2+W:IUX@X?/$~yPTnANU&b5;+kyDDt7~)Z:ebNF]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
