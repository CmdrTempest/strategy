<?php

function custom_theme_setup() {
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'strategy'),
        'footer'  => esc_html__('Footer Menu', 'strategy'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

function strategy_assets() {
    // Добавляем стили
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/main.css');
    wp_enqueue_style('custom-style1', get_stylesheet_directory_uri() . '/header_footer.css', array('custom-style'));

    // Добавляем поддержку миниатюр
    add_theme_support('post-thumbnails');

    // Добавляем поддержку меню
    add_theme_support('menus');
}
add_action('wp_enqueue_scripts', 'strategy_assets');
show_admin_bar(false);

// Регистрация таксономии "Категории курсов"
function register_course_taxonomy() {
    $labels = array(
        'name'                       => 'Категории курсов',
        'singular_name'              => 'Категория курсов',
        'search_items'               => 'Поиск категорий',
        'popular_items'              => 'Популярные категории',
        'all_items'                  => 'Все категории',
        'edit_item'                  => 'Редактировать категорию',
        'update_item'                => 'Обновить категорию',
        'add_new_item'               => 'Добавить новую категорию',
        'new_item_name'              => 'Новая категория',
        'separate_items_with_commas' => 'Разделяйте категории запятыми',
        'add_or_remove_items'        => 'Добавить или удалить категории',
        'choose_from_most_used'      => 'Выбрать из наиболее часто используемых категорий',
        'not_found'                  => 'Категории не найдены',
        'menu_name'                  => 'Категории курсов',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'course_category'),
    );

    register_taxonomy('course_category', 'course', $args);
    add_theme_support('post-thumbnails');
}
add_action('init', 'register_course_taxonomy');

// Регистрация таксономии "Сложность курса"
function register_course_difficulty_taxonomy() {
    $labels = array(
        'name'                       => 'Сложность курса',
        'singular_name'              => 'Сложность курса',
        'search_items'               => 'Поиск сложности курса',
        'popular_items'              => 'Популярные уровни сложности',
        'all_items'                  => 'Все уровни сложности',
        'edit_item'                  => 'Редактировать уровень сложности',
        'update_item'                => 'Обновить уровень сложности',
        'add_new_item'               => 'Добавить новый уровень сложности',
        'new_item_name'              => 'Новый уровень сложности',
        'separate_items_with_commas' => 'Разделяйте уровни сложности запятыми',
        'add_or_remove_items'        => 'Добавить или удалить уровни сложности',
        'choose_from_most_used'      => 'Выбрать из наиболее часто используемых уровней сложности',
        'not_found'                  => 'Уровни сложности не найдены',
        'menu_name'                  => 'Сложность курса',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'course_difficulty'),
    );

    register_taxonomy('course_difficulty', 'course', $args);
}
add_action('init', 'register_course_difficulty_taxonomy');

// Регистрация типа записи "Курс"
function register_course_post_type() {
    $labels = array(
        'name'               => 'Курсы',
        'singular_name'      => 'Курс',
        'add_new'            => 'Добавить новый курс',
        'add_new_item'       => 'Добавить новый курс',
        'edit_item'          => 'Редактировать курс',
        'new_item'           => 'Новый курс',
        'all_items'          => 'Все курсы',
        'view_item'          => 'Посмотреть курс',
        'search_items'       => 'Искать курсы',
        'not_found'          => 'Курсы не найдены',
        'not_found_in_trash' => 'Курсы не найдены в корзине',
        'menu_name'          => 'Курсы',
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'hierarchical'  => false,
        'menu_position' => 5,
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'course'),
        'taxonomies'    => array('course_category', 'course_difficulty'), // Обе таксономии привязаны к курсам
    );

    register_post_type('course', $args);
}
add_action('init', 'register_course_post_type');


function add_course_meta_box() {
    add_meta_box(
        'course_meta_box',      // Unique ID
        'Дополнительная информация',    // Box title
        'display_course_meta_box',  // Content callback
        'course',               // Post type
        'normal',               // Position
        'high'                  // Priority
    );
}
add_action('add_meta_boxes', 'add_course_meta_box');

function display_course_meta_box($post) {
    // Fetch existing values for the fields
    $hours = get_post_meta($post->ID, 'hours', true);
    $people_count = get_post_meta($post->ID, 'people-count', true);
    $rating = get_post_meta($post->ID, 'rating', true);
    ?>

    <label for="hours">Часы:</label>
    <input type="text" id="hours" name="hours" value="<?php echo esc_attr($hours); ?>">

    <label for="people_count">Люди:</label>
    <input type="text" id="people_count" name="people_count" value="<?php echo esc_attr($people_count); ?>">

    <label for="rating">Рейтинг:</label>
    <input type="text" id="rating" name="rating" value="<?php echo esc_attr($rating); ?>">
    <?php
}

