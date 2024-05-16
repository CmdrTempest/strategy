<footer class="container-fluid">
    <div class="container d-flex">
        <div class="left d-flex">
            <figure>
                <img src="<?php echo bloginfo('template_url'); ?>/assets/images/pngwing.com.png" alt="Logo" width="100">
                <figcaption>
                    Музыкальные курсы номер 1
                </figcaption>
            </figure>
            <nav>
                <a class="active" href="0">Курсы</a>
                <a href="0">О нас</a>
                <a href="0">Оплата</a>
                <a href="0">Политика конфиденциальности</a>
                <a href="0">Контакты</a>
            </nav>
        </div>
        <div class="right">
            <form name="search" action="#" method="get">
                <div class="d-flex">
                    <input type="text" name="search" placeholder="Поиск по курсам" />
                    <input type="submit" name="search" value=""/>
                </div>
            </form>
            <div>
                <p>Следите за нами в социальных сетях:</p>
                <div class="d-flex">
                    <a href="https://www.instagram.com/" class="box insta"></a>
                    <a href="https://www.vk.com/" class="box vk"></a>
                    <a href="https://t.me/" class="box tg"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container copyrights">
        <p>
            Все права защищены&copy; 2023
        </p>
    </div>
    <style>
        footer .right form input[type="submit"] {
        width: 20px;
        height: 20px;
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/search.png") no-repeat;
        background-size: cover;
        border: none;
        }

        footer .right .insta {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/insta.png") no-repeat;
        background-size: cover;
        transition: linear 0.3s;
        }

        footer .right .insta:hover {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/instar.png") no-repeat;
        background-size: cover;
        cursor: pointer;
        transition: linear 0.3s;
        }

        footer .right .vk {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/vk.png") no-repeat;
        background-size: cover;
        transition: linear 0.3s;
        }

        footer .right .vk:hover {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/vkr.png") no-repeat;
        background-size: cover;
        cursor: pointer;
        transition: linear 0.3s;
        }

        footer .right .tg {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/tg.png") no-repeat;
        background-size: cover;
        transition: linear 0.3s;
        }

        footer .right .tg:hover {
        background: url("<?php echo get_template_directory_uri(); ?>/assets/images/tgr.png") no-repeat;
        background-size: cover;
        cursor: pointer;
        transition: linear 0.3s;
        }
    </style>
</footer>
</body>
