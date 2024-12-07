<?php
if (!defined('ABSPATH')) exit;

// Define constants
if (!defined('_VERSION')) {
	define('_VERSION', '1.0.0');
}

require_once __DIR__ . '/vendor/autoload.php';


// Styles and scripts
require get_template_directory() . '/inc/_scripts.php';

// Custom post types
require get_template_directory() . '/inc/_post-types.php';

// Custom settings page
require get_template_directory() . '/inc/_settings-page.php';

// Form handling
require get_template_directory() . '/inc/_form-handling.php';
