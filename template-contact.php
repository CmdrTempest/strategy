<?php
/*
Template Name: Контакты
*/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
?>

<style>
    /* Стили для страницы "Контакты" */
    .contact-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 20px;
    }

    .contact-title {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    .contact-details {
        font-size: 16px;
        color: #555;
    }

    .social-icons {
        margin-top: 20px;
    }

    .social-icons a {
        display: inline-block;
        margin-right: 15px;
    }

    .social-icons img {
        width: 30px;
        height: 30px;
    }

    .thank-you-message {
        font-size: 18px;
        font-weight: bold;
        color: #27ae60;
        margin-top: 20px;
    }
</style>

<div class="contact-content">
    <h2 class="contact-title"><?php the_title(); ?></h2>
    <p class="contact-details">
        Добро пожаловать в раздел контактов нашего музыкального образовательного портала! Мы готовы ответить на ваши вопросы, предоставить необходимую информацию и поддержку.
    </p>
    
    <p class="contact-details">
        <strong>Адрес:</strong> бул. 123 лет Октября, 456, Бежицкий район, Брянск
    </p>

    <p class="contact-details">
        <strong>Телефон:</strong> +7 (123) 456-78-90
    </p>

    <p class="contact-details">
        <strong>Электронная почта:</strong> HarmonyCraft@example.com
    </p>

    <div class="social-icons">
        <a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/vkr.png" alt="VK"></a>
        <a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/tgr.png" alt="Telegram"></a>
        <a href="#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/instar.png" alt="Instagram"></a>
    </div>

    <p class="thank-you-message">Спасибо, что выбрали нас! Мы ценим ваше внимание и готовы помочь вам достичь ваших музыкальных целей.</p>
</div>

<?php
    endwhile;
endif;

get_footer();
?>
