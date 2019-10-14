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
define('DB_NAME', 'krittabug');

/** MySQL database username */
define('DB_USER', 'kritta');

/** MySQL database password */
define('DB_PASSWORD', 'kritta!092917');

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
define('AUTH_KEY',         '? =Tj#B@ZAAVioo]I8BLzc|D-$)dB<lmX*P]=zEM0o^i;BDH}m-3f3_R:p}VO@{%');
define('SECURE_AUTH_KEY',  '!a<7;jO!htDuP,}h[PxW7<!Z{Kj(z<v)5jqJDuc7h:92[LTP:v@N6%JSNPco*(y7');
define('LOGGED_IN_KEY',    'CRHSX6:M?#`uuR,n,uE>;2wL8g,#|EiydcHB{/Bzv`EaBGJ_iGLC~J{~<XKb|;.A');
define('NONCE_KEY',        'I%}w#vHPg^F_<xDHLx>wB(:U}Syll2m5(llm}M^M|+7NUxr}-Ebt{,>=2tee#V,s');
define('AUTH_SALT',        ']CP*?bl`qN4$9uO?HEmH%@#~!TUpBIT2}U,y]s3>HqwjxFil`Hi f 0lt1A6F%IA');
define('SECURE_AUTH_SALT', 'h/u >ak r@Dt-Q,m]Pz8k,@kY?{QL-qavW{?Itbcu*?K3?+HMsN5NDuH (+XvmR)');
define('LOGGED_IN_SALT',   '$B@~EL(hMae968=D&a}I}.gB_!HZ}c4VdL9ZA,}45YU0PbD$qjMnSbk4dX;/q#/q');
define('NONCE_SALT',       '3!BdcwJtSV?C<Hk4G q!]U9b& 2#Zl&MjpTa=}m3a);y8_en;D9w{pfHheINWqG@');

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
