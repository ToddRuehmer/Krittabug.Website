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
define('DB_NAME', 'krittabug2018');

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
define('AUTH_KEY',         '%,JjIMD=|[3F>1~8MHM?Z1g*t*6 4(GsS5&<_(#j#s-.0>osC,j>^9plNdX;UL1,');
define('SECURE_AUTH_KEY',  'dK9y!Ya0=fT#~/N7a!(DRz5_/QT?(rv? j<A`?ytngE;XgZnNvPm-(Tx%^/su+%S');
define('LOGGED_IN_KEY',    'BzNYMar{?_D+J6yGlunPh>a@26-/.Ik]?StHjf}U7>rNU*B=_>VsOwRvv^NI^nI ');
define('NONCE_KEY',        'tY=>ib?R(^7KTvvmT_H5;OtwjKAdCE(X}`uFC%:R4=K$OrH;!_pff=l2w7tSOVF.');
define('AUTH_SALT',        'nuJyg,3g~$cpf0P46ig.zD3Sqo#n7K V):Ijd:wO#E$^H-?mff 8]`A`c4SsNcrQ');
define('SECURE_AUTH_SALT', 'bnL[x@4&A0Z1(L85Vf$mZJxe,ho?&wfZW0u+2*H7ZZwlDl9Q5Upu]PFGY6,I[G<N');
define('LOGGED_IN_SALT',   'L&?t<^L9JX`u{@iaQB9Zw1(<bBy25N>#YW:/o8w]UnHt61q~cstt<!,I1TGc QJQ');
define('NONCE_SALT',       'BYb{59CMR5~VK[YW&Kc;Gc=C3{Km!0qncR(~TX^D1-ROmO/?~_9B(WPlnD7 d`8[');

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
