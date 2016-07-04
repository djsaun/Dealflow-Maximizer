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

// Create category date box

add_action( 'add_meta_boxes', 'add_category_date_checkbox_box' );

function add_category_date_checkbox_box() {
    add_meta_box(
        'category_date_checkbox', // ID, should be a string.
        'Date To Display', // Meta Box Title.
        'category_date_checkbox_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'side', // The placement of your meta box, can be normal or side.
        'core' // The priority in which this will be displayed.
    );
}

function category_date_checkbox_meta_box($post) {
  wp_nonce_field( 'category_date_nonce', 'date_nonce' );
  $checkboxMeta = get_post_meta( $post->ID );
  $priorityDateValue = get_post_meta( $post->ID, 'priority_date', true );
  ?>

  <input type="checkbox" name="sunday" id="sunday" value="checked" <?php if ( isset ( $checkboxMeta['sunday'] ) ) checked( $checkboxMeta['sunday'][0], 'checked' ); ?> /><label for="sunday">Sunday</label><br />
  <input type="checkbox" name="monday" id="monday" value="checked" <?php if ( isset ( $checkboxMeta['monday'] ) ) checked( $checkboxMeta['monday'][0], 'checked' ); ?> /><label for="monday">Monday</label><br />
  <input type="checkbox" name="tuesday" id="tuesday" value="checked" <?php if ( isset ( $checkboxMeta['tuesday'] ) ) checked( $checkboxMeta['tuesday'][0], 'checked' ); ?> /><label for="tuesday">Tuesday</label><br />
  <input type="checkbox" name="wednesday" id="wednesday" value="checked" <?php if ( isset ( $checkboxMeta['wednesday'] ) ) checked( $checkboxMeta['wednesday'][0], 'checked' ); ?> /><label for="wednesday">Wednesday</label><br />
  <input type="checkbox" name="thursday" id="thursday" value="checked" <?php if ( isset ( $checkboxMeta['thursday'] ) ) checked( $checkboxMeta['thursday'][0], 'checked' ); ?> /><label for="thursday">Thursday</label><br />
  <input type="checkbox" name="friday" id="friday" value="checked" <?php if ( isset ( $checkboxMeta['friday'] ) ) checked( $checkboxMeta['friday'][0], 'checked' ); ?> /><label for="friday">Friday</label><br />
  <input type="checkbox" name="saturday" id="saturday" value="checked" <?php if ( isset ( $checkboxMeta['saturday'] ) ) checked( $checkboxMeta['saturday'][0], 'checked' ); ?> /><label for="saturday">Saturday</label><br />
  <br/>
  <label for="priority_date">Specific Date</label><br/><input type="date" id="priority_date" name="priority_date" value="<?php echo $priorityDateValue; ?>">
<?php }


