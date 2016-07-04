<?php

// Create event alert custom post type

add_action( 'init', 'create_event' );
function create_event() {
  register_post_type( 'event_alert',
    array(
      'labels' => array(
        'name' => __( 'Event Alerts' ),
        'singular_name' => __( 'Event Alert' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array( 'title', 'author' )
    )
  );
}

// Create event location box

add_action( 'add_meta_boxes', 'add_event_location_box' );

function add_event_location_box() {
    add_meta_box(
        'event_location', // ID, should be a string.
        'Event Location', // Meta Box Title.
        'event_location_meta_box', // Your call back function, this is where your form field will go.
        'event_alert', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function event_location_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'event_location_save_meta_box_data', 'event_location_meta_box_nonce' );
	$locationValue = get_post_meta( $post->ID, 'event_location', true );

	echo '<input type="text" id="event_location" name="event_location" style="width:100%;" value="' . esc_attr( $locationValue ) . '" />';
}

function event_location_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['event_location_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['event_location_meta_box_nonce'], 'event_location_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['event_location'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['event_location'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'event_location', $my_data );
}
add_action( 'save_post', 'event_location_save_meta_box_data' );

// Create event start box

add_action( 'add_meta_boxes', 'add_event_start_box' );

function add_event_start_box() {
    add_meta_box(
        'event_start', // ID, should be a string.
        'Event Start Date', // Meta Box Title.
        'event_start_meta_box', // Your call back function, this is where your form field will go.
        'event_alert', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function event_start_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'event_start_save_meta_box_data', 'event_start_meta_box_nonce' );
	$startValue = get_post_meta( $post->ID, 'event_start', true );

	echo '<input type="date" id="event_start" name="event_start" style="width:100%;" value="' . esc_attr( $startValue ) . '" />';
}

function event_start_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['event_start_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['event_start_meta_box_nonce'], 'event_start_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['event_start'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['event_start'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'event_start', $my_data );
}
add_action( 'save_post', 'event_start_save_meta_box_data' );

// Create event start box

add_action( 'add_meta_boxes', 'add_event_end_box' );

function add_event_end_box() {
    add_meta_box(
        'event_end', // ID, should be a string.
        'Event End Date', // Meta Box Title.
        'event_end_meta_box', // Your call back function, this is where your form field will go.
        'event_alert', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function event_end_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'event_end_save_meta_box_data', 'event_end_meta_box_nonce' );
	$endValue = get_post_meta( $post->ID, 'event_end', true );

	echo '<input type="date" id="event_end" name="event_end" style="width:100%;" value="' . esc_attr( $endValue ) . '" />';
}

function event_end_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['event_end_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['event_end_meta_box_nonce'], 'event_end_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['event_end'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['event_end'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'event_end', $my_data );
}
add_action( 'save_post', 'event_end_save_meta_box_data' );

// Featured meta box

add_action( 'add_meta_boxes', 'add_active_event' );

    function add_active_event( $post ) {
        add_meta_box(
            'active_event', // ID, should be a string.
            'Activate Event', // Meta Box Title.
            'active_event', // Your call back function, this is where your form field will go.
            'event_alert', // The post type you want this to show up on, can be post, page, or custom post type.
            'side', // The placement of your meta box, can be normal or side.
            'core' // The priority in which this will be displayed.
        );
}

function active_event($post) {
  wp_nonce_field( 'blog_active_event_nonce', 'active_event_nonce' );
  $checkboxMeta = get_post_meta( $post->ID );
  ?>

  <input type="checkbox" name="active" id="active" value="true" <?php if ( isset ( $checkboxMeta['active'] ) ) checked( $checkboxMeta['active'][0], 'true' ); ?> />Active<br />

<?php }


add_action( 'save_post', 'save_active_checkbox' );
    function save_active_checkbox( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( ( isset ( $_POST['blog_active_event_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['blog_active_event_nonce'], plugin_basename( __FILE__ ) ) ) )
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
        if( isset( $_POST[ 'active' ] ) ) {
            update_post_meta( $post_id, 'active', 'true' );
        } else {
            delete_post_meta( $post_id, 'active');
        }
}
