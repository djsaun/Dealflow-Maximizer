<?php

// Make sure SimplePie is included. You may need to change this to match the location of autoloader.php
// For 1.0-1.2:

#require_once('../simplepie.inc');
// For 1.3+:


// We'll process this feed with all of the default options.
$feed = new SimplePie();

// Set which feed to process.
$feed->set_feed_url(array(
  "http://www.penews.com/feeds/top-stories.xml",
  "http://www.penews.com/feeds/people-moves.xml",
  "http://www.pionline.com/rss/topics/private-equity",
  "https://www.thetrustedinsight.com/rss-directory-investment-trends/private-equity/2016/"
));

// Run SimplePie.
$feed->init();

// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();

// Let's begin our XHTML webpage code.  The DOCTYPE is supposed to be the very first thing, so we'll keep it on the same line as the closing-PHP tag.
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"

<html xmlns
<head>
	<title>Sample SimplePie Page</title>
	<meta
</head>
<body>

	<div class="header">
		<h1><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h1>
		<p><?php echo $feed->get_description(); ?></p>
	</div>

  <?php
  $args = array( 'post_type' => 'rss_feed', 'posts_per_page' => 10 );

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
    // $feed->init();

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

</body>
</html>
