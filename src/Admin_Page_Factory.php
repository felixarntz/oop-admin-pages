<?php
/**
 * Admin_Page_Factory interface
 *
 * @package Leaves_And_Love\OOP_Admin_Pages
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages;

use Leaves_And_Love\OOP_Admin_Pages\Exception\Config_Invalid_Exception;
use BrightNucleus\Config\ConfigInterface as Config;

/**
 * Interface to create admin page instances.
 *
 * @since 1.0.0
 */
interface Admin_Page_Factory {

	/**
	 * Creates a new admin page instance.
	 *
	 * @since 1.0.0
	 *
	 * @param Config $config Admin page configuration.
	 * @return Admin_Page Admin page instance.
	 *
	 * @throws Config_Invalid_Exception Thrown when the configuration is invalid.
	 */
	public function create_page( Config $config ) : Admin_Page;
}
