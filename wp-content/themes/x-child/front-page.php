<?php

// =============================================================================
// VIEWS/INTEGRITY/TEMPLATE-BLANK-4.PHP (No Container | Header, Footer)
// -----------------------------------------------------------------------------
// A blank page for creating unique layouts.
// =============================================================================

?>

<?php get_header(); ?>

  <div class="x-main full" role="main">
    <div class="x-container max width">
        <section class="category-list">
          <?php
          $query = new WP_Query(
             array(
               'post_type' => 'x-portfolio'
             )
           );

           if ( $query->have_posts() ) {

    // Start looping over the query results.
    while ( $query->have_posts() ) {

        $query->the_post();

        // Contents of the queried post results go here.

    }

} ?>

          <article class="x-column x-sm x-1-3 category-1">
            <div class="x-promo man"><?php echo the_title(); ?></div>
            <a href="<?php echo the_permalink(); ?>">Read More</a>
          </article>


        </section>
    </div>





    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php x_get_view( 'global', '_content', 'the-content' ); ?>
      </article>

    <?php endwhile; ?>

  </div>

<?php get_footer(); ?>
