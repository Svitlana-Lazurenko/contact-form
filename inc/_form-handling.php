<?php
if (!defined('ABSPATH')) exit;

add_action('wp_ajax_custom_contact_form', 'handle_custom_contact_form_ajax');
add_action('wp_ajax_nopriv_custom_contact_form', 'handle_custom_contact_form_ajax');

function handle_custom_contact_form_ajax()
{
    if (!isset($_POST['custom_contact_form_nonce']) || !wp_verify_nonce($_POST['custom_contact_form_nonce'], 'custom_contact_form')) {
        wp_send_json_error(['message' => 'Невірна форма запиту.']);
    }

    //======================== Form processing ==========================
    $name = preg_replace('/\s+/', ' ', sanitize_text_field($_POST['name']), -1, $count);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $description = sanitize_textarea_field($_POST['description']);
    $utmSource = sanitize_text_field($_POST['utm_source'] ?? '');
    $utmMedium = sanitize_text_field($_POST['utm_medium'] ?? '');
    $utmCampaign = sanitize_text_field($_POST['utm_campaign'] ?? '');
    $utmTerm = sanitize_text_field($_POST['utm_term'] ?? '');
    $utmContent = sanitize_text_field($_POST['utm_content'] ?? '');
    $formDate = sanitize_text_field($_POST['form_date'] ?? current_time('mysql'));

    $nameRegex = "/^[\p{L}\s'’‘-]+$/u";
    $phoneRegex = "/^\+?[0-9]{1,4}[-. ]?\(?[0-9]{1,3}\)?[-. ]?[0-9]{3,4}[-. ]?[0-9]{3,4}$/";
    $emailRegex = "/[A-Za-z0-9\._%+\-]+@[A-Za-z0-9\.\-]+\.[A-Za-z]{2,}/";

    if (empty($name)) {
        wp_send_json_error(['message' => 'Поле "Ім\'я" є обов\'язковим', 'name' => 'name'], 400);
    } elseif (!preg_match($nameRegex, $name)) {
        wp_send_json_error(['message' => 'Вкажіть Ваше ім\'я', 'name' => 'name'], 400);
    }

    if (empty($phone)) {
        wp_send_json_error(['message' => 'Поле "Номер телефону" є обов\'язковим', 'name' => 'phone'], 400);
    } elseif (!preg_match($phoneRegex, $phone)) {
        wp_send_json_error(['message' => 'Вкажіть Ваш номер телефону у міжнародному форматі', 'name' => 'phone'], 400);
    }

    if (!empty($email) && !preg_match($emailRegex, $email)) {
        wp_send_json_error(['message' => 'Вкажіть Вашу електронну адресу', 'name' => 'email'], 400);
    }

    // =================== Creating a message and data ====================
    $message = "Ім'я: $name\n";
    $message .= "Номер телефону: $phone\n";
    $message .= $email ? "Електронна пошта: $email\n" : '';
    $message .= $description ? "Короткий опис:\n$description\n" : '';
    $message .= "\n--- Додаткова інформація ---\n";
    $message .= $utmSource ? "UTM Source: $utmSource\n" : '';
    $message .= $utmMedium ? "UTM Medium: $utmMedium\n" : '';
    $message .= $utmCampaign ? "UTM Campaign: $utmCampaign\n" : '';
    $message .= $utmTerm ? "UTM Term: $utmTerm\n" : '';
    $message .= $utmContent ? "UTM Content: $utmContent\n" : '';
    $message .= "Дата та час відправки форми: $formDate\n";

    // =================== Adding a custom post type ==============================
    function create_lead_post($name, $message)
    {
        $postId = wp_insert_post([
            'post_type' => 'lead',
            'post_title' => $name,
            'post_content' => $message,
            'post_status' => 'publish',
        ]);

        if (is_wp_error($postId)) {
            wp_send_json_error(['message' => 'Помилка під час додавання запису'], 500);
        }
    }

    create_lead_post($name, $message);

    // =============== Sending an email ===========================
    function send_form_email($message)
    {
        $recipients = get_option('email_recipients');
        $subject = 'Нова заявка з контактної форми';
        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        if ($recipients) {
            $recipients = array_map('trim', explode(',', $recipients));
            foreach ($recipients as $recipient) {
                $result = wp_mail($recipient, $subject, $message, $headers);
                if (!$result) {
                    wp_send_json_error(['message' => "Помилка під час відправки email на адресу: $recipient."], 500);
                }
            }
        } else {
            return;
        }
    }

    send_form_email($message);

    // ================================== Sending a Telegram message =======================
    function send_to_telegram($message)
    {
        $chatId = get_option('telegram_chat_id');
        $botToken = get_option('telegram_bot_token');

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];

        if ($botToken && $chatId) {
            $response = wp_remote_post($url, [
                'body' => $data,
            ]);
            if (!$response) {
                wp_send_json_error('Помилка відправки в Telegram.', 500);
            }
        } else {
            return;
        }
    }

    send_to_telegram($message);

    //========================= Successful response ==============================
    wp_send_json_success(['message' => 'Форма успішно оброблена!']);
}
