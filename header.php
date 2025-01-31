<?php
if (!defined('ABSPATH')) exit; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="ltr">

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header">
    </header>