<?php
namespace Ultimate_Fields\Pro;

use Ultimate_Fields\Autoloader;
use Ultimate_Fields\Template;
use Ultimate_Fields\Field;

/**
 * Handles the core functionality of Ultimate Fields.
 *
 * @since 3.0
 */
class Core {
	/**
	 * Creates an instance of the core.
	 *
	 * @since 3.0
	 *
	 * @param string $file     The main file of the plugin.
	 * @param bool   $autoload An indicator if the plugin should autoload classes.
	 * @return Core
	 */
	 public static function instance( $file = '', $autoload = false ) {
 		static $instance;

 		if( is_null( $instance ) ) {
 			$instance = new self( $file, $autoload );
 		}

 		return $instance;
 	}

	/**
	 * Initialzies the class.
	 *
	 * @since 3.0
	 *
	 * @param string $directory The directory of the core.
	 * @param bool   $autoload  Indicates whether to use the build-in autoloader.
	 */
	protected function __construct( $file, $autoload = false ) {
		// Fall back to the director for simple files
		if( ! $file ) {
			$file = __DIR__;
		}

		// If used as a plugin, enable the autoloader
		if( $autoload ) {
			new Autoloader( 'Ultimate_Fields\\Pro', __DIR__ );
		}

		// Define path and URL constants
		define( 'ULTIMATE_FIELDS_PRO', true );
		define( 'ULTIMATE_FIELDS_PRO_URL', ultimate_fields()->get_url( $file ) );
		define( 'ULTIMATE_FIELDS_PRO_DIR', dirname( $file ) . '/' );

		// Allow add classes, lications and scripts to be registered.
		add_filter( 'uf.extend', array( $this, 'extend' ), 9 );
		add_filter( 'uf.location.class', array( $this, 'generate_location_class' ), 10, 2 );
		add_filter( 'uf.field.class', array( $this, 'generate_field_class' ), 10, 2 );
		add_filter( 'uf.data_api.datastore_classes', array( $this, 'register_datastore_classes' ) );
		add_action( 'uf.register_scripts', array( $this, 'register_scripts' ), 9 );
		add_action( 'uf.initialized_scripts', array( $this, 'initialize_scripts' ) );
		add_filter( 'uf.settings.fields', array( $this, 'settings_fields' ) );

		// Require the normal API functions
		require __DIR__ . '/../api.php';

		// Let the auto-updater work
		if( ! $this->is_composer() ) {
			$this->updater = new Updater;

			// Load all necessary textdomains
			$langs = basename( dirname( ULTIMATE_FIELDS_PRO_PLUGIN_FILE ) ) . '/main/languages/';
			load_plugin_textdomain( 'ultimate-fields', FALSE, $langs );

			$langs = basename( dirname( ULTIMATE_FIELDS_PRO_PLUGIN_FILE ) ) . '/languages/';
			load_plugin_textdomain( 'ultimate-fields-pro', FALSE, $langs );
		}
	}

	/**
	 * Extends the core plugin.
	 *
	 * @since 3.0
	 */
	public function extend() {
		Template::instance()->add_path( ULTIMATE_FIELDS_PRO_DIR . 'templates/' );
	}

	/**
	 * Allows the class that should be used for a location to be generated.
	 *
	 * @since 3.0
	 *
	 * @param string $class_name The class name that would be used for the location.
	 * @param string $type       The expected location type (ex. `comment`).
	 * @return string
	 */
	public function generate_location_class( $class_name, $type ) {
		static $locations;

		if( is_null( $locations ) ) {
			$locations = array(
				'attachment'      => 'Ultimate_Fields\\Pro\\Location\\Attachment',
				'comment'         => 'Ultimate_Fields\\Pro\\Location\\Comment',
				'customizable'    => 'Ultimate_Fields\\Pro\\Location\\Customizable',
				'customizer'      => 'Ultimate_Fields\\Pro\\Location\\Customizer',
				'menu_item'       => 'Ultimate_Fields\\Pro\\Location\\Menu_Item',
				'options'         => 'Ultimate_Fields\\Pro\\Location\\Options',
				'post_type'       => 'Ultimate_Fields\\Pro\\Location\\Post_Type',
				'shortcode'       => 'Ultimate_Fields\\Pro\\Location\\Shortcode',
				'taxonomy'        => 'Ultimate_Fields\\Pro\\Location\\Taxonomy',
				'user'            => 'Ultimate_Fields\\Pro\\Location\\User',
				'widget'          => 'Ultimate_Fields\\Pro\\Location\\Widget',
				'gutenberg_block' => 'Ultimate_Fields\\Pro\\Location\\Gutenberg_Block'
			);
		}

		if( is_null( $class_name ) && isset( $locations[ $type ] ) ) {
			return $locations[ $type ];
		} else {
			return $class_name;
		}
	}

