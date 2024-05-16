<?php
/*
Template Name: О нас
*/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
?>

<style>
    /* Стили для страницы "О нас" */
    .about-us-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .about-us-title {
        font-size: 42px;
        color: #333;
        margin-bottom: 20px;
    }

    .about-us-content p {
        line-height: 1.6;
        color: #555;
    }
</style>

<div class="about-us-content">
    <h2 class="about-us-title"><?php the_title(); ?></h2>
    <?php the_content(); ?>
</div>

<?php
    endwhile;
endif;

get_footer();
