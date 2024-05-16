<?php
/*
Template Name: Login page
*/

// Начать буферизацию вывода
ob_start();

get_header();

if (isset($_POST['submitLogin'])) {
$userName = sanitize_user($_POST['username']);
$password = $_POST['password'];
$email = sanitize_email($_POST['email']);

// Создание пользователя
$user_id = wp_create_user($userName, $password, $email);

if (is_wp_error($user_id)) {
// Ошибка при создании пользователя, обработайте по своему усмотрению
echo 'Ошибка: ' . $user_id->get_error_message();
} else {
// Пользователь успешно создан, производим логин
$user = get_user_by('id', $user_id);
wp_set_current_user($user_id, $user->user_login);
wp_set_auth_cookie($user_id);

// Перенаправление на главную страницу
wp_redirect(home_url('/'));
exit();
}
}

// Вывод формы логина
echo '<form id="LoginForm" method="POST" action="' . esc_url($_SERVER['REQUEST_URI']) . '" enctype="multipart/form-data">
<input type="text" name="username">
<input type="password" name="password">
<input type="email" name="email">
<input type="submit" name="submitLogin" value="Зарегистрироваться">
</form>';

// Завершить буферизацию и отправить содержимое буфера на вывод
ob_end_flush();

get_footer();
?>