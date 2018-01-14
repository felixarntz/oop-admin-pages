<?php
/**
 * Base_Admin_Page_Collection class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Collection
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Collection;

use Leaves_And_Love\OOP_Admin_Pages\Admin_Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Collection;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Factory;
use Leaves_And_Love\OOP_Admin_Pages\Exception\Admin_Page_Not_Found_Exception;
use Leaves_And_Love\OOP_Admin_Pages\Exception\Config_Invalid_Exception;
use BrightNucleus\Config\ConfigInterface as Config;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Config\Config as BaseConfig;

/**
 * Class to manage admin page instances.
 *
 * @since 1.0.0
 */
class Base_Admin_Page_Collection implements Admin_Page_Collection {

	use ConfigTrait;

	const PAGES   = 'pages';
	const FACTORY = 'factory';

	/**
	 * Admin pages in the collection.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $pages = array();

	/**
	 * Factory to create admin pages for this collection.
	 *
	 * @since 1.0.0
	 * @var Admin_Page_Factory
	 */
	protected $factory;

	/**
	 * Constructor.
	 *
	 * Sets the configuration and instantiates the admin page factory for the collection.
	 *
	 * @since 1.0.0
	 *
	 * @param Config $config Admin page collection configuration. Must contain the keys 'pages' (array of admin page
	 *                       configurations) and 'factory' (admin page factory instance to use).
	 *
	 * @throws Config_Invalid_Exception Thrown when the configuration is invalid.
	 */
	public function __construct( Config $config ) {
		$this->processConfig( $config );

		if ( ! $this->hasConfigKey( self::FACTORY ) ) {
			throw new Config_Invalid_Exception( sprintf( 'The required configuration key %s is missing.', self::FACTORY ) );
		}

		$factory = $this->getConfigKey( self::FACTORY );

		if ( ! is_a( $factory, Admin_Page_Factory::class ) ) {
			throw new Config_Invalid_Exception( sprintf( 'The class %1$s does not implement the interface %2$s.', $factory_class, Admin_Page_Factory::class ) );
		}

		$this->factory = $factory;
	}

	/**
	 * Registers the admin pages in the collection within the environment.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		if ( ! $this->hasConfigKey( self::PAGES ) ) {
			return;
		}

		$pages = $this->getConfigKey( self::PAGES );

		foreach ( $pages as $page_config ) {
			$page = $this->factory->create_page( new BaseConfig( $page_config ) );

			$this->pages[ $page->get_slug() ] = $page;

			$page->register();
		}
	}

	/**
	 * Checks whether an admin page is part of the collection.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Identifier of the admin page to check for.
	 * @return bool True if the admin page is part of the collection, false otherwise.
	 */
	public function has_page( string $slug ) : bool {
		return isset( $this->pages[ $slug ] );
	}

	/**
	 * Gets an admin page instance that is part of the collection.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Identifier of the admin page to get.
	 * @return Admin_Page Admin page instance.
	 *
	 * @throws Admin_Page_Not_Found_Exception Thrown when the admin page is not found.
	 */
	public function get_page( string $slug ) : Admin_Page {
		if ( ! $this->has_page( $slug ) ) {
			throw new Admin_Page_Not_Found_Exception( sprintf( 'No admin page with the identifier %s exists in the collection.', $slug ) );
		}

		return $this->pages[ $slug ];
	}
}
