<?php
add_shortcode('event_list', 'wp_event_manager_event_list');
function wp_event_manager_event_list() {
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/event-list.php';
    return ob_get_clean();
}
