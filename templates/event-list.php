<?php
$events = get_posts(array(
    'post_type' => 'event',
    'post_status' => 'publish',
    'numberposts' => -1,
));

if ($events) {
    echo '<div class="wp-event-manager-list">';
    foreach ($events as $event) {
        $event_date = get_post_meta($event->ID, '_event_date', true);
        $event_location = get_post_meta($event->ID, '_event_location', true);
        $event_organizer = get_post_meta($event->ID, '_event_organizer', true);

        echo '<div class="wp-event-manager-item">';
        echo '<h2>' . esc_html($event->post_title) . '</h2>';
        echo '<p><strong>Date:</strong> ' . esc_html($event_date) . '</p>';
        echo '<p><strong>Location:</strong> ' . esc_html($event_location) . '</p>';
        echo '<p><strong>Organizer:</strong> ' . esc_html($event_organizer) . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>No upcoming events found.</p>';
}
?>
