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
define( 'DB_NAME', 'wordpress');

/** Database username */
define( 'DB_USER', 'root');

/** Database password */
define( 'DB_PASSWORD', 'Toor95612612');

/** Database hostname */
define( 'DB_HOST', 'mysql');

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

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
define( 'AUTH_KEY',         'Ia+wE>&,LO~-_LHo$U3;:U=e{dZ5MCs0{@fVOPj)vJneQpOmaqP5z2!-:A3M.hX:' );
define( 'SECURE_AUTH_KEY',  'M,B]v{>Y).r!?J_?4Y;L]9q@KZz %8NtO/=4fURdgb,N4JC 3/v>mDf?S07kGAH^' );
define( 'LOGGED_IN_KEY',    '?=:v}&j]8Zt=/kyi63ef{4hYu%O9Au4q!=n2bc@,^)!YjP*3p7k}Am~Gq^4CIyzv' );
define( 'NONCE_KEY',        'bM{OF8O[_k/X7!y748kF4dsi pNSyy3XWJQtS=(b~)ZJN$H*oB3341R4vK[3m,,b' );
define( 'AUTH_SALT',        'C8d]H6/9#}YROUW!CS,cI#|?3t$i+&7JMldYt}!VNuuXIQ0mg s!4>1-/*U+4LvV' );
define( 'SECURE_AUTH_SALT', 'U8R^09+x04>l_@ZTAUfg{DWV1Nm3~xUa_D^D}xsRfAG5p]~s5#`5TTkQ[jhoY$i6' );
define( 'LOGGED_IN_SALT',   'S9*cD]!EgH1=+oeRH~)EPaNJ7(Vx}ZachH8NFW3~GQ]gLL?L9cu?A7e.jl?]<tEG' );
define( 'NONCE_SALT',       '5@;c8=jmT;jX7sebX~Jp<dG%&yL(@Ro]5g:%^5-e)^vB?P:+)N_%oncO^r1F)/-q' );

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
