<?php

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
 * @link    https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

if ( ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}

const TRACKING = false;
if ( ! defined( 'FS_METHOD' ) ) {
	define( 'FS_METHOD', 'direct' );
}


// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */

const DB_NAME     = 'annam';
const DB_USER     = 'root';
const DB_PASSWORD = '';

const DB_HOST    = 'localhost';
const DB_CHARSET = 'utf8mb4';
const DB_COLLATE = '';

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
define( 'AUTH_KEY', 'y#$%r:?(k2+J/V3C|04H6c*|)_p,>L(xt}#z}:^BrqQ[PG+k9)KaHmd@&^yIZ)>g' );
define( 'SECURE_AUTH_KEY', '|)2BX6YFR.i0rRK@RS)-h=F.E#1Q2G.#Qu|l/grKUEt&4O.w0);.*9;NYO9AngkA' );
define( 'LOGGED_IN_KEY', 'J.Wwq1UpI4/)-H%=cK*[1EK+%{JxG<,ZaE|p,q*hiN^^+eyDVsf/F %%8Vf5B6iz' );
define( 'NONCE_KEY', 'Ze^p^-,?eA[#qm{D,g2yx9&_S8b,8 7k:C(xI}O|i.g&&HIdl|,BM7f0d|/4xNeH' );
define( 'AUTH_SALT', '(tn%y~-{rA%F}%Ev?UBI?&Kq;OIzIHXB{gS5*]duoKdZ-KrPyS+0a?T`;R4*+_,=' );
define( 'SECURE_AUTH_SALT', 'zWF`%7a!(His<PGdiW3U@K+8u?=WYUOicR:Vm.Rt-3Z_]tQ7RyZ<8+kR,~i2Hcw9' );
define( 'LOGGED_IN_SALT', '|O=,SP>-mcoLX[mvr+)aE~Qx@p}|(j17sx,]*gWbt%x~gZ1]$l <?1O}B+dW+go;' );
define( 'NONCE_SALT', 'Ryo@lyg^!M*,soG-J#}aw)v4+*X>F0D_+0[31$)#v@/JY#1~!p!tmL<f8xs;:?G~' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'w_';

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
const WP_DEBUG = false;

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
