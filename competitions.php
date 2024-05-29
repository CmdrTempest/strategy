<?php
if(!is_user_logged_in()){
    wp_redirect(home_url("/вход"));
}

get_header();

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div><?php the_excerpt(); ?></div>

<?php endwhile; else : ?>

    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>

<?php endif; ?>


<?php
get_footer();
?>
