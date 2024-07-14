<?php

// Add meta boxes to the 'event' custom post type
add_action('add_meta_boxes', 'wp_event_manager_add_meta_boxes');
function wp_event_manager_add_meta_boxes() {
    add_meta_box('event_details', 'Event Details', 'wp_event_manager_meta_box_callback', 'event', 'normal', 'high');
}

// Callback function to display content inside the meta box
function wp_event_manager_meta_box_callback($post) {
    wp_nonce_field('wp_event_manager_save_meta_box_data', 'wp_event_manager_meta_box_nonce');
    
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    $event_organizer = get_post_meta($post->ID, '_event_organizer', true);

    echo '<label for="event_date">Date</label>';
    echo '<input type="date" id="event_date" name="event_date" value="' . esc_attr($event_date) . '" size="25" />';

    echo '<label for="event_location">Location</label>';
    echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr($event_location) . '" size="25" />';

    echo '<label for="event_organizer">Organizer</label>';
    echo '<input type="text" id="event_organizer" name="event_organizer" value="' . esc_attr($event_organizer) . '" size="25" />';
}

// Save meta box data when the post is saved or updated
add_action('save_post', 'wp_event_manager_save_meta_box_data');
function wp_event_manager_save_meta_box_data($post_id) {
    if (!isset($_POST['wp_event_manager_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['wp_event_manager_meta_box_nonce'], 'wp_event_manager_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
    if (isset($_POST['event_organizer'])) {
        update_post_meta($post_id, '_event_organizer', sanitize_text_field($_POST['event_organizer']));
    }
}


//Modify the Columns in the Custom Post Type Listing
add_filter('manage_event_posts_columns', 'wp_event_manager_columns_head');
function wp_event_manager_columns_head($columns) {
    $columns['event_date'] = 'Date';
    $columns['event_location'] = 'Location';
    $columns['event_organizer'] = 'Organizer';
    return $columns;
}

//Display Meta Box Values in Custom Columns
add_action('manage_event_posts_custom_column', 'wp_event_manager_columns_content', 10, 2);
function wp_event_manager_columns_content($column, $post_id) {
    switch ($column) {
        case 'event_date':
            echo get_post_meta($post_id, '_event_date', true);
            break;
        case 'event_location':
            echo get_post_meta($post_id, '_event_location', true);
            break;
        case 'event_organizer':
            echo get_post_meta($post_id, '_event_organizer', true);
            break;
        default:
            break;
    }
}

//Make Columns Sortable
add_filter('manage_edit-event_sortable_columns', 'wp_event_manager_sortable_columns');
function wp_event_manager_sortable_columns($columns) {
    $columns['event_date'] = '_event_date';
    return $columns;
}