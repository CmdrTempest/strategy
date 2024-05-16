<?php
   get_header(); // Включаем шапку сайта
   ?>

   <div id="primary" class="content-area">
       <main id="main" class="site-main">

           <?php
           // Начинаем цикл WordPress, который проверяет, есть ли у нас записи для отображения
           while (have_posts()) :
               the_post();

               // Включаем шаблон содержимого поста (можно использовать content.php или создать свой)
               get_template_part('template-parts/content', get_post_type());

               // Если нужны комментарии, можно добавить функцию комментариев здесь
               // comments_template();

           endwhile; // Конец цикла WordPress
           ?>

       </main><!-- #main -->
   </div><!-- #primary -->

   <?php
   get_footer(); // Включаем подвал сайта