<?php
namespace Ultimate_Fields\Pro;

use Ultimate_Fields\Pro\Helper\Plugin_Updater;

/**
 * Handles the automatic updates of the plugin in non-composer mode.
 *
 * @since 3.0
 */
class Updater {
	/**
	 * Holds the ID of the product.
	 *
	 * @since 3.0
	 * @var int
	 */
	const PRODUCT_ID = 281;

	/**
	 * Stars all the processi of the updater.
	 *
	 * @since 3.0
	 *
	 * @link https://docs.easydigitaldownloads.com/article/383-automatic-upgrades-for-wordpress-plugins
	 */
	public function __construct() {
		$updater = new Plugin_Updater( $this->get_api_url(), ULTIMATE_FIELDS_PRO_PLUGIN_FILE, array(
			'version' => ULTIMATE_FIELDS_VERSION,
			'license' => $this->get_key(),
			'item_id' => self::PRODUCT_ID,
			'author'  => 'Radoslav Georgiev',
			'url'     => home_url(),
			'beta'    => false
		));

		add_action( 'uf.options_page.save', array( $this, 'activate' ), 11 );
	}

	/**
	 * Returns the API URL.
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	protected function get_api_url() {
		return 'https://www.ultimate-fields.com/';
	}

	/**
	 * Returns the current API key.
	 *
	 * @since 3.0
	 *
	 * @return mixed
	 */
	protected function get_key() {
		$key = get_option( 'uf_pro_key' );

		if( is_string( $key ) && $key ) {
			return trim( $key );
		} else {
			return false;
		}
	}

	/**
	 * Activates the license.
	 *
	 * @since 3.0
	 *
	 * @param Ultimate_Fields\Options_Page $page The page that is being saved.
	 */
	function activate( $page ) {
		// Check if the right page has been saved
		if( 'uf-plugin-settings' != $page->get_id() ) {
			return;
		}

		// Call the custom API
		$response = wp_remote_post(
			$this->get_api_url(),
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => array(
					'edd_action' => 'activate_license',
					'license'    => $this->get_key(),
					'url'        => home_url(),
					'item_id'    => self::PRODUCT_ID
				)
			)
		);

		// Check for errors
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) )
				? $response->get_error_message()
				: __( 'An error occurred, please try again.', 'ultimate-fields-pro' );

			return $this->save_message( $messsage );
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// Fallback
		if( false === $license_data ) {
			$license_data = (object) array(
				'success' => false
			);
		}

		// Determine the error if there is one
		if ( false === $license_data->success ) switch( $license_data->error ) {
			case 'expired' :
				return $this->save_message( sprintf(
					__( 'Your license key expired on %s.', 'ultimate-fields-pro' ),
					date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
				) );

			case 'revoked' :
				return $this->save_message( __( 'Your license key has been disabled.', 'ultimate-fields-pro' ) );
				break;

			case 'missing' :
				return $this->save_message( __( 'Invalid license.', 'ultimate-fields-pro' ) );

			case 'invalid' :
			case 'site_inactive' :
				return $this->save_message( __( 'Your license is not active for this URL.', 'ultimate-fields-pro' ) );

			case 'item_name_mismatch' :
				return $this->save_message( sprintf( __( 'This appears to be an invalid license key for %s.', 'ultimate-fields-pro' ), EDD_SAMPLE_ITEM_NAME ) );

			case 'no_activations_left':
				return $this->save_message( __( 'Your license key has reached its activation limit.', 'ultimate-fields-pro' ) );
			default :
				return $this->save_message( __( 'An error occurred, please try again.', 'ultimate-fields-pro' ) );
		}

		$this->save_message(
			__( 'The license is now active!', 'ultimate-fields-pro' ),
			'valid' !== $license_data->license
		);
	}

	protected function save_message( $message, $error = true ) {
		// Save the state of the license
		update_option( 'uf_pro_license_status', array(
			'message' => $error ? $message : false,
			'active'  => ! $error
		));
	}
}
