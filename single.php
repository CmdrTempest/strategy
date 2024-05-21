<?php
get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Начинаем цикл WordPress, который проверяет, есть ли у нас записи для отображения
        while (have_posts()) :
            the_post();

            if (get_post_type() == 'course') {
                get_template_part('template-parts/content', 'course');
            } else {
                // Для всех остальных типов записей используем стандартный шаблон
                get_template_part('template-parts/content', get_post_type());
            }

        endwhile; // Конец цикла WordPress
        ?>

    </main>
</div>

<?php
get_footer();
?>
