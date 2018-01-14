<?php
/**
 * Admin_Page_Collection interface
 *
 * @package Leaves_And_Love\OOP_Admin_Pages
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages;

use Leaves_And_Love\OOP_Admin_Pages\Exception\Admin_Page_Not_Found_Exception;

/**
 * Interface to manage admin page instances.
 *
 * @since 1.0.0
 */
interface Admin_Page_Collection {

	/**
	 * Registers the admin pages in the collection within the environment.
	 *
	 * @since 1.0.0
	 */
	public function register();

	/**
	 * Checks whether an admin page is part of the collection.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Identifier of the admin page to check for.
	 * @return bool True if the admin page is part of the collection, false otherwise.
	 */
	public function has_page( string $slug ) : bool;

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
	public function get_page( string $slug ) : Admin_Page;
}
