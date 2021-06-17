<?php
/**
 * Plugin Name:       Anhaguera Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Plugin para a Universidade de Anhaguera
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       anhaguera
 * Domain Path:       /languages
 */

register_activation_hook( __FILE__, 'ahg_activation_hook' );
add_action('admin_init', 'ahr_plugins_loaded', 1);

add_action('admin_menu', 'teste', 100);



function ahr_plugins_loaded(){
    add_action('wp_ajax_GetClass', 'teste2', 1);
    
}

function ahg_activation_hook() {
}

function teste2() {
    global $wpdb;
    var_export("tou dentro");
	$ctable = $wpdb->prefix . "wpsp_class";
	$cid = esc_sql($_POST['cid']);
	$clinfo = $wpdb->get_row("select * from $ctable where cid='$cid'", ARRAY_A);
	$clinfo['c_sdate'] = viewDate($clinfo['c_sdate']);
	$clinfo['c_edate'] = viewDate($clinfo['c_edate']);
	if (!empty($clinfo)) echo json_encode($clinfo);
	else echo "false";
	wp_die();
}

function viewDate($date){


	


	global $wpdb, $wpsp_settings_data;	


	$date_format	=	isset( $wpsp_settings_data['date_format'] ) ? $wpsp_settings_data['date_format'] : '';	


	$dformat		=	empty( $date_format ) ? 'm/d/Y' : $date_format;		


	return ( !empty( $date ) && $date!='0000-00-00' ) ? date( $dformat,strtotime($date) ) : $date;


} 
function teste() {
    remove_submenu_page('WPSchoolPress','addons');
    add_submenu_page( 'WPSchoolPress', 'WPSchoolPress', '<i class="dashicons dashicons-welcome-add-page"></i>&nbsp; Addons',
    'manage_options', 'addons_edited','htmlteste');
}

function htmlteste() {
    ?>
        <div id="wpbody">
    <div aria-label="Main content" tabindex="0" class="addon-page">
        <div class="wrap">
            <h1>WPSchoolpress Add-Ons Opaaa</h1>
            <div class="container">             
                <div class="wpsp-row">
                  <?php    $member_detail = wp_remote_get('https://wpschoolpress.com/wp-json/api/v1/addons/');
  $team_details = json_decode(wp_remote_retrieve_body($member_detail));
 echo $team_details->message;
     ?>
                    
                
                    
                </div>
               

            </div><!-- dashboard-widgets-wrap -->
        </div><!-- wrap -->
    </div><!-- wpbody-content -->
</div>
    <?php
}
