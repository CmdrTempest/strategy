<?php
/*
Template Name: Logout Page
*/

// Выход из аккаунта
wp_logout();

// Перенаправление на страницу входа
wp_redirect(home_url('/вход')); // Укажите здесь URL страницы входа
exit;
?>