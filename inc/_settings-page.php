<?php
if (!defined('ABSPATH')) exit; ?>

<?php

function add_settings_page()
{
    add_menu_page(
        'Налаштування інтеграцій',
        'Інтеграції',
        'manage_options',
        'integrations_settings',
        'integrations_settings_page',
        'dashicons-email-alt',
        90
    );
}
add_action('admin_menu', 'add_settings_page');

function integrations_settings_page()
{
?>
    <div class="wrap">
        <h1>Налаштування інтеграцій</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('settings_group');
            do_settings_sections('integrations_settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

function register_integrations_settings()
{
    register_setting('settings_group', 'email_recipients');
    register_setting('settings_group', 'telegram_chat_id');
    register_setting('settings_group', 'telegram_bot_token');

    add_settings_section(
        'email_section',
        'Email Налаштування',
        null,
        'integrations_settings'
    );

    add_settings_section(
        'telegram_section',
        'Telegram Налаштування',
        null,
        'integrations_settings'
    );

    add_settings_field(
        'email_recipients',
        'Email',
        function () {
            $value = esc_attr(get_option('email_recipients'));
            echo "<input type='text' name='email_recipients' value='$value' class='regular-text' />";
            echo "<p class='description'>Введіть email, розділені комами (наприклад, example1@example.com, example2@example.com).</p>";
        },
        'integrations_settings',
        'email_section'
    );

    add_settings_field(
        'telegram_chat_id',
        'ID чату',
        function () {
            $value = esc_attr(get_option('telegram_chat_id'));
            echo "<input type='text' name='telegram_chat_id' value='$value' class='regular-text' />";
            echo "<p class='description'>Введіть ID чату.</p>";
        },
        'integrations_settings',
        'telegram_section'
    );

    add_settings_field(
        'telegram_bot_token',
        'Токен бота',
        function () {
            $value = esc_attr(get_option('telegram_bot_token'));
            echo "<input type='text' name='telegram_bot_token' value='$value' class='regular-text' />";
            echo "<p class='description'>Введіть токен Telegram бота.</p>";
        },
        'integrations_settings',
        'telegram_section'
    );
}
add_action('admin_init', 'register_integrations_settings');
