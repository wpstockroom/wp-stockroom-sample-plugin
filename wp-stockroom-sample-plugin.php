<?php
/*
Plugin Name: Self Hosted Plugin updates
Update URI:  wpstockroom.com
Version: 0.10.2
*/

include_once __DIR__ .'/class-wp-stockroom-updater.php';
//                          REPLACE THIS DOMAIN.
add_filter( "update_plugins_wpstockroom.com", array( 'WP_Stockroom_Updater', 'check_update' ),10, 4 );
