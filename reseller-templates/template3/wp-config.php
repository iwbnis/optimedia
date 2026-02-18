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
define( 'DB_NAME', 'choiceiptv35556_48' );

/** MySQL database username */
define( 'DB_USER', 'choiceiptv35556_48' );

/** MySQL database password */
define( 'DB_PASSWORD', '4!-pS7s4m3' );

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
define( 'AUTH_KEY',         'wqioerzqoopeg8r70m2ifbfjbvrwunda81nupopzsjhhzrqj5npgqofezvug8j9x' );
define( 'SECURE_AUTH_KEY',  'zlqww8yyh26ugbvypikg7bqctnqbge4ns8uh8qgncnyxc5rio6cxzwtc2fxyhibb' );
define( 'LOGGED_IN_KEY',    '8jks0fmqgbopcvltv54pnfn79iyvwic3xoscxgd05fmdfaqjw6kwnji3rgwtfzd1' );
define( 'NONCE_KEY',        'w9hwckshqcvkjupsmzfj8tim3idbrpbomkpwqb2sahwcf9artlanl8opmo4hxero' );
define( 'AUTH_SALT',        'o0hae6pvuf3gjl8ee4droolpgxzrxycisyk5bseimjlga2voywl4gxk7qdwqorrl' );
define( 'SECURE_AUTH_SALT', 'kakxckby5kvfpofscrp9rq65g0j6zdk1q7pa2awdll2wofdntvejvnjqtqideaur' );
define( 'LOGGED_IN_SALT',   'tu1l5ggsokp7vxauwzsfwirbdxiinkix2gaczxpqsma6awa29biqffzkbzrlago7' );
define( 'NONCE_SALT',       'k8jndlyybqfyp9cwqw7osi6ttjmnvmrtt1ur3ypsivuonqcalpa5wv0gqlfq6mfd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpmg_';

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

define( 'WP_REDIS_DATABASE', 3 );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
