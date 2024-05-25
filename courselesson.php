<?php
/*
Template Name: Страница прохождения курса
*/
get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>




            <div class="entry-content">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;


                
                ?>
            </div>
        </article> <?php the_ID(); ?> 
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
