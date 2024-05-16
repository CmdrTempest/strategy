<?php
/*
Template Name: My Account
*/

// Проверка, авторизован ли пользователь
if (!is_user_logged_in()) {
    // Если пользователь не авторизован, перенаправить на страницу входа
    wp_redirect(home_url('/вход'));
    exit();
}

get_header();
?>

<style>
    .account-wrapper {
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        padding: 20px;
        text-align: center;
        margin: 50px auto;
        max-width: 600px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }


    .user-profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }

    .user-info {
        margin-bottom: 10px;
    }

    .user-info strong {
        font-weight: bold;
    }

    .user-info span {
        color: #333;
    }

    h1 {
        margin-bottom: 20px;
        color: #333;
    }

    .logout-button {
        background-color: #00416a;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 20px;
    }

    .logout-button:hover {
        background-color: #2a52be;
    }
</style>

<div class="account-wrapper">
    <h1>Личный кабинет</h1>

    <?php
    // Получение текущего пользователя
    $current_user = wp_get_current_user();

    // Вывод фото пользователя, если есть
    $avatar_url = get_avatar_url($current_user->ID);
    if ($avatar_url) {
        echo '<img class="user-profile-img" src="' . $avatar_url . '" alt="User Profile Picture">';
    }

    // Вывод логина пользователя
    echo '<div class="user-info"><strong>Логин:</strong> <span>' . $current_user->user_login . '</span></div>';

    // Вывод имени пользователя
    echo '<div class="user-info"><strong>Имя:</strong> <span>' . $current_user->display_name . '</span></div>';

    // Перевод ролей
    $role_translations = array(
        'administrator' => 'Администратор',
        'teacher_role' => 'Учитель',
        'check_teacher_role' => 'Учитель на проверке',
        'student_role' => 'Студент',
    );

    // Получение роли пользователя и вывод роли
    $user_role = get_role($current_user->roles[0]);
    if ($user_role && isset($role_translations[$user_role->name])) {
        echo '<div class="user-info"><strong>Роль:</strong> <span>' . $role_translations[$user_role->name] . '</span></div>';
    }

    // Вывод email пользователя
    echo '<div class="user-info"><strong>Email:</strong> <span>' . $current_user->user_email . '</span></div>';

    // Вывод даты регистрации
    echo '<div class="user-info"><strong>Дата регистрации:</strong> <span>' . $current_user->user_registered . '</span></div>';

    ?>

    <a href="<?php echo home_url('/выход'); ?>">Выйти из аккаунта</a>
</div>

<?php

if (in_array('teacher_role', $current_user->roles))
{      
        // Вывод формы логина
        echo '<form id="LoginForm" method="POST" action="' . esc_url($_SERVER['REQUEST_URI']) . '" enctype="multipart/form-data">
        <input type="text" name="username">
        <input type="password" name="password">
        <input type="email" name="email">
        <input type="submit" name="submitLogin" value="Зарегистрироваться">
        </form>';
        if (isset($_POST['submitLogin'])) {

            // $post = get_post(46);
            // $post->post_status = 'pending';
            // $post->post_title = 'Курс';
            // $post->post_author = 1;
            // $post->ID = 0;
            // $post=$post->to_array();
            // unset($post['guid']);
            // unset($post['post_date']);
            // unset($post['post_date_gmt']);

            // print_r(wp_insert_post($post));
    
            // Gather post data.
$my_post = array(
    'post_title'    => 'My post',
    'post_content'  => 'This is my post.',
    'post_type' => 'course',
);

// Insert the post into the database.
wp_insert_post( $my_post );
            exit();
            }
        
    }
?>



<?php 
get_footer();
?>
