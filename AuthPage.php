<?php
/*
Template Name: Auth page
*/

// Начать буферизацию вывода
ob_start();

get_header();

if (isset($_POST['submitAuth'])) {
$userName = sanitize_user($_POST['username']);
$password = $_POST['password'];

$user = wp_authenticate($userName, $password);

if (is_wp_error($user)) {

    echo 'Ошибка: ' . $user->get_error_message();
} else {
// Пользователь успешно создан, производим логин
$user = get_user_by('id', $user);
wp_set_current_user($user, $user->user_login);
wp_set_auth_cookie($user);

// Перенаправление на главную страницу
$url = add_query_arg($_POST,home_url("/загрузка"));
wp_redirect($url);
exit();
}
}

// Вывод формы логина
echo '<form id="LoginForm" method="POST" action="' . esc_url($_SERVER['REQUEST_URI']) . '" enctype="multipart/form-data">
<input type="text" name="username">
<input type="password" name="password">
<input type="submit" name="submitAuth" value="Войти">
</form> <a href="/логин">Регистрация</a>';



// Завершить буферизацию и отправить содержимое буфера на вывод
ob_end_flush();

get_footer();
?>