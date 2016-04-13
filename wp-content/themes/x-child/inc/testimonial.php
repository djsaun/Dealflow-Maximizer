<?php

// Create event alert custom post type

add_action( 'init', 'create_testimonial' );
function create_testimonial() {
  register_post_type( 'testimonial',
    array(
      'labels' => array(
        'name' => __( 'Testimonials' ),
        'singular_name' => __( 'Testimonial' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array( 'title', 'editor' )
    )
  );
}

// Create attribution box

add_action( 'add_meta_boxes', 'add_dealflow_testimonial_box' );

function add_dealflow_testimonial_box() {
    add_meta_box(
        'testimonial_attribution', // ID, should be a string.
        'Attribution', // Meta Box Title.
        'testimonial_attribution_meta_box', // Your call back function, this is where your form field will go.
        'testimonial', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function testimonial_attribution_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'testimonial_attribution_save_meta_box_data', 'testimonial_attribution_meta_box_nonce' );
	$locationValue = get_post_meta( $post->ID, 'testimonial_attribution', true );

	echo '<input type="text" id="testimonial_attribution" name="testimonial_attribution" style="width:100%;" value="' . esc_attr( $locationValue ) . '" />';
}

function testimonial_attribution_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['testimonial_attribution_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['testimonial_attribution_meta_box_nonce'], 'testimonial_attribution_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['testimonial_attribution'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['testimonial_attribution'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'testimonial_attribution', $my_data );
}
add_action( 'save_post', 'testimonial_attribution_save_meta_box_data' );

// Featured meta box

add_action( 'add_meta_boxes', 'add_featured_testimonial' );

    function add_featured_testimonial( $post ) {
        add_meta_box(
            'featured_testimonial', // ID, should be a string.
            'Featured', // Meta Box Title.
            'featured_testimonial', // Your call back function, this is where your form field will go.
            'testimonial', // The post type you want this to show up on, can be post, page, or custom post type.
            'side', // The placement of your meta box, can be normal or side.
            'core' // The priority in which this will be displayed.
        );
}

function featured_testimonial($post) {
  wp_nonce_field( 'blog_featured_testimonial_nonce', 'featured_testimonial_nonce' );
  $checkboxMeta = get_post_meta( $post->ID );
  ?>

  <input type="checkbox" name="featured" id="featured" value="true" <?php if ( isset ( $checkboxMeta['featured'] ) ) checked( $checkboxMeta['featured'][0], 'true' ); ?> />Featured<br />

<?php }


add_action( 'save_post', 'save_featured_checkbox' );
    function save_featured_checkbox( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( ( isset ( $_POST['blog_featured_testimonial_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['blog_featured_testimonial_nonce'], plugin_basename( __FILE__ ) ) ) )
            return;
        if ( ( isset ( $_POST['post_type'] ) ) && ( 'page' == $_POST['post_type'] )  ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        //saves active value
        if( isset( $_POST[ 'featured' ] ) ) {
            update_post_meta( $post_id, 'featured', 'true' );
        } else {
            delete_post_meta( $post_id, 'featured');
        }
}
