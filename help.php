<?php
/*
Plugin Name: WordPress Dashboard Help Videos
Plugin URI: https://github.com/ripencreative/
Description: WordPress Help Videos for Dashboards
Version: 0.1
License: GPL
Author: Brian Morris
Author URI: https://ripencreative.ca
GitHub Plugin URI: https://github.com/ripencreative/
GitHub Branch: master
*/

// Add Help menu item to the WordPress Dashboard

/**
 * Register a custom menu page.
 */
function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Help Videos', 'textdomain' ),
        'custom menu',
        'manage_options',
        'dashboard_help_videos/videos.php',
        '',
        plugins_url( 'dashboard_help_videos/images/icon.png' ),
        3
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


// RSS Feed Widget for latest WordPress news

add_action('wp_dashboard_setup', 'organicweb_dashboard_widgets');

function organicweb_dashboard_widgets() {
// CHANGE 'OrganicWeb News' BELOW TO THE TITLE OF YOUR WIDGET
wp_add_dashboard_widget( 'dashboard_custom_feed', 'WordPress News', 'organicweb_custom_feed_output' );

function organicweb_custom_feed_output() {
echo '<div class="rss-widget">';
wp_widget_rss_output(array(
// CHANGE THE URL BELOW TO THAT OF YOUR FEED
'url' => 'https://managewp.org/articles.rss',
// CHANGE 'OrganicWeb News' BELOW TO THE NAME OF YOUR WIDGET
'title' => 'WordPress News',
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
