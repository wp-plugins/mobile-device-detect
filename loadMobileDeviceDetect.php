<?php
/**
 * @desc			This file loads mobile device detect as plugin to Wordpress.
 * @copyright		2009 Matthias Reuter
 * @package			Wordpress
 * @author			Matthias Reuter ($LastChangedBy: matthias $)
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @version			$LastChangedDate: 2009-08-26 01:50:41 +0000 (Mi, 26 Aug 2009) $
 * @since			1.0
 * @web				http://straightvisions.com
 */
/*
Plugin Name: Mobile Device Detect
Plugin URI: http://straightvisions.com/mobile-device-detect-for-wordpress.html
Description: This Wordpress plugin integrates the mobile device detect function from detectmobilebrowsers.mobi in wordpress. It allows to redirect visitors to a custom target URL. Mobile Device Detect for Wordpress is licensed to GNU General Public License v3. Please note that you also have to download the mobile device detect code from Andy Moore to get this Wordpress plugin work. It has it's own license, you have to confirm it, too.
Version: 1.0
Author: Matthias Reuter
Author URI: http://straightvisions.com
*/

define('MOBILE_DD_PLUGINFILE',WP_PLUGIN_DIR.'/mobile_device_detect/mobile_device_detect.php');

// load plugin functions
if(file_exists(MOBILE_DD_PLUGINFILE)){
	require_once(MOBILE_DD_PLUGINFILE);
	if(get_option('mobile_dd_target_url') != ''){
		if($_GET['mobile_dd'] == 'non_mobile' || $_POST['mobile_dd'] == 'non_mobile'){
			setcookie('mobile_dd', 1);
		}elseif($_COOKIE['mobile_dd'] != 1){
			mobile_device_detect(true,true,true,true,true,true,get_option('mobile_dd_target_url'),false);
		}
	}
}

// Hook for adding toplevel menu
function mobile_dd_add_toplevel_menu() {
	add_menu_page('Mobile Detect', 'Mobile Detect', 8, __FILE__, 'options_mobile_device_detect');
}
add_action('admin_menu', 'mobile_dd_add_toplevel_menu');

function options_mobile_device_detect(){
	echo '
	<div class="wrap">
		<h2>Welcome to Mobile Device Detect configuration panel</h2>
		<p>This wordpress plugin integrates the mobile device detect function from <a href="http://detectmobilebrowsers.mobi/">detectmobilebrowsers.mobi</a> in wordpress. It allows to redirect visitors to a custom target URL, which can be specified here.</p>
		'.(file_exists(MOBILE_DD_PLUGINFILE) ? '' : '<p>File "mobile_device_detect.php" not found, please download it from <a href="http://detectmobilebrowsers.mobi/">detectmobilebrowsers.mobi</a> and paste it into plugin\'s folder.</p>').'
		<form method="post" action="options.php">
			'.wp_nonce_field('update-options').'
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="mobile_dd_target_url">Target URL for mobile devices</label></th>
					<td><input type="text" name="mobile_dd_target_url" id="mobile_dd_target_url" value="'.get_option('mobile_dd_target_url').'" class="regular-text code" /></td>
				</tr>
			</table>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="mobile_dd_target_url" />
			<p class="submit"><input type="submit" name="Submit" class="button-primary" /></p>
		</form>
	</div>
	';
}
?>