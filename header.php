<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Добавляем стили из темы -->
    <?php wp_head(); ?>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <header class="container-fluid">
        <div class="container d-flex">
            <img src="<?php echo bloginfo('template_url'); ?>/assets/images/pngwing.com.png" alt="Logo" width="100">
            <img class="burger" src="images\burger.png" alt="burger" />
            <?php
            // Выводим меню "Primary Menu"
            if ( has_nav_menu( 'primary' ) ) {
                $args = array(
                    'theme_location'    => 'primary',
                    'menu_class'        => 'menu nepalbuzz-nav-menu',
                    'container'         => false
                );
                wp_nav_menu( $args );
            }
            ?>
            <form name="search" action="#" method="get">
                <div class="d-flex">
                    <input type="text" name="search" placeholder="Поиск по курсам" />
                    <input type="submit" name="search" value=""/>
                </div>
            </form>
            <div class="prof d-flex">
                <img src="<?php echo bloginfo('template_url'); ?>/assets/images/prof.png" alt="prof" width="40px" height="40px">
                <div>
                    <a href="/личный-кабинет">Личный кабинет</a>
                </div>
            </div>
        </div>
    </header>
