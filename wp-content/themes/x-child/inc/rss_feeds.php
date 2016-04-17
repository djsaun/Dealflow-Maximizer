<?php

// Create rss feed custom post type

add_action( 'init', 'create_rss_feed' );
function create_rss_feed() {
  register_post_type( 'rss_feed',
    array(
      'labels' => array(
        'name' => __( 'RSS Feeds' ),
        'singular_name' => __( 'RSS Feed' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array( 'title' )
    )
  );
}

// Create rss feed input box

add_action( 'add_meta_boxes', 'add_rss_feed_input_box' );

function add_rss_feed_input_box() {
    add_meta_box(
        'rss_feed_input', // ID, should be a string.
        'RSS Feeds', // Meta Box Title.
        'rss_feed_input_meta_box', // Your call back function, this is where your form field will go.
        'rss_feed', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function rss_feed_input_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'rss_feed_save_meta_box_data', 'rss_feed_meta_box_nonce' );
	$rssFeedValue = get_post_meta( $post->ID, 'rss_feed_input', true );

	echo '<textarea id="rss_feed_input" name="rss_feed_input" style="width:100%;" rows="10">' . $rssFeedValue . '</textarea>';
}

function rss_feed_input_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['rss_feed_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['rss_feed_meta_box_nonce'], 'rss_feed_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['rss_feed_input'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['rss_feed_input'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'rss_feed_input', $my_data );
}
add_action( 'save_post', 'rss_feed_input_save_meta_box_data' );
