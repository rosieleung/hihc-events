<?php
/*
Plugin Name: Help Is Here Coaching Events
Version:     1.0
Plugin URI:  https://rosieleung.com/
Description: Adds events functionality for Help Is Here Coaching.
Author:      Rosie Leung
Author URI:  mailto:rosie@rosieleung.com
License:     GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HIHC_EVENTS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'HIHC_EVENTS_PATH', dirname( __FILE__ ) );
define( 'HIHC_EVENTS_VERSION', '1.0.0' );

add_action( 'plugins_loaded', 'hihc_events_init_plugin' );

function hihc_events_init_plugin() {
	
	if ( ! class_exists( 'acf' ) ) {
		add_action( 'admin_notices', 'hihc_events_warn_no_acf' );
		
		return;
	}
	date_default_timezone_set( get_option( 'timezone_string' ) );
	include_once( HIHC_EVENTS_PATH . '/fields/hihc-events.php' );
	include_once( HIHC_EVENTS_PATH . '/includes/enqueue.php' );
	include_once( HIHC_EVENTS_PATH . '/includes/hihc-events.php' );
	include_once( HIHC_EVENTS_PATH . '/includes/shortcodes.php' );
	include_once( HIHC_EVENTS_PATH . '/includes/templating.php' );
}

// Display ACF required warning on admin if ACF is not activated
function hihc_events_warn_no_acf() {
	?>
	<div class="error">
		<p>
			<strong>Help Is Here Coaching Events:</strong> This plugin requires Advanced Custom Fields PRO in order to operate. Please install and activate ACF Pro, or disable this plugin.
		</p>
	</div>
	<?php
}

function hihc_events_rewrite_flush() {
	include_once( HIHC_EVENTS_PATH . '/includes/hihc-events.php' );
	hihc_events_register();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'hihc_events_rewrite_flush' );

