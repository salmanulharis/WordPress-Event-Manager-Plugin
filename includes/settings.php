<?php

// Hook to initialize admin settings and fields
add_action('admin_init', 'wp_event_manager_settings');
function wp_event_manager_settings() {
    register_setting('wp_event_manager_options_group', 'wp_event_manager_settings');
    add_settings_section('wp_event_manager_main_section', 'Main Settings', null, 'wp_event_manager');
    add_settings_field('default_event_location', 'Default Event Location', 'wp_event_manager_default_event_location', 'wp_event_manager', 'wp_event_manager_main_section');
}

// Callback to display the 'Default Event Location' input field
function wp_event_manager_default_event_location() {
    $options = get_option('wp_event_manager_settings');
    ?>
    <input type="text" name="wp_event_manager_settings[default_event_location]" value="<?php echo isset($options['default_event_location']) ? esc_attr($options['default_event_location']) : ''; ?>" />
    <?php
}
