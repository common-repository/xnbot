<?php 
/**
 * Plugin Name: XnBot Plugin
 * Plugin URI: http://xnbot.io
 * Description: The plugin connects your website with XnBot!
 * Author: Extreme Net KFT
 * Author URI: http://extremenet.hu
 * Developer: Simon György
 * Version: 1.0
 * License: GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

////////////////////////////////////////////
/*         CRON DEMO STARTS HERE           */
/////////////////////////////////////////////


// unschedule event upon plugin deactivation
function xnbot_cronstarter_deactivate() {	
	// find out when the last event was scheduled
	$timestamp = wp_next_scheduled ('xnbot_cronjob');
	// unschedule previous event if any
	wp_unschedule_event ($timestamp, 'xnbot_cronjob');
} 
register_deactivation_hook (__FILE__, 'xnbot_cronstarter_deactivate');
// create a scheduled event (if it does not exist already)
function xnbot_cronstarter_activation() {
	if( !wp_next_scheduled( 'xnbot_cronjob' ) ) {  
	   wp_schedule_event( time(), 'everyminute', 'xnbot_cronjob' );  
	}
}
// and make sure it's called whenever WordPress loads
add_action('wp', 'xnbot_cronstarter_activation');
// here's the function we'd like to call with our cron job
function xnbot_check_script_function() {
   include_once 'backend/API.php'; 
   $status = get_option('xnbot_status'); 
   if(isset($status) && intVal($status) == 1 ){
        $API = new API();
        $response = $API->checkScript();
   }
}


// hook that function onto our scheduled event:
add_action ('xnbot_cronjob', 'xnbot_check_script_function'); 


// add another interval
function xnbot_cron_add_minute( $schedules ) {
	// Adds oxnbot_nce every minute to the existing schedules.
    $schedules['everyminute'] = array(
	    'interval' => 60,
	    'display' => __( 'Once Every Minute' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'xnbot_cron_add_minute' );



////////////////////////////////////////////
/*       SETTINGS PAGE STARTS HERE        */
/////////////////////////////////////////////

// Create settings menu
add_action('admin_menu', 'xnbot_plugin_create_menu');
add_action('wp_head', 'register_script_to_site');   

function xnbot_plugin_create_menu() {
	// Create new  menu
	add_menu_page('XnBot Plugin Settings', 'XnBot Settings', 'administrator', __FILE__, 'xnbot_plugin_settings_page' , plugins_url('/assets/images/logo.png', __FILE__) );
	// Register settings function
	add_action( 'admin_init', 'register_xnbot_plugin_settings' );
}

function register_xnbot_plugin_settings(){
    // Settings function
    register_setting( 'xnbot-plugin-settings-group', 'xnbot_api_key_token' );
    register_setting( 'xnbot-plugin-settings-group', 'xnbot_status' );
    register_setting( 'xnbot-plugin-settings-group', 'xnbot_script_last_download' );

}

function register_script_to_site(){
    // get status in db options tabel
    $status = get_option('xnbot_status'); 
    // check status end file exist
    if(isset($status) && intVal($status) == 1 && file_exists( dirname(__FILE__)."/scripts/XnBot_Script.js" ) ){
        // register script in site 
        wp_register_script( 'xnbot_jquery_script', plugins_url('scripts/XnBot_Script.js?date='.date('y-m-d_h-i-s'), __FILE__) );    
        wp_enqueue_script( 'xnbot_jquery_script' );
    }
}

function xnbot_plugin_settings_page() {
    // Add Bootstrap assets
    wp_enqueue_style( 'plugin-options_bootstrap', plugins_url('/assets/vendor/bootstrap/css/bootstrap.css', __FILE__) );
    wp_enqueue_script( 'plugin-options_bootstrap',plugins_url('/assets/vendor/bootstrap/js/bootstrap.js', __FILE__) ); 
    // Add our CSS Styling
    wp_enqueue_style( 'plugin-options', plugins_url('/assets/css/style.css', __FILE__) );
    wp_enqueue_script( 'plugin-options',plugins_url('/assets/js/app.js', __FILE__) ); 
?>
    
<div class="wrap"> <!-- START WRAP -->
    <!-- Menu Tab -->
    
    <!-- END Menu Tab -->
    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <div class="separator"></div>
        <div class="bg_1">
            <img src="<?php echo plugins_url('/assets/images/red_bg.png', __FILE__); ?>" width="60%" height="auto" style="max-width:500px" />
        </div>
        <div class="bg_2">
            <img src="<?php echo plugins_url('/assets/images/module_bg.png', __FILE__); ?>" width="60%" height="auto" style="max-width:500px" />
        </div>
        <div class="option-tab">
        <img src="<?php echo plugins_url('/assets/images/logo_100.png', __FILE__); ?>" width="60px" height="60px" />
        </div>
        <?php include 'backend/controller.php'; ?>
        <?php if( !isset($auth) || $auth == false ){ 
            include 'frontend/view/get_started.php';
        }else{ 
            include 'frontend/view/settings.php';
         } ?>
        <div class="clearfix"></div>
    </div>
</div> <!-- END WRAP -->

<?php } 

