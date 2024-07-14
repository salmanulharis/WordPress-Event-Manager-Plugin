<?php
/*
Plugin Name: Wordpress Event Manager Plugin
Plugin URI: http://example.com
Description: A custom plugin to manage events.
Version: 1.0
Author: Salmanul Haris
Author URI: http://example.com
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
include_once plugin_dir_path(__FILE__) . 'includes/admin.php';
include_once plugin_dir_path(__FILE__) . 'includes/post-types.php';
include_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
include_once plugin_dir_path(__FILE__) . 'includes/settings.php';

// Enqueue styles
add_action('wp_enqueue_scripts', 'wp_event_manager_enqueue_styles');
function wp_event_manager_enqueue_styles() {
    wp_enqueue_style('wp-event-manager-styles', plugin_dir_url(__FILE__) . 'assets/styles.css');
}

// Activation hook
register_activation_hook(__FILE__, 'wp_event_manager_activate');
function wp_event_manager_activate() {
    // Triggered when the plugin is activated
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'wp_event_manager_deactivate');
function wp_event_manager_deactivate() {
    // Triggered when the plugin is deactivated
    flush_rewrite_rules();
}

// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_event_manager_action_links');
function wp_event_manager_action_links($links) {
    $settings_link = '<a href="edit.php?post_type=event&page=event-settings">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
