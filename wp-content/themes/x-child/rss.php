<?php
$args = array( 'p' => get_post_meta( $post->ID, 'category_rss', true ), 'post_type' => 'rss_feed' );

$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
  $rss = get_post_meta( get_the_ID(), 'rss_feed_input', true );

  $max_items_per_feed = 4;  // this pulls the top 4 articles from each feed
$max_items_total = 4;  // this caps the total articles
$feed = new SimplePie();
$feed->set_feed_url(explode(',',$rss));

// limit the number of items
$feed->set_item_limit($max_items_per_feed);
$feed->enable_cache(true);
$feed->set_cache_duration(43200);  // refresh cache twice a day - 12 hrs

// Run SimplePie.
$success = $feed->init();

  // Run SimplePie.
  $feed->init();

  // This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
  $feed->handle_content_type();

  foreach ($feed->get_items(0, 4) as $item):
  ?>

    <div class="item">
      <h5><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h5>
      <p><?php echo $item->get_description(); ?></p>
      <p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
    </div>

  <?php endforeach;

endwhile;
 ?>
