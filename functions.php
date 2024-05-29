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
    $vars[] = "course_id";
    return $vars;
  }
  
  add_filter( 'query_vars', 'add_query_vars_filter' );

get_query_var('password');
get_query_var('username');
get_query_var('course_id');




  // Добавляем мета-бокс
function course_add_meta_boxes() {
    add_meta_box(
        'course_url',
        'URL страницы прохождения курса',
        'course_url_meta_box_callback',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'course_add_meta_boxes');

function course_url_meta_box_callback($post) {
    // Добавляем nonce для верификации
    wp_nonce_field('course_save_meta_box_data', 'course_meta_box_nonce');

    $value = get_post_meta($post->ID, '_course_url', true);

    echo '<label for="course_url">URL страницы прохождения курса:</label>';
    echo '<input type="text" id="course_url" name="course_url" value="' . esc_attr($value) . '" size="25" />';
}
// Сохраняем мета-данные при сохранении поста
function course_save_meta_box_data($post_id) {
    if (!isset($_POST['course_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['course_meta_box_nonce'], 'course_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'course' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (!isset($_POST['course_url'])) {
        return;
    }

    $my_data = sanitize_text_field($_POST['course_url']);
    update_post_meta($post_id, '_course_url', $my_data);
}
add_action('save_post', 'course_save_meta_box_data');


// Competitions

function create_competition_post_type() {
    $labels = array(
        'name'               => _x( 'Соревнования', 'post type general name', 'textdomain' ),
        'singular_name'      => _x( 'Соревнование', 'post type singular name', 'textdomain' ),
        'menu_name'          => _x( 'Соревнования', 'admin menu', 'textdomain' ),
        'name_admin_bar'     => _x( 'Соревнование', 'add new on admin bar', 'textdomain' ),
        'add_new'            => _x( 'Добавить новое', 'competition', 'textdomain' ),
        'add_new_item'       => __( 'Добавить новое соревнование', 'textdomain' ),
        'new_item'           => __( 'Новое соревнование', 'textdomain' ),
        'edit_item'          => __( 'Редактировать соревнование', 'textdomain' ),
        'view_item'          => __( 'Просмотреть соревнование', 'textdomain' ),
        'all_items'          => __( 'Все соревнования', 'textdomain' ),
        'search_items'       => __( 'Искать соревнования', 'textdomain' ),
        'parent_item_colon'  => __( 'Родительские соревнования:', 'textdomain' ),
        'not_found'          => __( 'Соревнования не найдены.', 'textdomain' ),
        'not_found_in_trash' => __( 'Соревнования не найдены в корзине.', 'textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'competition' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'competition', $args );
}
add_action( 'init', 'create_competition_post_type' );

function save_competition_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['competition_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['competition_meta_box_nonce'], 'save_competition_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( ! isset( $_POST['competition_tests'] ) ) {
        return;
    }

    $competition_tests = sanitize_text_field( $_POST['competition_tests'] );
    update_post_meta( $post_id, '_competition_tests', $competition_tests );
}
add_action( 'save_post', 'save_competition_meta_box_data' );

function add_competition_meta_box() {
    add_meta_box(
        'competition_tests',
        __( 'Тесты для соревнования', 'textdomain' ),
        'competition_meta_box_callback',
        'competition',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'add_competition_meta_box' );

function competition_meta_box_callback( $post ): void
{
    wp_nonce_field( 'save_competition_meta_box_data', 'competition_meta_box_nonce' );

    $value = get_post_meta( $post->ID, '_competition_tests', true );

    echo '<label for="competition_tests">';
    _e( 'Введите тесты в формате JSON', 'textdomain' );
    echo '</label> ';
    echo '<textarea id="competition_tests" name="competition_tests" rows="10" cols="50" class="large-text">' . esc_attr( $value ) . '</textarea>';
}



function display_competitions(): void
{
    $args = array(
        'post_type' => 'competition',
        'posts_per_page' => -1,
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $competition_tests = get_post_meta( get_the_ID(), '_competition_tests', true );

            echo '<h2>' . get_the_title() . '</h2>';
            echo '<div>' . get_the_content() . '</div>';
            echo '<pre>' . esc_html( $competition_tests ) . '</pre>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>Соревнования не найдены.</p>';
    }
}
add_shortcode( 'display_competitions', 'display_competitions' );

// test-editor
function save_test(): void
{
    if ( ! isset( $_POST['form_data'] ) ) {
        wp_send_json_error( array( 'message' => 'Неверные данные формы' ) );
    }

    parse_str( $_POST['form_data'], $form_data );

    $competition_id = intval( $_POST['competition_id'] );
    $test_id = intval( $_POST['test_id'] );
    $questions = $form_data['questions'] ?? array();

    $questions_json = json_encode( $questions, JSON_UNESCAPED_UNICODE );

    if ( $competition_id > 0 ) {
        update_post_meta( $competition_id, '_competition_tests', $questions_json );
        wp_send_json_success( array( 'message' => 'Тест успешно сохранен в соревновании.' ) );
    } elseif ( $test_id > 0 ) {
        update_post_meta( $test_id, 'test', $questions_json );
        wp_send_json_success( array( 'message' => 'Тест успешно сохранен.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Неверный ID соревнования или теста' ) );
    }
}
add_action( 'wp_ajax_save_test', 'save_test' );
add_action( 'wp_ajax_nopriv_save_test', 'save_test' );
