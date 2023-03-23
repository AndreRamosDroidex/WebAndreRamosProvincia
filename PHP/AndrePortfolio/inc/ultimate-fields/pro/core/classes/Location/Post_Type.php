<?php
namespace Ultimate_Fields\Pro\Location;

use Ultimate_Fields\Location\Post_Type as Free_Post_Type;

/**
 * Extends the Post_Type location from the core by adding customizable functionality to it.
 *
 * @since 3.0
 */
class Post_Type extends Free_Post_Type {
	use Customizable;

	/**
	 * Creates an instance of the class.
	 * The parameters for this constructor are the same as the parameters of Container->add_location().
	 *
	 * @since 3.0
	 *
	 * @param string  $post_type Either a single post type or an array of post types.
	 * @param mixed[] $args      Additional arguments for the location.
	 */
	public function __construct( $post_type = null, $args = array() ) {
		$this->check_args_for_customizer( $args );

		parent::__construct( $post_type, $args );
	}

	/**
	 * Imports the information about the location from an array.
	 *
	 * @since 3.0
	 *
	 * @param  array $args The arguments for the import.
	 */
	public function import( $args ) {
		parent::import( $args );

		# Check for the customizer
		$this->import_customizable_data( $args );
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
