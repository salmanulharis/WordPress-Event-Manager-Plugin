# WordPress Event Manager Plugin

## Overview
The **WordPress Event Manager Plugin** is a custom plugin designed to manage events within a WordPress site. It provides features for creating, editing, and displaying events, along with custom settings to manage event-specific options.

## Features

1. **Custom Post Type: Events**
    - Registers a new post type called "Events".
    - Supports title, editor, and thumbnail.
    - Custom menu icon (dashicons-calendar).
    - Labels for the admin menu and post editor are customized for clarity.

2. **Admin Menu Integration**
    - Adds a main menu item called "Event Manager" in the WordPress admin dashboard.
    - Provides a settings page under the "Events" menu.

3. **Settings Page**
    - Custom settings page accessible under "Events" > "Settings".
    - Allows configuration of event-specific options.
    - Settings page includes standard WordPress options management functionality.

4. **Plugin Activation and Deactivation Hooks**
    - Activation hook to flush rewrite rules when the plugin is activated.
    - Deactivation hook to flush rewrite rules when the plugin is deactivated.

5. **Styles Enqueue**
    - Enqueues a custom stylesheet (`styles.css`) for front-end display of events.

6. **Custom Action Links**
    - Adds a "Settings" link on the plugin page in the WordPress admin.
    - "Settings" link navigates directly to the event settings page.
    - Deactivation option remains available on the plugin page.

## File Structure

- `wp-event-manager.php`: Main plugin file, includes activation/deactivation hooks, enqueues styles, and adds custom action links.
- `includes/admin.php`: Optional admin-specific functionalities (can be further extended).
- `includes/post-types.php`: Registers the custom post type and settings page.
- `includes/meta-boxes.php`: Handles meta boxes (additional custom fields) for the event post type.
- `includes/shortcodes.php`: Registers shortcodes for displaying events on the front-end.
- `includes/settings.php`: Manages the plugin settings and options.
- `templates/event-list.php`: Template for displaying a list of events.
- `assets/styles.css`: Custom styles for front-end display.

## Detailed Functionality

### 1. Custom Post Type: Events
The plugin registers a custom post type `event` with specific labels and supports. The `register_post_type` function in `post-types.php` handles this.

```php
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
```

### 2. Admin Menu Integration
The main plugin file (`wp-event-manager.php`) and `post-types.php` ensure the settings page is added under the custom post type menu. Additionally, a "Settings" link is added to the plugin action links.

```php
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

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_event_manager_action_links');

function wp_event_manager_action_links($links) {
    $settings_link = '<a href="edit.php?post_type=event&page=event-settings">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
```

### 3. Activation and Deactivation Hooks
Flushes rewrite rules on activation and deactivation to ensure custom post type rules are registered properly.

```php
register_activation_hook(__FILE__, 'wp_event_manager_activate');
function wp_event_manager_activate() {
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'wp_event_manager_deactivate');
function wp_event_manager_deactivate() {
    flush_rewrite_rules();
}
```

### 4. Enqueue Styles
Enqueues a custom stylesheet for front-end display.

```php
add_action('wp_enqueue_scripts', 'wp_event_manager_enqueue_styles');

function wp_event_manager_enqueue_styles() {
    wp_enqueue_style('wp-event-manager-styles', plugin_dir_url(__FILE__) . 'assets/styles.css');
}
```

## Conclusion
The WordPress Event Manager Plugin is designed to provide a simple and efficient way to manage events within WordPress, with features that integrate seamlessly into the WordPress admin interface and provide custom settings for enhanced functionality.

