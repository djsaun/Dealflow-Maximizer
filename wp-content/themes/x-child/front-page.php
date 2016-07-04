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
    <div class="hero">
      <div class="x-container max width">
        <h1>Dealflow Maximizer</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur id rem nihil, blanditiis repellat atque ducimus rerum amet dolorum sunt.</p>
      </div>
    </div>

    <?php $args = array(
          "post_type" => 'event_alert',
          "posts_per_page" => -1,
          "orderby" => "menu_order",
          "order" => "ASC",
          'meta_query' => array(
           array(
             'key' => 'active',
             'value' => 'true',
             'compare' => '='
           )
         )
      );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post(); ?>

      <div class="active-event">
        <div class="x-container max width">
        <p><?php echo the_author_meta('first_name'); ?> will be at <?php echo the_title(); ?> in <?php echo get_post_meta($post->ID, $key="event_location", true);
            if((get_post_meta($post->ID, $key="event_end", true) != NULL)) { ?>
            from <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_start", true))); ?> to <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_end", true))); ?>.
          <?php  } else { ?>
            on <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_start", true))); ?>.
        <?php  }
           ?>
           Hope to see you there!
        </p>
        </div>
      </div>

    <?php endwhile; wp_reset_postdata(); ?>

      <section class="category-list">
        <div class="x-container max width">
          <?php
          $categoriesQuery = new WP_Query(
             array(
               'post_type' => 'x-portfolio',
               'order_by' => 'title',
               'order' => 'ASC',
               'tax_query'      => array(
                 array(
                   'taxonomy' => 'portfolio-category',
                   'field'    => 'slug',
                   'terms'    => 'industries',
                   'include_children' => false
                 )
               )
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
                      <div class="category-links">
                        <ul>

                        <?php
                          $categoryId = get_the_ID();
                          $category = get_the_title(get_the_ID());

                          $linksArgs = array(
                            'post_type' => 'x-portfolio',
                            'posts_per_page' => 3,
                            'tax_query'      => array(
                              array(
                                'taxonomy' => 'portfolio-category',
                                'field'    => 'slug',
                                'terms'    => $category
                              )
                            )
                          );

                          $linkQuery = new WP_Query($linksArgs);

                          if ($linkQuery->have_posts()) {
                            while ($linkQuery->have_posts()) {
                              $linkQuery->the_post();?>
                                <li>
                                  <a href="<?php echo get_post_meta( $post->ID, 'portfolio_link', true ); ?>" target="_blank"><?php echo get_the_title(); ?></a>
                                </li>
                      <?php }
                          }
                         ?>
                       </ul>
                      </div>
                      <a href="<?php echo the_permalink($categoryId); ?>" class="btn x-btn x-btn-flat x-btn-rounded x-btn-regular">Read More</a>
                    </div>
                  </div>
                </div>

          <?php  }

        }; wp_reset_postdata(); ?>
        </div> <!-- .x-container -->
    </section> <!-- .category-list -->

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
            <?php $catId = $post->ID; ?>
            <?php if (has_post_thumbnail( $post->ID ) ): ?>
             <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
           <?php endif; ?>
           <section class="featured-category" style="background-image: url('<?php echo $image[0]; ?>')">
            <div class="x-container max width">

            <h3 class="featured-category-title"><?php echo the_title(); ?> News</h3>

              <div class="x-column x-sm x-1-3 categories">
                <?php if (get_post_meta( $post->ID, 'category_widget', true )) { ?>
                <iframe src="<?php echo get_post_meta( $post->ID, 'category_widget', true ); ?>"></iframe>
                <?php } else { ?>

                  <a class="twitter-timeline"  href="https://twitter.com/djsaun/lists/<?php echo get_post_meta( $post->ID, 'category_twitter', true ); ?>" data-widget-id="739237287125344256"></a>
   <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                <?php   } ?>              </div>

              <div class="x-column x-sm x-1-3 categories">
              </div>

              <div class="x-column x-sm x-1-3 categories">
                <?php include("rss.php"); ?>
              </div>

              <?php if (get_post_meta( $catId, 'category_widget', true )) { ?>
                <div class="x-column x-sm x-1-1 categories graph">
                  <iframe src="<?php echo get_post_meta( $catId, 'category_widget', true ); ?>"></iframe>
                </div>
              <?php } ?>

            </div> <!-- .x-container -->
          </section> <!-- .featured-category -->

        <?php  }
              }
              else {
                if ( $dayQuery->have_posts() ) {

                 // Start looping over the query results.
                 while ( $dayQuery->have_posts() ) {

                 $dayQuery->the_post(); ?>

                 <?php $catId = $post->ID; ?>
                 <?php if (has_post_thumbnail( $post->ID ) ): ?>
                  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                <?php endif; ?>
             <section class="featured-category" style="background-image: url('<?php echo $image[0]; ?>')">

               <div class="x-container max width">

                 <h3 class="featured-category-title"><?php echo the_title(); ?> News</h3>

                   <div class="x-column x-sm x-1-3 categories">
                       <a class="twitter-timeline"  href="https://twitter.com/djsaun/lists/<?php echo get_post_meta( $post->ID, 'category_twitter', true ); ?>" data-widget-id="739237287125344256"></a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                   </div>

                   <div class="x-column x-sm x-1-3 categories">
                       test
                   </div>

                   <div class="x-column x-sm x-1-3 categories">
                     <?php include("rss.php"); ?>
                   </div>

                   <?php if (get_post_meta( $catId, 'category_widget', true )) { ?>
                     <div class="x-column x-sm x-1-1 categories graph">
                       <iframe src="<?php echo get_post_meta( $catId, 'category_widget', true ); ?>"></iframe>
                     </div>
                   <?php } ?>
                 </div> <!-- .x-container -->
               </section> <!-- .featured-category -->
                <?php  }
               }
              }
              wp_reset_postdata();
            }
          }?>

      <div class="dealflow-blog">
        <div class="x-container max width">
          <h3>Recent Posts</h3>
          <?php $postQuery = new WP_Query(
             array(
               'post_type' => 'post',
               'posts_per_page' => 2,
             )
           );

          if ( $postQuery->have_posts() ) {
           while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <?php echo the_content(); ?>
            </article>

          <?php endwhile;
        }; wp_reset_postdata(); ?>
        </div> <!-- .x-container -->
      </div> <!-- .dealflow-blog -->
    </div>


<?php get_footer(); ?>
