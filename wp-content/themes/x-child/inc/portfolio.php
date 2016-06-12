<?php

// Create link box

add_action( 'add_meta_boxes', 'add_portfolio_link_box' );

function add_portfolio_link_box() {
    add_meta_box(
        'portfolio_link', // ID, should be a string.
        'Link', // Meta Box Title.
        'portfolio_link_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function portfolio_link_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'portfolio_link_save_meta_box_data', 'portfolio_link_meta_box_nonce' );
	$linkValue = get_post_meta( $post->ID, 'portfolio_link', true );

	echo '<input type="text" id="portfolio_link" name="portfolio_link" style="width:100%;" value="' . esc_attr( $linkValue ) . '" />';
}

function portfolio_link_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['portfolio_link_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['portfolio_link_meta_box_nonce'], 'portfolio_link_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['portfolio_link'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['portfolio_link'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'portfolio_link', $my_data );
}
add_action( 'save_post', 'portfolio_link_save_meta_box_data' );
