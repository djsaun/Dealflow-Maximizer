<?php require_once('php/autoloader.php'); ?>

<?php get_header(); ?>

<?php $pageTitle = get_the_title();?>

<div class="hero" style="background-image: url('<?php echo the_post_thumbnail_url('full'); ?>')">
 <div class="x-container max width">
   <h1><?php echo the_title(); ?></h1>
   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur id rem nihil, blanditiis repellat atque ducimus rerum amet dolorum sunt.</p>
 </div>
</div>

<div class="x-main full" role="main">
  <div class="x-container max width">

    <section class="featured-category">

      <h3 class="featured-category-title"><?php echo $pageTitle; ?> News</h3>

        <div class="x-column x-sm x-1-3 categories">
          <a class="twitter-timeline"  href="https://twitter.com/djsaun/lists/<?php echo get_post_meta( $post->ID, 'category_twitter', true ); ?>" data-widget-id="739237287125344256"></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>        </div>

        <div class="x-column x-sm x-1-3 categories">
            test
        </div>

        <div class="x-column x-sm x-1-3 categories">
          <?php include("rss.php"); ?>
        </div>

    </section>

    <?php $category = get_posts('category_name='.strtolower($pageTitle).'');
    if ($category) :
    ?>

    <div class="dealflow-blog">
      <h3>Recent Posts</h3>
      <?php echo do_shortcode('[recent_posts type="post" category="'. strtolower($pageTitle) .'" enable_excerpt="true" count="3" orientation="horizontal"]'); ?>
    </div>

  <?php endif; wp_reset_postdata(); ?>
  </div>
</div>

<?php get_footer(); ?>
