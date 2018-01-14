<?php
/**
 * WordPress_Network_Admin_Panel class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels;

/**
 * Class representing the WordPress network admin panel.
 *
 * @since 1.0.0
 */
class WordPress_Network_Admin_Panel implements WordPress_Admin_Panel {

	/**
	 * Gets the callback to generate an URL to the admin panel.
	 *
	 * @since 1.0.0
	 *
	 * @return callable Admin panel URL callback.
	 */
	public function get_url_callback() : callable {
		return 'network_admin_url';
	}

	/**
	 * Gets the hook name to use to register content for the admin panel.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin panel hook name.
	 */
	public function get_hook_name() : string {
		return 'network_admin_menu';
	}
}
