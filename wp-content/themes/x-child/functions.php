<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );

// Additional Functions
// =============================================================================

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style('styles', get_stylesheet_directory_uri().'/css/app.min.css');
}

include 'inc/rss_feeds.php';
include 'inc/events.php';

function add_menu_order_support_for_portfolios() {
	add_post_type_support( 'x-portfolio', 'page-attributes' );
}
add_action( 'init', 'add_menu_order_support_for_portfolios' );
