<?php
// Register Custom Post Type
add_action('init', 'wp_event_manager_register_post_type');
function wp_event_manager_register_post_type() {
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'menu_name' => 'Events',
        'all_items' => 'All Events',
        'add_new' => 'Add New Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'No events found',
        'not_found_in_trash' => 'No events found in Trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-calendar',
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
    );

    register_post_type('event', $args);
}

// Add settings page under custom post type menu
add_action('admin_menu', 'wp_event_manager_settings_page');
function wp_event_manager_settings_page() {
    add_submenu_page(
        'edit.php?post_type=event',
        'Event Settings',
        'Settings',
        'manage_options',
        'event-settings',
        'wp_event_manager_settings_page_content'
    );
}

function wp_event_manager_settings_page_content() {
    ?>
    <div class="wrap">
        <h1>Event Manager Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_event_manager_options_group');
            do_settings_sections('wp_event_manager');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}



