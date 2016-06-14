<?php get_header(); ?>

  <div class="x-container max width offset">
    <div class="<?php x_main_content_class(); ?>" role="main">

      <?php while ( have_posts() ) : the_post(); ?>
        $disable_page_title = get_post_meta( get_the_ID(), '_x_entry_disable_page_title', true );

        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <div class="entry-featured">
            <?php x_featured_image(); ?>
          </div>
          <div class="entry-wrap">
            <?php if ( is_singular() ) : ?>
              <?php if ( $disable_page_title != 'on' ) : ?>
              <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
              </header>
              <?php endif; ?>
            <?php else : ?>
            <header class="entry-header">
              <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to: "%s"', '__x__' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php x_the_alternate_title(); ?></a>
              </h2>
            </header>
            <?php endif; ?>
            <?php x_get_view( 'global', '_content' ); ?>
          </div>
        </article>
      <?php endwhile; ?>

    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>
