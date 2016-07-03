<?php require_once('php/autoloader.php'); ?>

<?php get_header(); ?>

<div class="x-main full" role="main">
  <div class="x-container max width">

    <section class="featured-category">
      <?php
      date_default_timezone_set('America/Los_Angeles');

      $timezone = date_default_timezone_get();
      $dayOfWeek = date("l");
      $dayOfWeek = strtolower($dayOfWeek);
      $currentDate = date("Y-m-d");

      $featuredCategoryQuery = new WP_Query(
         array(
           'post_type' => 'category',
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
             'post_type' => 'category',
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
              'post_type' => 'category',
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
              <iframe src="<?php echo get_post_meta( $post->ID, 'category_widget', true ); ?>"></iframe>
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
           <?php if (get_post_meta( $post->ID, 'category_widget', true )) { ?>
           <iframe src="<?php echo get_post_meta( $post->ID, 'category_widget', true ); ?>"></iframe>
           <?php } else { ?>

             <a class="twitter-timeline"  href="https://twitter.com/djsaun/lists/<?php echo get_post_meta( $post->ID, 'category_twitter', true ); ?>" data-widget-id="739237287125344256">Tweets from https://twitter.com/djsaun/lists/sample-list</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

           <?php   } ?>
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
    wp_reset_postdata();
  }
}?>
    </section>
    <div class="dealflow-blog">
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
    } ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
