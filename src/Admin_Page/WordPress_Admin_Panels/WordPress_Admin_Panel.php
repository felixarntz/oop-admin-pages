<?php
/**
 * WordPress_Admin_Panel interface
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels;

/**
 * Interface representing a WordPress admin panel.
 *
 * @since 1.0.0
 */
interface WordPress_Admin_Panel {

	/**
	 * Gets the callback to generate an URL to the admin panel.
	 *
	 * @since 1.0.0
	 *
	 * @return callable Admin panel URL callback.
	 */
	public function get_url_callback() : callable;

	/**
	 * Gets the hook name to use to register content for the admin panel.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin panel hook name.
	 */
	public function get_hook_name() : string;
}
