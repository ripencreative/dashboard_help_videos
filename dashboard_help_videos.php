<?php
/*
Plugin Name: WP Dashboard Help Videos
Plugin URI: https://github.com/ripencreative/
Description: WP Help Videos for Dashboards
Version: 1.0
License: GPL
Author: Brian Morris
Author URI: https://ripencreative.ca
GitHub Plugin URI: https://github.com/ripencreative/dashboard_help_videos
GitHub Branch: master
*/

define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Installing TGM Plugin Activation to require the GitHub Updater plugin to keep this plugin up to date.
require_once( MY_PLUGIN_PATH . '/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'mytheme_require_plugins' );

function mytheme_require_plugins() {

    $plugins = array(
    array(
        'name'               => 'GitHub Plugin Updates',
        'slug'               => 'github-updater',
        'source'             => 'https://github.com/afragen/github-updater/archive/develop.zip',
        'required'           => false, // this plugin is suggested
        'external_url'       => 'https://github.com/afragen/github-updater/', // page of my plugin
        'force_deactivation' => false, // do not deactivate this plugin when the user switches to another theme
    )
);
    $config = array(
    'menu'         => 'mytheme-install-required-plugins', // menu slug
    'has_notices'  => true, // Show admin notices
    'dismissable'  => false, // the notices are NOT dismissable
    'dismiss_msg'  => 'If you would like to stay up to date with the latest videos available, please install this plugin', // this message will be output at top of nag
    'is_automatic' => true, // automatically activate plugins after installation
);

    tgmpa( $plugins, $config );

}

// Load Custom Stylesheet
// wp_register_style() example
define( 'WPDHV_CSS_PATH' , str_replace( site_url().'/', '', plugin_dir_url( __FILE__ ) ).'css/' );
add_action( 'admin_enqueue_scripts', 'wpdhv_add_link_tag_to_head' );

function wpdhv_add_link_tag_to_head() {
    wp_enqueue_style( 'wpdhv-style', '/'.WPDHV_CSS_PATH.'style.css', array(), null, 'all' );
}

/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Help Videos', 'textdomain' ),
        'Help Videos',
        'manage_options',
        'dashboard_help_videos/videos.php',
        '',
        plugins_url( 'dashboard_help_videos/images/icon.png' ),
        3
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

// Dashboard Submenu
function wpdocs_register_my_custom_submenu_dashboard() {
    add_submenu_page('dashboard_help_videos/videos.php','Dashboard Menu', 'Dashboard Menu','manage_options', 'dashboard_help_videos', 'create_submenu_dashboard');
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_submenu_dashboard' );

// Posts Submenu
function wpdocs_register_my_custom_submenu_posts() {
    add_submenu_page('dashboard_help_videos/videos.php','Posts Menu', 'Posts Menu','manage_options', 'posts_help_videos', 'create_submenu_posts');
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_submenu_posts' );

// Include and display dashboard videos menu item
function create_submenu_dashboard(){
    include( MY_PLUGIN_PATH . 'menu/dashboard.php');
}

// Include and display posts videos menu item
function create_submenu_posts(){
    include( MY_PLUGIN_PATH . 'menu/posts.php');
}

// RSS Feed Widget for latest WordPress news

add_action('wp_dashboard_setup', 'organicweb_dashboard_widgets');

function organicweb_dashboard_widgets() {
// CHANGE 'OrganicWeb News' BELOW TO THE TITLE OF YOUR WIDGET
wp_add_dashboard_widget( 'dashboard_custom_feed', 'WordPress News', 'organicweb_custom_feed_output' );

function organicweb_custom_feed_output() {
echo '<div class="rss-widget">';
wp_widget_rss_output(array(
// CHANGE THE URL BELOW TO THAT OF YOUR FEED
'url' => 'https://wpsitemaintain.ca/feed/',
// CHANGE 'OrganicWeb News' BELOW TO THE NAME OF YOUR WIDGET
'title' => 'From the WP Site Maintain Blog',
// CHANGE '2' TO THE NUMBER OF FEED ITEMS YOU WANT SHOWING
'items' => 3,
// CHANGE TO '0' IF YOU ONLY WANT THE TITLE TO SHOW
'show_summary' => 1,
// CHANGE TO '1' TO SHOW THE AUTHOR NAME
'show_author' => 0,
// CHANGE TO '1' TO SHOW THE PUBLISH DATE
'show_date' => 0
));
echo "</div>";
}
}

?>
