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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //

if(strstr($_SERVER['SERVER_NAME'], 'localhost')) {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'developTheme' );

	/** Database username */
	define( 'DB_USER', 'root' );
	
	/** Database password */
	define( 'DB_PASSWORD', '' );
	
	/** Database hostname */
	define( 'DB_HOST', 'localhost' );
} else {
	/** The name of the database for WordPress */
	define( 'DB_NAME', 'atacoo_special' );

	/** Database username */
	define( 'DB_USER', 'atacoo_ata3554' );
	
	/** Database password */
	define( 'DB_PASSWORD', 'omiddimo3554' );
	
	/** Database hostname */
	define( 'DB_HOST', '127.0.0.1' );
}
	
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
define( 'AUTH_KEY',         '*OD.JAcW^SbB#S4@.1Zjo1L!zZ&<J^chXyOrE*oEdcTsqq!J 0`Flh^vF,ve{pCE' );
define( 'SECURE_AUTH_KEY',  '10=BI@dg1fAuATvc{l<+P1Gv;H((-P=w<t;La7uV0${uu;73:4j;pr&N}5*^Wu<%' );
define( 'LOGGED_IN_KEY',    'ry$~~ZP.5APR]od,Yqar9aoThOu>.xEXWM?y2sS/L%0A+ih+TV5xXzQj|5oEh(Fr' );
define( 'NONCE_KEY',        'j2sF(|^,%|yl2t((O3:q,g_yf Nh0jIP<=WCvJ*_j_QL=laP:~A%.Em1:/wdrr`0' );
define( 'AUTH_SALT',        'QX4:4L(IhSXMQ297,GMWBdx>IK>%yo6XkUN{(5`O1r`c.dXXZO9<JQsN*m,3jM~|' );
define( 'SECURE_AUTH_SALT', 'pp OB*[aj)yl,$EUE|CpQ@4E(3q|8uuar(ahcV?a*/ jj^/cguM&lz Q j1`/l[G' );
define( 'LOGGED_IN_SALT',   ')Q`M61N_;q*B@8~[,&Q.}9 3?y[BtlcBup^$@#?nF>bAG#U*.160t/2r#6(ibP,Q' );
define( 'NONCE_SALT',       'jb.PyNLYJi(|g(r-&x S+I_gs0c?5DBolDoE=tn6Gr`V_Ud{k N6-^Mo KUn+KH[' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
