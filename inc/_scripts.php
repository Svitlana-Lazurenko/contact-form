<?php
if (!defined('ABSPATH')) exit; ?>

<?php

add_action('wp_enqueue_scripts', 'theme_scripts');
function theme_scripts()
{
    // Styles
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/assets/scss/app.min.css',
        [],
        _VERSION
    );

    // Scripts
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/app.min.js',
        [],
        _VERSION,
        true
    );

    // intlTelInput
    wp_enqueue_style(
        'intlTelInput',
        'https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css'
    );
    wp_enqueue_script(
        'intlTelInput',
        'https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js',
        [],
        null,
        true
    );

    // AJAX localization
    wp_localize_script(
        'theme-script',
        'ajax_object',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]
    );
}
