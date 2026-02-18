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
define( 'DB_NAME', 'choiceiptv35556_26' );

/** MySQL database username */
define( 'DB_USER', 'choiceiptv35556_26' );

/** MySQL database password */
define( 'DB_PASSWORD', 'S(p@V2U57V' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'zvc0fleihmqiwyjbg1ycxrruaknvyc0hwbvszsvpbsrnnwehuzjtdjvpv2wiuwkz' );
define( 'SECURE_AUTH_KEY',  'lukx5v5tnoztchttnxq4dw2jmymmmuoykvo4whpitf6zhai0n1ovi83d53mibmuk' );
define( 'LOGGED_IN_KEY',    '8zloiggasax4a9lfrisgjtwdasx6um4zeq8ev9tyf0flfj8zfmygzrznjypmiunn' );
define( 'NONCE_KEY',        'ecrg85swyzsbuaomhhs54hqqpzfizcb1dcvvklqjo49t2f8m2iaf2sjyud78mjn7' );
define( 'AUTH_SALT',        'xgj5uo8dyvc4gpoiakqvnxkvfzq7qnal0uzkzqxnsnra2tghhwcjoswyfsbjmrrt' );
define( 'SECURE_AUTH_SALT', '6eatc65qqplbqqatfittpa3z8nmdf0klgoetbbzbonykayqkfsejrambkshcvscx' );
define( 'LOGGED_IN_SALT',   'bbttfxhhborbyhzcfqhfoxq3ez8dtislkysmek28un1a7y3c9gvayjec7w47dmeg' );
define( 'NONCE_SALT',       '7epxjm9gle49gflzc6zri9ogwgx9ecfm9nihxmkcvm76jy8prv4nlw6w0cpcczdd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp6k_';

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

define( 'WP_REDIS_DATABASE', 8 );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
