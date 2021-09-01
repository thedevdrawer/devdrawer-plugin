<?php
/*
Plugin Name: DevDrawer Sample Plugin
Plugin URI: https://thedevdrawer.com
Description: This is a sample plugin developed by DevDrawer for YouTube.
Version: 1.0.0
Author: DevDrawer
Author URI: https://thedevdrawer.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define('DevDrawer_Version', '1.0.0');

require_once plugin_dir_path(__FILE__).'includes/class-devdrawer-init.php';

function DevDrawer_activate() { 
    DevDrawer_Init::activate();
}

function DevDrawer_deactivate() {
    DevDrawer_Init::deactivate();
}

register_activation_hook( __FILE__, 'DevDrawer_activate' );
register_deactivation_hook( __FILE__, 'DevDrawer_deactivate' );

require_once plugin_dir_path(__FILE__).'includes/class-devdrawer.php';

function init(){
    if(class_exists('DevDrawer')) {
        $devdrawer = new DevDrawer();
        $devdrawer->run();
    }
}

init();