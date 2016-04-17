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
        <?php
        $dayOfWeek = jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 1 );
        $dayOfWeek = strtolower($dayOfWeek);
        echo get_post_meta( $post->ID, 'rss_feed_input', true );
        $featuredCategoryQuery = new WP_Query(
           array(
             'post_type' => 'x-portfolio',
             'order_by' => 'menu-order',
             'order' => 'ASC',
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

         if ( $featuredCategoryQuery->have_posts() ) {

          // Start looping over the query results.
          while ( $featuredCategoryQuery->have_posts() ) {

          $featuredCategoryQuery->the_post(); ?>

            <h3 class="featured-category-title"><?php echo the_title(); ?> News</h3>

              <div class="x-column x-sm x-1-3 categories">
                <!-- <iframe style=”border: 1px solid #333333; overflow: hidden; width: 190px; height: 490px;” src=”https://research.stlouisfed.org/fred-glance-widget.php” height=”240″ width=”320″ frameborder”0″ scrolling=”no”></iframe> -->
                <iframe src="<?php echo get_post_meta( $post->ID, 'portfolio_widget', true ); ?>"></iframe>
              </div>

              <div class="x-column x-sm x-1-3 categories">
                  test
              </div>

              <div class="x-column x-sm x-1-3 categories">
                <?php
                $args = array( 'post_type' => 'rss_feed' );

                $loop = new WP_Query( $args );
                while ( $loop->have_posts() ) : $loop->the_post();
                  $rss = get_post_meta( get_the_ID(), 'rss_feed_input', true );
                  $feed = new SimplePie();

                  // Set which feed to process.
                  $feed->set_feed_url(explode(',',$rss));
                  $feed->enable_cache(true);
                  $feed->set_stupidly_fast(true);
                  $feed->enable_order_by_date(true);
                  // Run SimplePie.
                  $feed->init();

                  // This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
                  $feed->handle_content_type();

                  foreach ($feed->get_items(0, 5) as $item):
                  ?>

                    <div class="item">
                      <h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
                      <p><?php echo $item->get_description(); ?></p>
                      <p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
                    </div>

                  <?php endforeach;

                endwhile;
                 ?>

                <?php
                /*
                Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
                */
                foreach ($feed->get_items() as $item):
                ?>

                  <div class="item">
                    <h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
                    <p><?php echo $item->get_description(); ?></p>
                    <p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
                  </div>

                <?php endforeach; ?>
              </div>

        <?php  }

        } ?>
      </section>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php x_get_view( 'global', '_content', 'the-content' ); ?>
      </article>

    <?php endwhile; ?>

  </div>

<?php get_footer(); ?>
