<?php
/**
 * Abstract_Admin_Page class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page;

use Leaves_And_Love\OOP_Admin_Pages\Admin_Page;
use Leaves_And_Love\OOP_Admin_Pages\Exception\Config_Invalid_Exception;
use BrightNucleus\Config\ConfigInterface as Config;
use BrightNucleus\Config\ConfigTrait;

/**
 * Abstract class representing an admin page.
 *
 * @since 1.0.0
 */
abstract class Abstract_Admin_Page implements Admin_Page {

	use ConfigTrait;

	const SLUG                = 'slug';
	const TITLE               = 'title';
	const RENDER_CALLBACK     = 'render_callback';
	const INITIALIZE_CALLBACK = 'initialize_callback';

	/**
	 * Constructor.
	 *
	 * Sets the configuration.
	 *
	 * @since 1.0.0
	 *
	 * @param Config $config Admin page configuration. Must contain keys 'slug' (admin page identifier), 'title'
	 *                       and 'render_callback' (callable that receives the configuration as sole parameter).
	 *                       May also contain an 'initialize_callback' key.
	 *
	 * @throws Config_Invalid_Exception Thrown when the configuration is invalid.
	 */
	public function __construct( Config $config ) {
		$this->processConfig( $config );

		$required_keys = $this->get_required_config_keys();

		foreach ( $required_keys as $required_key ) {
			if ( ! $this->hasConfigKey( $required_key ) ) {
				throw new Config_Invalid_Exception( sprintf( 'The required configuration key %s is missing.', $required_key ) );
			}

			$value = $this->getConfigKey( $required_key );
			if ( empty( $value ) ) {
				throw new Config_Invalid_Exception( sprintf( 'The required configuration key %s is empty.', $required_key ) );
			}
		}
	}

	/**
	 * Gets the slug of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page slug.
	 */
	public function get_slug() : string {
		return $this->getConfigKey( self::SLUG );
	}

	/**
	 * Gets the title of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page title.
	 */
	public function get_title() : string {
		return $this->getConfigKey( self::TITLE );
	}

	/**
	 * Initializes the admin page on pageload.
	 *
	 * This method must be called before any output is printed.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		if ( ! $this->hasConfigKey( self::INITIALIZE_CALLBACK ) ) {
			return;
		}

		call_user_func( $this->getConfigKey( self::INITIALIZE_CALLBACK ), $this->config );
	}

	/**
	 * Renders the admin page content.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		call_user_func( $this->getConfigKey( self::RENDER_CALLBACK ), $this->config );
	}

	/**
	 * Gets the configuration keys that are required for an admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of configuration keys.
	 */
	protected function get_required_config_keys() {
		return array( self::SLUG, self::TITLE, self::RENDER_CALLBACK );
	}
}
