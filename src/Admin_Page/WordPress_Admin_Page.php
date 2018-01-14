<?php
/**
 * WordPress_Admin_Page class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page;

use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels\WordPress_Admin_Panel;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels\WordPress_Admin_Panels;

/**
 * Class representing a basic WordPress admin page.
 *
 * @since 1.0.0
 */
class WordPress_Admin_Page extends Abstract_Admin_Page {

	const CAPABILITY  = 'capability';
	const ADMIN_PANEL = 'admin_panel';

	/**
	 * Gets the URL of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page URL.
	 */
	public function get_url() : string {
		$parent_file = $this->get_parent_file();

		$url_callback = $this->get_admin_panel()->get_url_callback();
		$base_url     = call_user_func( $url_callback, $parent_file );

		return add_query_arg( 'page', $this->getConfigKey( self::SLUG ), $base_url );
	}

	/**
	 * Registers the admin page within the environment.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$callback = $this->get_register_hook_callback();

		$hook_name = $this->get_admin_panel()->get_hook_name();

		if ( doing_action( $hook_name ) ) {
			call_user_func( $callback );
		} else {
			add_action( $hook_name, $callback );
		}
	}

	/**
	 * Gets the admin panel instance this admin page is part of.
	 *
	 * @since 1.0.0
	 *
	 * @return WordPress_Admin_Panel Admin panel instance.
	 */
	protected function get_admin_panel() : WordPress_Admin_Panel {
		if ( $this->hasConfigKey( self::ADMIN_PANEL ) ) {
			return WordPress_Admin_Panels::get_panel( $this->getConfigKey( self::ADMIN_PANEL ) );
		}

		return WordPress_Admin_Panels::get_current_panel();
	}

	/**
	 * Gets the callback to use to register the admin page within WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return callable Callback to hook into the respective menu action.
	 */
	protected function get_register_hook_callback() {
		return function() {
			$slug       = $this->getConfigKey( self::SLUG );
			$title      = $this->getConfigKey( self::TITLE );
			$capability = $this->getConfigKey( self::CAPABILITY );

			$hook_suffix = add_submenu_page( null, $title, $title, $capability, $slug, array( $this, 'render' ) );

			add_action( "load-{$hook_suffix}", array( $this, 'initialize' ) );
		};
	}

	/**
	 * Gets the parent file for the admin page URL in WordPress.
	 *
	 * May contain query parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return string Parent file for the URL.
	 */
	protected function get_parent_file() {
		return 'admin.php';
	}

	/**
	 * Gets the configuration keys that are required for an admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of configuration keys.
	 */
	protected function get_required_config_keys() {
		$required_keys   = parent::get_required_config_keys();
		$required_keys[] = self::CAPABILITY;

		return $required_keys;
	}
}
