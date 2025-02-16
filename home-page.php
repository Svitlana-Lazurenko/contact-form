<?php
if (!defined('ABSPATH')) exit; ?>

<?php
/*
Template Name: Home Page
Template Post Type: page
*/

get_header(); ?>

<main>
    <section class="connection">
        <div class="container container--flex">

            <div class="about">
                <h1 class="about__text">Ми завжди готові запропонувати інноваційні та альтернативні шляхи лікування зубів</h1>
            </div>

            <form method="post" data-ajax="true" class="form">
                <p class="form__title">Заповніть форму та отримайте професійну консультацію</p>

                <?php wp_nonce_field('custom_contact_form', 'custom_contact_form_nonce'); ?>

                <div class="form__group">
                    <label for="name" class="form__label">Ваше ім’я</label>
                    <input type="text" id="name" name="name" class="form__control" placeholder="Вкажіть Ваше ім’я">
                    <p class="form__error form__error--name"></p>
                </div>

                <div class="form__group">
                    <label for="phone" class="form__label">Ваш телефон</label>
                    <input type="text" id="phone" name="phone" class="form__control form__control--phone">
                    <p class="form__error form__error--phone"></p>
                </div>

                <div class="form__group">
                    <label for="email" class="form__label">Ваш e-mail</label>
                    <input type="text" id="email" name="email" class="form__control" placeholder="email@gmail.com">
                    <p class="form__error form__error--email"></p>
                </div>

                <div class="form__group">
                    <label for="description" class="form__label visually-hidden">Короткий опис</label>
                    <textarea rows="10" id="description" name="description" class="form__control form__control--description" placeholder="Коротко опишіть проблему, яку хочете вирішити"></textarea>
                </div>

                <button type="submit" class="btn">
                    <span class="spinner"></span><span class="btn__text">Надіслати<span>
                </button>

                <p class="form__agreement">Натискаючи на кнопку, я даю згоду на <a class="form__agreement-link" href="" target="_blank" rel="noopener noreferrer">обробку персональних даних</a></p>
                <p class="form__message"></p>
            </form>

        </div>
    </section>

</main>

<?php get_footer(); ?>