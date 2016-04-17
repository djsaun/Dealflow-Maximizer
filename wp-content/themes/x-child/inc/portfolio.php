<?php

// Create portfolio date box

add_action( 'add_meta_boxes', 'add_date_checkbox_box' );

function add_date_checkbox_box() {
    add_meta_box(
        'portfolio_date_checkbox', // ID, should be a string.
        'Date To Display', // Meta Box Title.
        'portfolio_date_checkbox_meta_box', // Your call back function, this is where your form field will go.
        'x-portfolio', // The post type you want this to show up on, can be post, page, or custom post type.
        'side', // The placement of your meta box, can be normal or side.
        'core' // The priority in which this will be displayed.
    );
}

function portfolio_date_checkbox_meta_box($post) {
  wp_nonce_field( 'portfolio_date_nonce', 'date_nonce' );
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


add_action( 'save_post', 'save_dates' );
    function save_dates( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( ( isset ( $_POST['portfolio_date_nonce'] ) ) && ( ! wp_verify_nonce( $_POST['portfolio_date_nonce'], plugin_basename( __FILE__ ) ) ) )
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
