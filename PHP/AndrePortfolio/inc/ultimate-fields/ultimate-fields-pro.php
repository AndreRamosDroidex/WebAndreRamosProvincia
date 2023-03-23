<?php
/**
 * Plugin name: Ultimate Fields Pro
 * Plugin URI:  https://www.ultimate-fields.com/pro/
 * Author:      Radoslav Georgiev
 * Author URI:  http://rageorgiev.com/
 * Copyright:   Radoslav Georgiev
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain path: /languages
 * Text Domain: ultimate-fields
 * Description: Ultimate Fields is a plugin, that allows you to add custom fields in many places throughout the WordPress administration area, supporting a total of more than 30 field types, including repeaters, layouts and etc.
 * Version: 3.0.1
 */

 /**
  * Loads the files of Ultimate Fields and Ultimate Fields Pro.
  *
  * This function is hooked in with priority 8 in order to be loaded before Ultimate Fields (free),
  * ensuring that if both Ultimate Fields and Ultimate Fields Pro are activated, only the files of
  * Ultimate Fields Pro will be loaded.
  *
  * @since 3.0
  */
add_action( 'plugins_loaded', 'load_ultimate_fields_pro', 8 );
function load_ultimate_fields_pro() {
	define( 'ULTIMATE_FIELDS_PLUGIN_FILE', __DIR__ . '/main/ultimate-fields.php' );
	define( 'ULTIMATE_FIELDS_PRO_PLUGIN_FILE', __FILE__ );
	define( 'ULTIMATE_FIELDS_LANGUAGES_DIR', basename( __DIR__ ) . '/main/languages/' );

	require_once( 'main/core/ultimate-fields.php' );
	require_once( 'main/ui/ultimate-fields-ui.php' );
	require_once( 'pro/core/ultimate-fields-pro.php' );
	require_once( 'pro/ui/ultimate-fields-pro-ui.php' );
}
