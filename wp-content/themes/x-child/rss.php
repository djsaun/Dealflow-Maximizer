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
