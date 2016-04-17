<?php

// =============================================================================
// VIEWS/INTEGRITY/TEMPLATE-BLANK-4.PHP (No Container | Header, Footer)
// -----------------------------------------------------------------------------
// A blank page for creating unique layouts.
// =============================================================================

require_once('php/autoloader.php');
?>

<?php get_header(); ?>

  <div class="x-main full" role="main">
    <div class="x-container max width">
        <section class="category-list">
          <?php
          $categoriesQuery = new WP_Query(
             array(
               'post_type' => 'x-portfolio',
               'order_by' => 'menu-order',
               'order' => 'ASC'
             )
           );

           if ( $categoriesQuery->have_posts() ) {

    // Start looping over the query results.
    while ( $categoriesQuery->have_posts() ) {

        $categoriesQuery->the_post(); ?>

        <div class="x-column x-sm x-1-3 categories">
          <div class="x-promo man">
            <div class="x-promo-content">
              <h3><?php echo the_title(); ?></h3>
              <a href="<?php echo the_permalink(); ?>">Read More</a>
            </div>
          </div>
        </div>

  <?php  }

} ?>
      </section>

      <section class="featured-category">
        <?php $featuredCategoryQuery = new WP_Query(
           array(
             'post_type' => 'x-portfolio',
             'order_by' => 'menu-order',
             'order' => 'ASC',
             'posts_per_page' => 1
           )
         );

         echo jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")));?>
      </section>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php x_get_view( 'global', '_content', 'the-content' ); ?>
      </article>

    <?php endwhile; ?>

  </div>

<?php get_footer(); ?>
