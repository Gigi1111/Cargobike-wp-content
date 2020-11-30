<?php
//In The Name Of Allah
/*
Plugin Name: Date & Time Range Picker
Description: Advanced Date And Time Range Picker Add-On For GravityForms
Plugin URI: #
Version: 1.0.0
Author: Salar Sadeghi
Author URI: https://salars.xyz
Text Domain: dtrpg
Domain Path: /languages
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) {exit;}
define("DTRPG_DIR" , __DIR__);
define("DTRPG_FILE" , __FILE__);
class DTRPG{
    function __construct(){      
        
            require_once DTRPG_DIR."/inc/setting.php";
            require_once DTRPG_DIR."/inc/settings/class-dtrp-setting.php";
            require_once DTRPG_DIR."/inc/class-dtrp-field.php";
            new DTRPG_Settings;
            new DTRPG_Setting;
            GF_Fields::register( new GF_Field_DTRP );
            add_action( 'plugins_loaded', function() {
                load_plugin_textdomain( 'dtrpg', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
            } );
    }
}
if ( !class_exists( 'GFCommon' ) ) {

    add_action( 'admin_notices',function() {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><?php _e( 'Data & Time Range Picker : You Should Install & Activate GravityForms Plugin.', 'dtrpg' ); ?></p>
        </div>
        <?php
    } );

    $arr_dtrpg = get_option('active_plugins');

    $p = plugin_basename( __FILE__ );

    for ($i=0; $i < count($arr_dtrpg); $i++) { 
        if($arr_dtrpg[$i] == $p){
            unset($arr_dtrpg[$i]);
            $arr_dtrpg = array_values($arr_dtrpg);
            break;
        }
    }

    update_option( 'active_plugins', $arr_dtrpg, true );

    add_action( 'admin_notices',function() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( 'Data & Time Range Picker deactivated.', 'dtrpg' ); ?></p>
        </div>
        <?php
    } );

    return;
}

new DTRPG;