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