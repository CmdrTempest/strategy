<?php
if(!is_user_logged_in()){
    wp_redirect(home_url("/вход"));
}

get_header();

?>


<?php
display_competitions();
?>


<?php
get_footer();
?>
