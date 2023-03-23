<?php
namespace Ultimate_Fields\Pro;

use Ultimate_Fields\Core as Main_Core;
use Ultimate_Fields\UI\UI as Main_UI;

/**
 * Handles the boot of Ultimate Fields Pro within Composer.
 *
 * @since 3.0
 */
class Composer {
	/**
	 * Boots Ultimate Fields Pro.
	 *
	 * @since 3.0
	 *
	 * @link https://www.ultimate-fields.com/docs/quick-start/administration-interface/
	 * @link https://www.ultimate-fields.com/pro/
	 *
	 * @param bool $ui Whether to include the user interface.
	 */
	public static function boot( $ui = true ) {
		Main_Core::instance();
		Core::instance();

		if( $ui ) {
			Main_UI::instance();
			UI\UI::instance();
		}
	}
}
