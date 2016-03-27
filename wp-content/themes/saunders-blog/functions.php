<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'site-style', '/wp-content/themes/saunders-blog/css/app.min.css' );
}

require_once locate_template('/inc/portfolio.php');
require_once locate_template('/inc/events.php');
require_once locate_template('/inc/testimonial.php');