	/**
	 * Allows the class that should be used for a field to be generated.
	 *
	 * @since 3.0
	 *
	 * @param string $class_name The class name that would be used for the field.
	 * @param string $type       The expected field type (ex. `text`).
	 * @return string
	 */
	public function generate_field_class( $class_name, $type ) {
		static $fields;

		if( is_null( $fields ) ) {
			$fields = array(
				'audio'    => 'Ultimate_Fields\\Pro\\Field\\Audio',
				'color'    => 'Ultimate_Fields\\Pro\\Field\\Color',
				'date'     => 'Ultimate_Fields\\Pro\\Field\\Date',
				'datetime' => 'Ultimate_Fields\\Pro\\Field\\DateTime',
				'embed'    => 'Ultimate_Fields\\Pro\\Field\\Embed',
				'font'     => 'Ultimate_Fields\\Pro\\Field\\Font',
				'gallery'  => 'Ultimate_Fields\\Pro\\Field\\Gallery',
				'icon'     => 'Ultimate_Fields\\Pro\\Field\\Icon',
				'layout'   => 'Ultimate_Fields\\Pro\\Field\\Layout',
				'map'      => 'Ultimate_Fields\\Pro\\Field\\Map',
				'sidebar'  => 'Ultimate_Fields\\Pro\\Field\\Sidebar',
				'time'     => 'Ultimate_Fields\\Pro\\Field\\Time',
				'video'    => 'Ultimate_Fields\\Pro\\Field\\Video'
			);
		}
                $type = strtolower($type);
		if( is_null( $class_name ) && isset( $fields[ $type ] ) ) {
			return $fields[ $type ];
		} else {
			return $class_name;
		}
	}

	/**
	 * Modifies and adds to the list of available datastore classes.
	 *
	 * @since 3.0
	 *
	 * @param  string[] $classes The existing classes.
	 * @return string[]          The modified classes.
	 */
	public function register_datastore_classes( $classes ) {
		return array_merge( $classes, array(
			Datastore\Term_Meta::class,
			Datastore\User_Meta::class,
			Datastore\Widget::class,
			Datastore\Shortcode::class,
			Datastore\Comment_Meta::class,
			Datastore\Gutenberg_Block::class
		));
	}

