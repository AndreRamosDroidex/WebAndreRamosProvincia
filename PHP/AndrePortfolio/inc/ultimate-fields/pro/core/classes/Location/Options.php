<?php
namespace Ultimate_Fields\Pro\Location;

use Ultimate_Fields\Location\Options as Free_Location;

/**
 * Extends the Options location from the core by adding customizable functionality to it.
 *
 * @since 3.0
 */
class Options extends Free_Location {
	use Customizable;

	/**
	 * Creates an instance of the class.
	 * The parameters for this constructor are the same as the parameters of Container->add_location().
	 *
	 * @since 3.0
	 *
	 * @param mixed   $page The page that will be used by the location. Can be a string ID or an Options_page.
	 * @param mixed[] $args Additional arguments for the location.
	 */
	public function __construct( $page = null, $args = array() ) {
		$this->check_args_for_customizer( $args );

		parent::__construct( $page, $args );
	}

	/**
	 * Imports the location from PHP/JSON.
	 *
	 * @since 3.0
	 *
	 * @param  [mixed[] $args The arguments to import.
	 */
	public function import( $args ) {
		parent::import( $args );

		# Check for the customizer
		$this->import_customizable_data( $args );

		# Check for rest data
		$this->import_rest_data( $args );
	}

	/**
	 * Returns the settings for the location, which will be exported.
	 *
	 * @since 3.0
	 *
	 * @return mixed[]
	 */
	public function export() {
		$settings = parent::export();

		# Export customizable data
		$this->export_customizable_data( $settings );

		return $settings;
	}
}