function save_course_meta_box($post_id) {
    // Save the custom fields
    if (isset($_POST['hours'])) {
        update_post_meta($post_id, 'hours', sanitize_text_field($_POST['hours']));
    }

    if (isset($_POST['people_count'])) {
        update_post_meta($post_id, 'people-count', sanitize_text_field($_POST['people_count']));
    }

    if (isset($_POST['rating'])) {
        update_post_meta($post_id, 'rating', sanitize_text_field($_POST['rating']));
    }
}
add_action('save_post', 'save_course_meta_box');



// Регистрация типа записи "Новости"
function register_news_post_type() {
    $labels = array(
        'name'               => 'Новости',
        'singular_name'      => 'Новость',
        'add_new'            => 'Добавить новость',
        'add_new_item'       => 'Добавить новость',
        'edit_item'          => 'Редактировать новость',
        'new_item'           => 'Новая новость',
        'all_items'          => 'Все новости',
        'view_item'          => 'Посмотреть новость',
        'search_items'       => 'Искать новости',
        'not_found'          => 'Новости не найдены',
        'not_found_in_trash' => 'Новости не найдены в корзине',
        'menu_name'          => 'Новости',
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite'       => array('slug' => 'news'),
    );

    register_post_type('news', $args);
}

add_action('init', 'register_news_post_type');


function custom_course_template($template) {
    global $post;

    if ($post->post_type == 'course') {
        // Путь к вашему шаблону для курсов
        $custom_template = locate_template('course.php');

        if ($custom_template && !is_singular('course')) {
            return $custom_template;
        }
    }

    return $template;
}
add_filter('template_include', 'custom_course_template');

$result = add_role('participant_role', __('Участник'),
    array(
        'read' => true, // Просмотр
        'edit_posts' => true, // Редактирование своих записей
        'upload_files' => true, // Загрузка файлов
        'comment' => true, // Комментирование
    )
);


$result = add_role( 'teacher_role', __( 'Учитель' ), array(
    'edit_themes' => true, // редактирование тем
    'install_plugins' => true, // установка плагинов
    'update_plugin' => true, // обновление плагинов
    'edit_pages' => true, // редактирование страниц
    'publish_pages' => true, // публикация страниц
    'edit_others_posts' => true, // редактирование постов других пользователей
    'edit_published_posts' => true, // редактирование опубликованных постов
    'edit_private_posts' => true, // редактирование частных постов
    'manage_categories' => true, // управление категориями
    'edit_categories' => true, // редактирование категорий
    'delete_categories' => true, // удаление категорий
    'assign_categories' => true, // назначение категорий
    'manage_tags' => true, // управление метками
    'edit_tags' => true, // редактирование меток
    'delete_tags' => true, // удаление меток
    'manage_terms' => true, // управление терминами таксономии
    'edit_terms' => true, // редактирование терминов таксономии
    'delete_terms' => true, // удаление терминов таксономии
    'edit_course' => true, // Право на редактирование курсов
    'edit_courses' => true, // Право на редактирование списка курсов
    'edit_posts' => true, // Право на редактирование постов
) );

$result = add_role('check_teacher_role', __('Учитель на проверке'),
    array(
        'read' => true, // Просмотр
        'edit_posts' => true, // Редактирование своих записей
        'upload_files' => true, // Загрузка файлов
        'comment' => true, // Комментирование
    )
);

$result = add_role( 'organizer', __( 'Организатор' ), array(
    'edit_themes' => true, // редактирование тем
    'install_plugins' => true, // установка плагинов
    'update_plugin' => true, // обновление плагинов
    'edit_pages' => true, // редактирование страниц
    'publish_pages' => true, // публикация страниц
    'edit_others_posts' => true, // редактирование постов других пользователей
    'edit_published_posts' => true, // редактирование опубликованных постов
    'edit_private_posts' => true, // редактирование частных постов
    'manage_categories' => true, // управление категориями
    'edit_categories' => true, // редактирование категорий
    'delete_categories' => true, // удаление категорий
    'assign_categories' => true, // назначение категорий
    'manage_tags' => true, // управление метками
    'edit_tags' => true, // редактирование меток
    'delete_tags' => true, // удаление меток
    'manage_terms' => true, // управление терминами таксономии
    'edit_terms' => true, // редактирование терминов таксономии
    'delete_terms' => true, // удаление терминов таксономии
    'edit_course' => true, // Право на редактирование курсов
    'edit_courses' => true, // Право на редактирование списка курсов
    'edit_posts' => true, // Право на редактирование постов
	'edit_organizer_content' => true, // Право на редактирование контента организатора
) );


// Функция для редиректа после выхода из аккаунта
function custom_logout_redirect($logout_url, $redirect) {
    return $logout_url . '&amp;redirect_to=' . urlencode($redirect);
}
add_filter('выход', 'custom_logout_redirect', 10, 2);

function add_query_vars_filter( $vars ){
    $vars[] = "password";
    $vars[] = "username";
    return $vars;
  }
  
  add_filter( 'query_vars', 'add_query_vars_filter' );
  
  get_query_var('password');
  get_query_var('username');