<?php
/*
Template Name: Новости
*/

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        $args = array(
            'post_type'      => 'news', 
            'posts_per_page' => 10, 
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>

        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo 'Новости не найдены.';
        endif;
        ?>

    </main>
</div>

<?php
get_footer();
?>