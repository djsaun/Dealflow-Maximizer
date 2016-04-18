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
                      <h4><?php echo the_title(); ?></h4>
                      <a href="<?php echo the_permalink(); ?>">Read More</a>
                    </div>
                  </div>
                </div>

          <?php  }

          } ?>
      </section>

      <section class="featured-category">
        <?php
        date_default_timezone_set('America/Los_Angeles');

        $timezone = date_default_timezone_get();
        $dayOfWeek = date("l");
        $dayOfWeek = strtolower($dayOfWeek);
        $currentDate = date("Y-m-d");

        $featuredCategoryQuery = new WP_Query(
           array(
             'post_type' => 'x-portfolio',
             'order_by' => 'menu-order',
             'order' => 'ASC',
             'posts_per_page' => 1
           )
         );

         if ( $featuredCategoryQuery->have_posts() ) {

          // Start looping over the query results.
          while ( $featuredCategoryQuery->have_posts() ) {

          $featuredCategoryQuery->the_post();

          $dateQuery = new WP_Query(
             array(
               'post_type' => 'x-portfolio',
               'posts_per_page' => 1,
               'meta_query' => array(
                 'relation' => 'AND',
                  array(
                    'key' => 'priority_date',
                    'compare' => 'EXISTS'
                  ),
                  array(
                    'key' => 'priority_date',
                    'value' => $currentDate,
                    'compare' => '='
                  )
                )
             )
           );

           $dayQuery = new WP_Query(
              array(
                'post_type' => 'x-portfolio',
                'posts_per_page' => 1,
                'meta_query' => array(
                   array(
                     'key' => $dayOfWeek,
                     'value' => 'checked',
                     'compare' => '='
                   )
                 )
              )
            );

           if ( $dateQuery->have_posts() ) {

            // Start looping over the query results.
            while ( $dateQuery->have_posts() ) {

            $dateQuery->the_post(); ?>

            <h3 class="featured-category-title"><?php echo the_title(); ?> News</h3>

              <div class="x-column x-sm x-1-3 categories">
                <!-- <iframe style=”border: 1px solid #333333; overflow: hidden; width: 190px; height: 490px;” src=”https://research.stlouisfed.org/fred-glance-widget.php” height=”240″ width=”320″ frameborder”0″ scrolling=”no”></iframe> -->
                <iframe src="<?php echo get_post_meta( $post->ID, 'portfolio_widget', true ); ?>"></iframe>
              </div>

              <div class="x-column x-sm x-1-3 categories">
                  test
              </div>

              <div class="x-column x-sm x-1-3 categories">
                <?php include("rss.php"); ?>
              </div>

        <?php  }

      }
      else {
        if ( $dayQuery->have_posts() ) {

         // Start looping over the query results.
         while ( $dayQuery->have_posts() ) {

         $dayQuery->the_post(); ?>

         <h3 class="featured-category-title"><?php echo the_title(); ?> News</h3>

           <div class="x-column x-sm x-1-3 categories">
             <!-- <iframe style=”border: 1px solid #333333; overflow: hidden; width: 190px; height: 490px;” src=”https://research.stlouisfed.org/fred-glance-widget.php” height=”240″ width=”320″ frameborder”0″ scrolling=”no”></iframe> -->
             <iframe src="<?php echo get_post_meta( $post->ID, 'portfolio_widget', true ); ?>"></iframe>
           </div>

           <div class="x-column x-sm x-1-3 categories">
               test
           </div>

           <div class="x-column x-sm x-1-3 categories">
             <?php include("rss.php"); ?>
           </div>
        <?php  }
       }
      }
    }
  }?>
      </section>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php x_get_view( 'global', '_content', 'the-content' ); ?>
      </article>

    <?php endwhile; ?>

  </div>

<?php get_footer(); ?>
