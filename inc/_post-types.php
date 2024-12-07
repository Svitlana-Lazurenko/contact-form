<?php
if (!defined('ABSPATH')) exit; ?>

<?php

add_action('init', function () {
    register_post_type('lead', [
        'labels' => [
            'name' => 'Ліди',
            'singular_name' => 'Лід',
        ],
        'public' => false,
        'show_ui' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'supports' => ['title', 'editor', 'custom-fields'],
    ]);
});
