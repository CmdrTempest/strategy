<?php
/*
Template Name: Auth help
*/

$username = get_query_var("username");
$password = get_query_var("password");

$creds = array();
$creds['user_login'] = $username;
$creds['user_password'] = $password;
$creds['remember'] = true;
echo $username;
$user = wp_signon( $creds, false );

if ( is_wp_error($user) ) {
   echo $user->get_error_message();
}

// Перенаправление на страницу входа
wp_redirect(home_url('/')); 
exit();
?>