	/**
	 * Registers all needed scripts for Ultimate Fields Pro.
	 *
	 * @since 3.0
	 */
	public function register_scripts() {
		$src = 'https://maps.googleapis.com/maps/api/js?libraries=places';
		if( $key = get_option( 'uf_google_maps_api_key' ) ) {
			$src .= '&key=' . esc_attr( $key );
		} else {
			// Ensure that there is something to autoload, so additional queries can be avoided.
			update_option( 'uf_google_maps_api_key', '', true );
		}

		/**
		* Allows the URL that is used for loading Google Maps to be modified.
		*
		* The field instance is also provided in case it's needed, but in most
		* cases this should be the same for all map fields.
		*
		* @since 3.0
		*
		* @param string $src The (script) source URL for the Google Maps API.
		*/
		$src = apply_filters( 'uf.field.map.api_url', $src );
		wp_register_script( 'uf-gmaps', $src, array(), '3.27.9', true );

		// Register vendor scripts
		$v      = ULTIMATE_FIELDS_VERSION;
		$assets = ULTIMATE_FIELDS_PRO_URL . 'assets/';
		wp_register_script( 'uf-timepicker', $assets . 'js/jquery-ui-timepicker-addon.js', array( 'jquery-ui-datepicker', 'jquery-ui-slider' ), $v );

		// Register standard scripts
		$js = ULTIMATE_FIELDS_PRO_URL . 'js/';
		wp_register_script( 'uf-pagination',            $js . 'pagination.js',             array( 'uf-core' ), $v );
		wp_register_script( 'uf-shortcode',             $js . 'shortcode.js',              array( 'uf-core' ), $v );
		wp_register_script( 'uf-container-layout-group',$js . 'container/layout-group.js', array( 'uf-container', 'uf-container-group', 'uf-overlay' ), $v );
		wp_register_script( 'uf-container-taxonomy',    $js . 'container/taxonomy.js',     array( 'uf-container' ), $v );
		wp_register_script( 'uf-container-user',        $js . 'container/user.js',         array( 'uf-container' ), $v );
		wp_register_script( 'uf-container-comment',     $js . 'container/comment.js',      array( 'uf-container' ), $v );
		wp_register_script( 'uf-container-widget',      $js . 'container/widget.js',       array( 'uf-container' ), $v );
		wp_register_script( 'uf-container-customizer',  $js . 'container/customizer.js',   array( 'uf-container', 'customize-controls' ), $v );
		wp_register_script( 'uf-container-attachment',  $js . 'container/attachment.js',   array( 'uf-container' ), $v );
		wp_register_script( 'uf-container-menu',        $js . 'container/menu.js',         array( 'uf-container', 'uf-overlay' ), $v );
		wp_register_script( 'uf-container-shortcode',   $js . 'container/shortcode.js',    array( 'uf-container', 'uf-shortcode', 'uf-overlay' ), $v );
		wp_register_script( 'uf-container-front-end',   $js . 'container/front-end.js',    array( 'uf-container', 'uf-overlay' ), $v );
		wp_register_script( 'uf-container-block',       $js . 'container/block.js',    array( 'uf-container', 'uf-overlay' ), $v );
		wp_register_script( 'uf-field-audio',           $js . 'field/audio.js',            array( 'uf-field', 'uf-field-file', 'mediaelement' ), $v );
		wp_register_script( 'uf-field-video',           $js . 'field/video.js',            array( 'uf-field', 'uf-field-file', 'mediaelement' ), $v );
		wp_register_script( 'uf-field-gallery',         $js . 'field/gallery.js',          array( 'uf-field', 'uf-field-file' ), $v );
		wp_register_script( 'uf-field-color',           $js . 'field/color.js',            array( 'uf-field', 'wp-color-picker' ), $v );
		wp_register_script( 'uf-field-date',            $js . 'field/date.js',             array( 'uf-field', 'jquery-ui-datepicker' ), $v );
		wp_register_script( 'uf-field-time',            $js . 'field/time.js',             array( 'uf-field', 'uf-field-date', 'uf-timepicker' ), $v );
		wp_register_script( 'uf-field-datetime',        $js . 'field/datetime.js',         array( 'uf-field', 'uf-field-date', 'uf-timepicker' ), $v );
		wp_register_script( 'uf-field-font',            $js . 'field/font.js',             array( 'uf-field', 'uf-overlay', 'uf-pagination' ), $v );
		wp_register_script( 'uf-field-icon',            $js . 'field/icon.js',             array( 'uf-field', 'uf-overlay', 'uf-tab' ), $v );
		wp_register_script( 'uf-field-sidebar',         $js . 'field/sidebar.js',          array( 'uf-field' ), $v );
		wp_register_script( 'uf-field-map',             $js . 'field/map.js',              array( 'uf-field', 'uf-gmaps' ), $v );
		wp_register_script( 'uf-field-number',          $js . 'field/number.js',           array( 'uf-field', 'jquery-ui-slider' ), $v );
		wp_register_script( 'uf-field-embed',           $js . 'field/embed.js',            array( 'uf-field' ), $v );
		wp_register_script( 'uf-field-layout',          $js . 'field/layout.js',           array( 'uf-field', 'uf-field-repeater', 'uf-layout' ), $v );
		wp_register_script( 'uf-shortcode',             $js . 'shortcode.js',              array( 'uf-core' ), $v );
		wp_register_script( 'uf-layout',                $js . 'layout.js',                 array( 'uf-field', 'jquery-ui-sortable', 'uf-container-layout-group' ), $v );

		// Footer scripts
		wp_register_script( 'uf-customize-preview',     $js . 'customizer-front-end.js',   array( 'customize-preview' ), $v, true );
		wp_register_script( 'uf-map-start',             $js . 'front-end/map.js',          array( 'jquery', 'uf-gmaps' ), $v, true );

		// Styles
		wp_register_style( 'ultimate-fields-pro-css', ULTIMATE_FIELDS_PRO_URL . 'assets/css/ultimate-fields-pro.css', array( 'ultimate-fields-css' ), ULTIMATE_FIELDS_VERSION );
	}

