<?php // phpcs:disable
if (defined('ABSPATH')) {
    return;
}

define('ABSPATH', realpath('./vendor/roots/wordpress') . DIRECTORY_SEPARATOR);
define('WPINC', 'wp-includes');
define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

require_once realpath('./vendor/roots/wordpress/wp-includes/class-wp-rewrite.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/load.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/plugin.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/functions.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/option.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/link-template.php');
require_once realpath('./vendor/roots/wordpress/wp-includes/rest-api.php');
