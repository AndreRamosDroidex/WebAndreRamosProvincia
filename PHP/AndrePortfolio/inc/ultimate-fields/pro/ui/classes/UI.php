<?php
namespace Ultimate_Fields\Pro\UI;

use Ultimate_Fields\Autoloader;

class UI {
	/**
	 * Returns an instance of the class.
	 *
	 * @since 3.0
	 *
	 * @param string $file     A file to create the instance for (as plugin file).
	 * @param bool   $autoload Whether to create an autoloader or not.
	 * @return UI
	 */
	public static function instance( $file = false, $autoload = false ) {
		static $instance;

		if( is_null( $instance ) ) {
			$instance = new self( $file, $autoload );
		}

		return $instance;
	}

	/**
	 * Adds all necessary listeners for the class.
	 *
	 * @since 3.0
	 *
	 * @param string $file     A file to create the instance for (as plugin file).
	 * @param bool   $autoload Whether to create an autoloader or not.
	 */
	private function __construct( $file, $autoload ) {
		if( $autoload ) {
			new Autoloader( 'Ultimate_Fields\\Pro\\UI', __DIR__ );
		}

		add_action( 'uf.ui.fields', array( $this, 'register_fields' ) );
		add_filter( 'uf.ui.location_classes', array( $this, 'register_locations' ) );
		add_filter( 'uf.ui.location.class', array( $this, 'overwrite_location_class' ), 10, 2 );
	}

	/**
	 * Registers all fields within the editor in the interface.
	 *
	 * @since 3.0
	 *
	 * @param Ultimate_Fields\UI\Field_Editor $editor The editor, which handles fields.
	 */
	public function register_fields( $editor ) {
		$editor->add_type( 'files',      'Audio', 	   Field_Helper\Audio::class );
		$editor->add_type( 'files',      'Gallery',      Field_Helper\Gallery::class );
		$editor->add_type( 'files',      'Video', 	   Field_Helper\Video::class );
		$editor->add_type( 'files',      'Embed', 	   Field_Helper\Embed::class );
		$editor->add_type( 'others',     'Color',        Field_Helper\Color::class );
		$editor->add_type( 'others',     'Date',         Field_Helper\Date::class );
		$editor->add_type( 'others',     'Time',         Field_Helper\Time::class );
		$editor->add_type( 'others',     'Datetime',     Field_Helper\DateTime::class );
		$editor->add_type( 'others',     'Font',         Field_Helper\Font::class );
		$editor->add_type( 'others',     'Icon',         Field_Helper\Icon::class );
		$editor->add_type( 'others',     'Map',          Field_Helper\Map::class );
		$editor->add_type( 'others',     'Sidebar',      Field_Helper\Sidebar::class );
		$editor->add_type( 'advanced',   'Layout',       Field_Helper\Layout::class );
	}

	/**
	 * Registers all Pro locations, available in the UI.
	 *
	 * @since 3.0
	 *
	 * @param string[] $locations The list of existing locations.
	 * @return string[]
	 */
	public function register_locations( $existing ) {
		return array_merge( $existing, array(
			Location\Customizer::class,
			Location\Comment::class,
			Location\Attachment::class,
			Location\Menu_Item::class,
			Location\Shortcode::class,
			Location\Taxonomy::class,
			Location\User::class,
			Location\Widget::class
		));
	}

	/**
	 * Returns the classes, associated with specific locations.
	 *
	 * @since 3.0
	 *
	 * @param mixed $class_name The already generated class name for the location.
	 * @param string $type      The type of the location.
	 * @return mixed
	 */
	public function overwrite_location_class( $class_name, $type ) {
		static $types;

		if( is_null( $types ) ) {
			$types = array(
				'customizer' => Location\Customizer::class,
				'comment'    => Location\Comment   ::class,
				'attachment' => Location\Attachment::class,
				'menu_item'  => Location\Menu_Item ::class,
				'shortcode'  => Location\Shortcode ::class,
				'taxonomy'   => Location\Taxonomy  ::class,
				'user'       => Location\User      ::class,
				'widget'     => Location\Widget    ::class
			);
		}

		if( isset( $types[ $type ] ) ) {
			return $types[ $type ];
		} else {
			return $class_name;
		}
	}
}
