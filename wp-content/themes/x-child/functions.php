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
include 'inc/categories.php';
include 'inc/events.php';
include 'inc/portfolio.php';
include 'inc/rss_feeds.php';

function add_menu_order_support_for_portfolios() {
	add_post_type_support( 'x-portfolio', 'page-attributes' );
}
add_action( 'init', 'add_menu_order_support_for_portfolios' );

// Add excerpts to blog entry FE display

function x_shortcode_recent_posts_v2code( $atts ) {
  extract( shortcode_atts( array(
    'id'          => '',
    'class'       => '',
    'style'       => '',
    'type'        => '',
    'count'       => '',
    'category'    => '',
    'enable_excerpt' => '',
    'offset'      => '',
    'orientation' => '',
    'no_image'    => '',
    'fade'        => ''
  ), $atts ) );

  $id            = ( $id          != ''          ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class         = ( $class       != ''          ) ? 'x-recent-posts cf ' . esc_attr( $class ) : 'x-recent-posts cf';
  $style         = ( $style       != ''          ) ? 'style="' . $style . '"' : '';
  $type          = ( $type        == 'portfolio' ) ? 'x-portfolio' : 'post';
  $count         = ( $count       != ''          ) ? $count : 3;
  $category      = ( $category    != ''          ) ? $category : '';
  $category_type = ( $type        == 'post'      ) ? 'category_name' : 'portfolio-category';
  $offset        = ( $offset      != ''          ) ? $offset : 0;
  $orientation   = ( $orientation != ''          ) ? ' ' . $orientation : ' horizontal';
  $no_image      = ( $no_image    == 'true'      ) ? $no_image : '';
  $fade          = ( $fade        == 'true'      ) ? $fade : 'false';
  $enable_excerpt = ( $enable_excerpt == 'true'      ) ? true : false;

  $output = "<div {$id} class=\"{$class}{$orientation}\" {$style} data-fade=\"{$fade}\">";

    $q = new WP_Query( array(
      'orderby'          => 'date',
      'post_type'        => "{$type}",
      'posts_per_page'   => "{$count}",
      'offset'           => "{$offset}",
      "{$category_type}" => "{$category}"
    ) );

    if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();

      if ( $no_image == 'true' ) {
        $image_output       = '';
        $image_output_class = 'no-image';
      } else {
        $image_output       = '<div class="x-recent-posts-img">' . get_the_post_thumbnail( get_the_ID(), 'entry-' . get_theme_mod( 'x_stack' ) . '-cropped', NULL ) . '</div>';
        $image_output_class = 'with-image';
      }

      $output .= '<a class="x-recent-post' . $count . ' ' . $image_output_class . '" href="' . get_permalink( get_the_ID() ) . '" title="' . esc_attr( sprintf( __( 'Permalink to: "%s"', '__x__' ), the_title_attribute( 'echo=0' ) ) ) . '">'
                 . '<article id="post-' . get_the_ID() . '" class="' . implode( ' ', get_post_class() ) . '">'
                   . '<div class="entry-wrap">'
                     . $image_output
                     . '<div class="x-recent-posts-content">'
                       . '<h3 class="h-recent-posts">' . get_the_title() . '</h3>'
                       . '<span class="x-recent-posts-date">' . get_the_date() . '</span>'
                       . ( $enable_excerpt ? '<span class="x-recent-posts-excerpt">' . strip_tags( get_the_excerpt() ) . '</span>' : '' )
                     . '</div>'
                   . '</div>'
                 . '</article>'
               . '</a>';

    endwhile; endif; wp_reset_postdata();

  $output .= '</div>';

  return $output;
}

add_action('wp_head', 'change_recent_posts_to_v2');

function change_recent_posts_to_v2() {
	remove_shortcode( 'recent_posts' );
	add_shortcode( 'recent_posts', 'x_shortcode_recent_posts_v2code' );
}
