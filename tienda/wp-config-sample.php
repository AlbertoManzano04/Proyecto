<?php
define('DB_NAME', 'coches_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');  // <- Reemplaza esto con tu contraseña real
define('DB_HOST', '172.21.0.2');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

define('WP_DEBUG', false);

define('AUTH_KEY',         'Jabulani13');
define('SECURE_AUTH_KEY',  'Jabulani13');
define('LOGGED_IN_KEY',    'Jabulani13');
define('NONCE_KEY',        'Jabulani13');
define('AUTH_SALT',        'Jabulani13');
define('SECURE_AUTH_SALT', 'Jabulani13');
define('LOGGED_IN_SALT',   'Jabulani13');
define('NONCE_SALT',       'Jabulani13');

if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');
