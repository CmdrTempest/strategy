<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php get_header(); ?>
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <main class="container-fluid">
        <div class="container">
            <div class="block1 d-flex">
                <nav class="menu">
                    <?php
                    // Вывод категорий курсов в меню
                    $categories = get_terms(array('taxonomy' => 'course_category', 'hide_empty' => false));
                    foreach ($categories as $category) {
                        echo '<a href="' . get_term_link($category) . '">' . $category->name . '</a>';
                    }
                    ?>
                </nav>
                <div class="items">
                    <div class="sort">
                        <p>
                            Сортировать по: <a class="active" href="#">Цена</a>
                        </p>
                        <div class="boxes d-flex clearfix">
                            <?php
                            $args = array(
                                'post_type'      => 'course',
                                'posts_per_page' => 9,
                            );

                            $query = new WP_Query($args);

                            if ($query->have_posts()) :
                                while ($query->have_posts()) : $query->the_post();
                            ?>
                                    <div class="box">
                                        <figure>
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('thumbnail', array('width' => 280, 'height' => 200));
                                            }
                                            ?>
                                            <figcaption>
                                                <p><strong>Цена:</strong> <span class="price"><?php echo get_post_meta(get_the_ID(), 'цена', true); ?></span> рублей за урок</p>
                                                <p><strong>Часы:</strong> <?php echo get_post_meta(get_the_ID(), 'hours', true); ?></p>
                                                <p><strong>Люди:</strong> <?php echo get_post_meta(get_the_ID(), 'people-count', true); ?></p>
                                                <p><strong>Рейтинг:</strong> <?php echo get_post_meta(get_the_ID(), 'rating', true); ?>/5</p>
                                            </figcaption>
                                            <p class="title"><?php the_title(); ?></p>
                                            <button>
                                                Записаться
                                            </button>
                                        </figure>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo 'Курсы не найдены.';
                            endif;
                            ?>
                        </div>
                        <div class="pagination d-flex">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doubleleft.png" alt="Первая">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/left.png" alt="Предыдущая">
                            <a href="#" class="active">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#">4</a>
                            <a href="#">5</a>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/right.png" alt="Следующая">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doubleright.png" alt="Последняя">
                        </div>
                    </div>
                </div>
            </div>
            <div class="news">
                <h2>НАШИ САМЫЕ ПОПУЛЯРНЫЕ КУРСЫ</h2>
                <div class="boxes d-flex">
                    <?php
                    $args = array(
                        'post_type'      => 'course',
                        'posts_per_page' => 4,
                        'meta_key'       => 'популярность',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                    ?>
                            <div class="box">
                                <figure>
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('thumbnail', array('width' => 280, 'height' => 200));
                                    }
                                    ?>
                                    <figcaption>
                                        <p><strong>Цена:</strong> <span class="price"><?php echo get_post_meta(get_the_ID(), 'цена', true); ?></span> рублей за урок</p>
                                        <p><strong>Часы:</strong> <?php echo get_post_meta(get_the_ID(), 'hours', true); ?></p>
                                        <p><strong>Люди:</strong> <?php echo get_post_meta(get_the_ID(), 'people-count', true); ?></p>
                                        <p><strong>Рейтинг:</strong> <?php echo get_post_meta(get_the_ID(), 'rating', true); ?>/5</p>
                                    </figcaption>
                                    <p class="title"><?php the_title(); ?></p>
                                    <button>
                                        Записаться
                                    </button>
                                </figure>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo 'Курсы не найдены.';
                    endif;
                    ?>
                </div>
            </div>
            <div class="adv">
                <h2>ПОЧЕМУ ИМЕННО МЫ?</h2>
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Bass.jpg" class="d-block w-100" alt="bass" width="800" height="400">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Piano.jpg" class="d-block w-100" alt="bass" width="800" height="400">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Guitar.jpg" class="d-block w-100" alt="bass" width="800" height="400">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>
</html>
