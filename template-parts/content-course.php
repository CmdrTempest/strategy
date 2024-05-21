<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        the_content();

        // Отображение меток (тегов) записи, если они есть
        if (has_tag()) {
            the_tags('<div class="entry-tags">Теги: ', ', ', '</div>');
        }

        // Получаем URL страницы прохождения курса
        $course_url = get_post_meta(get_the_ID(), '_course_url', true);

        // Если URL страницы прохождения курса есть, отображаем кнопку
        if ($course_url) {
            echo '<div class="entry-course-button"><a href="' . esc_url($course_url) . '" class="button">Пройти курс</a></div>';
        }
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        // Отображение информации о категориях записи
        if (has_category()) {
            echo '<div class="entry-categories">Категории: ';
            the_category(', ');
            echo '</div>';
        }

        // Отображение ссылки на комментарии, если разрешены
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
