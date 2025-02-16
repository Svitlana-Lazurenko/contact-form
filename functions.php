<?php
if (!defined('ABSPATH')) exit;

// Define constants
if (!defined('_VERSION')) {
    define('_VERSION', '1.0.0');
}


// Styles and scripts
require get_template_directory() . '/inc/_scripts.php';

// Custom post types
require get_template_directory() . '/inc/_post-types.php';

// Custom settings page
require get_template_directory() . '/inc/_settings-page.php';

// Form handling
require get_template_directory() . '/inc/_form-handling.php';
