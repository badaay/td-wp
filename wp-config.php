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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tede' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'IlmWbBq2CWGQpvQYfycABspSUmVOfhscnVSamoGF2xDOgzhKFzvA8vmOj3LFhCJT' );
define( 'SECURE_AUTH_KEY',  'v0yrOWy1CORaLc3atyxEWKdOWyMMYbta56FoWMGpgbgEoUJCttcdd1OIlxShJz53' );
define( 'LOGGED_IN_KEY',    '8g7lHkubDovsBOzh2vp2RHe6MHJkVAOitiVxUoxGqBDm6YL5zWTgy7Mwj35ENM7V' );
define( 'NONCE_KEY',        '5WtLd9IXxbUdhOdi7UEEHjTn8YiHmK8ccjUQyhlpww454Xp1ZAYlLzhS8seqrN2C' );
define( 'AUTH_SALT',        'G42F7wD0zLyv9qLoERw2CgUDY8ffj0slBvbZwUcGGXqML1rs64Go8FfF5XqNvZ4v' );
define( 'SECURE_AUTH_SALT', 'TV4UydAlBOF7CbJmLxUqjO8aZQ3MSpsfRWjVZnJeSaGloA9c1FHsNEjcHFnbBVrk' );
define( 'LOGGED_IN_SALT',   'oO72mq70PLS9GViUlTYZ2csNQbP52ZPT3gN3FmaKb3ik7wKPn7j2RvAgn8JYQvFU' );
define( 'NONCE_SALT',       'ehYFN4VyWWQEA5WmtHpNEeqrcEebEibiyp1i4ByJqoYj4pXX3HiALJpSUt60GULj' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