	/**
	 * Finishes the enqueueing of scripts and styles up.
	 *
	 * @since 3.0
	 */
	public function initialize_scripts() {
		if( wp_style_is( 'ultimate-fields-css' ) ) {
			wp_enqueue_style( 'ultimate-fields-pro-css' );
		}
	}

	/**
	 * Checks if Ultimate Fields Pro has been installed through composer.
	 *
	 * @since 3.0
	 *
	 * @return bool
	 */
	public function is_composer() {
		$path  = __DIR__;
		$path  = str_replace( '\\', '/', $path );
		$path  = str_replace( '/pro/core/classes', '', $path );
		$path .= '/uf-composer';

		return file_exists( $path );
	}

	/**
	 * Modifies the fields for the settings page.
	 *
	 * @since 3.0
	 *
	 * @param Ultimate_Fields\Fields_Collection $fields The existing fields.
	 * @return Ultimate_Fields\Fields_Collection
	 */
	public function settings_fields( $fields ) {
		$fields[] = Field::create( 'section', 'general_settings', __( 'Ultimate Fields Pro', 'ultimate-fields-pro' ) )
			->set_icon( 'dashicons dashicons-admin-generic' );

		if( $this->is_composer() ) {
			$message = __( 'A license key is not required, as Ultimate Fields has been installed through Composer and cannot be automatically updated.', 'ultimate-fields-pro' );
			$fields[] = Field::create( 'message', 'uf_pro_message', __( 'License key', 'ultimate-fields-pro' ) )
				->set_description( $message );
		} else {
			$fields[] = Field::create( 'text', 'uf_pro_key', __( 'License key', 'ultimate-fields-pro' ) )
				->set_description( __( 'Enter your license key here to enable automatic updates.', 'ultimate-fields-pro' ) );

			if( get_option( 'uf_pro_key' ) ) {
				$fields[] = $status_field = Field::create( 'message', 'uf_pro_status', __( 'Status', 'ultimate-fields-pro' ) );

				$status = get_option( 'uf_pro_license_status' );

				if( $status['active'] ) {
					$status_field->set_description( __( 'Your license is active and updates are enbled.', 'ultimate-fields-pro' ) )
						->set_attr( 'class', 'uf-license-state uf-license-state-valid' );
				} else {
					$status_field->set_description( $status['message'] )
						->set_attr( 'class', 'uf-license-state uf-license-state-invalid' );
				}
			}
		}

		$fields[] = Field::create( 'section', 'api_keys', __( 'Field Settings', 'ultimate-fields-pro' ) )
			->set_description( __( 'Those keys will be used through Map and Font fields throughout the site. If no value is entered, the fields field will not be available. You can generate an API key at the <a href="https://console.developers.google.com/project" target="_blank">Google APIs Console</a>.', 'ultimate-fields-pro' ) )
			->set_icon( 'dashicons dashicons-list-view' );
		$fields[] = Field::create( 'text', 'uf_google_maps_api_key', __( 'Google Maps API Key', 'ultimate-fields-pro' ) );
		$fields[] = Field::create( 'text', 'uf_google_fonts_api_key', __( 'Google Fonts API Key', 'ultimate-fields-pro' ) );

		return $fields;
	}
}