add_action( 'save_post', 'save_category_dates' );
    function save_category_dates( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( ( isset ( $_POST['category_date_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['category_date_nonce'], plugin_basename( __FILE__ ) ) ) )
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

        //saves sunday's value
        if( isset( $_POST[ 'sunday' ] ) ) {
            update_post_meta( $post_id, 'sunday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'sunday');
        }

        //saves monday's value
        if( isset( $_POST[ 'monday' ] ) ) {
            update_post_meta( $post_id, 'monday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'monday');
        }

        //saves tuesday's value
        if( isset( $_POST[ 'tuesday' ] ) ) {
            update_post_meta( $post_id, 'tuesday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'tuesday');
        }

        //saves wednesday's value
        if( isset( $_POST[ 'wednesday' ] ) ) {
            update_post_meta( $post_id, 'wednesday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'wednesday');
        }

        //saves thursday's value
        if( isset( $_POST[ 'thursday' ] ) ) {
            update_post_meta( $post_id, 'thursday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'thursday');
        }

        //saves friday's value
        if( isset( $_POST[ 'friday' ] ) ) {
            update_post_meta( $post_id, 'friday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'friday');
        }

        //saves saturday's value
        if( isset( $_POST[ 'saturday' ] ) ) {
            update_post_meta( $post_id, 'saturday', 'checked' );
        } else {
            delete_post_meta( $post_id, 'saturday');
        }

        // Make sure that it is set.
        if ( ! isset( $_POST['priority_date'] ) ) {
          return;
        }

        // Sanitize user input.
        $priorityDate = sanitize_text_field( $_POST['priority_date'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, 'priority_date', $priorityDate );

}

// Create widget box

add_action( 'add_meta_boxes', 'add_featured_widget_box' );

function add_featured_widget_box() {
    add_meta_box(
        'category_widget', // ID, should be a string.
        'Featured Widget', // Meta Box Title.
        'category_widget_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function category_widget_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'category_widget_save_meta_box_data', 'category_widget_meta_box_nonce' );
	$widgetValue = get_post_meta( $post->ID, 'category_widget', true );

	echo '<input type="text" id="category_widget" name="category_widget" style="width:100%;" value="' . esc_attr( $widgetValue ) . '" />';
}

function category_widget_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['category_widget_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['category_widget_meta_box_nonce'], 'category_widget_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['category_widget'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['category_widget'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'category_widget', $my_data );
}
add_action( 'save_post', 'category_widget_save_meta_box_data' );

// Create twitter box

add_action( 'add_meta_boxes', 'add_featured_twitter_box' );

function add_featured_twitter_box() {
    add_meta_box(
        'category_twitter', // ID, should be a string.
        'Featured Twitter Feed', // Meta Box Title.
        'category_twitter_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function category_twitter_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'category_twitter_save_meta_box_data', 'category_twitter_meta_box_nonce' );
	$twitterValue = get_post_meta( $post->ID, 'category_twitter', true );

	echo '<input type="text" id="category_twitter" name="category_twitter" style="width:100%;" value="' . esc_attr( $twitterValue ) . '" />';
}

function category_twitter_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['category_twitter_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['category_twitter_meta_box_nonce'], 'category_twitter_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['category_twitter'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['category_twitter'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'category_twitter', $my_data );
}
add_action( 'save_post', 'category_twitter_save_meta_box_data' );

// Create rss feed select box

add_action( 'add_meta_boxes', 'add_rss_select_box' );

function add_rss_select_box() {
    add_meta_box(
        'category_rss', // ID, should be a string.
        'RSS Feed', // Meta Box Title.
        'category_rss_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function category_rss_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'category_rss_save_meta_box_data', 'category_rss_meta_box_nonce' );
  $values = get_post_custom( $post->ID );
  $selected = isset( $values['category_rss'] ) ? esc_attr( $values['category_rss'][0] ) : ''; ?>

  <select id="category_rss" name="category_rss">
      <option value=""></option>

      <?php
      $feeds = get_posts(array(
          'post_type' => 'rss_feed',
          'orderby' => 'title',
          'order' => 'ASC',
          'posts_per_page' => -1
      ));

      foreach ($feeds as $feed) {
        $feedId = $feed->ID;
        $feedName = get_the_title($feedId);

        $is_selected = ($feedId == $selected) ? 'selected="selected"' : '';
        echo '<option value="'.$feedId.'" '.$is_selected.'>'.$feedName.'</option>';
      }
      wp_reset_postdata();
       ?>
    </select>
<?php }

function category_rss_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['category_rss_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['category_rss_meta_box_nonce'], 'category_rss_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['category_rss'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['category_rss'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'category_rss', $my_data );
}
add_action( 'save_post', 'category_rss_save_meta_box_data' );

// Create graph box

add_action( 'add_meta_boxes', 'add_featured_graph_box' );

function add_featured_graph_box() {
    add_meta_box(
        'category_graph', // ID, should be a string.
        'Featured Graph', // Meta Box Title.
        'category_graph_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'normal', // The placement of your meta box, can be normal or side.
        'low' // The priority in which this will be displayed.
    );
}

function category_graph_meta_box( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'category_graph_save_meta_box_data', 'category_graph_meta_box_nonce' );
	$graphValue = get_post_meta( $post->ID, 'category_graph', true );

	echo '<input type="text" id="category_graph" name="category_graph" style="width:100%;" value="' . esc_attr( $graphValue ) . '" />';
}

function category_graph_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['category_graph_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['category_graph_meta_box_nonce'], 'category_graph_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['category_graph'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['category_graph'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'category_graph', $my_data );
}
add_action( 'save_post', 'category_graph_save_meta_box_data' );
