<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 *
 * @package ThinkUpThemes
 */

get_header(); ?>
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

      <div class="active_event">
        <p>I will be at <?php echo the_title(); ?> in <?php echo get_post_meta($post->ID, $key="event_location", true);
            if((get_post_meta($post->ID, $key="event_end", true) != NULL)) { ?>
            from <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_start", true))); ?> to <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_end", true))); ?>.
          <?php  } else { ?>
            on <?php echo date('F d, Y', strtotime(get_post_meta($post->ID, $key="event_start", true))); ?>.
        <?php  }
           ?>
           Hope to see you there!
        </p>
      </div>

        <?php endwhile; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php /* Add comments */  thinkup_input_allowcomments(); ?>

			<?php endwhile; wp_reset_query(); ?>

<?php get_footer(); ?>
