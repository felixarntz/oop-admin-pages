<?php
/**
 * WordPress_Admin_Submenu_Page class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page;

/**
 * Class representing a WordPress admin page that also has a submenu entry.
 *
 * @since 1.0.0
 */
class WordPress_Admin_Submenu_Page extends WordPress_Admin_Page {

	const PARENT_SLUG = 'parent_slug';
	const MENU_TITLE  = 'menu_title';

	/**
	 * Gets the callback to use to register the admin page within WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @return callable Callback to hook into the respective menu action.
	 */
	protected function get_register_hook_callback() {
		return function() {
			$slug        = $this->getConfigKey( self::SLUG );
			$title       = $this->getConfigKey( self::TITLE );
			$capability  = $this->getConfigKey( self::CAPABILITY );
			$parent_slug = $this->getConfigKey( self::PARENT_SLUG );
			$menu_title  = $this->hasConfigKey( self::MENU_TITLE ) ? $this->getConfigKey( self::MENU_TITLE ) : $title;

			$hook_suffix = add_submenu_page( $parent_slug, $title, $menu_title, $capability, $slug, array( $this, 'render' ) );

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
		$parent_slug = $this->getConfigKey( self::PARENT_SLUG );

		if ( false !== strpos( $parent_slug, '?' ) ) {
			list( $base_slug, $query ) = explode( '?', $parent_slug, 2 );
		} else {
			$base_slug = $parent_slug;
		}

		if ( '.php' === substr( $base_slug, -4 ) ) {
			return $parent_slug;
		}

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
		$required_keys[] = self::PARENT_SLUG;

		return $required_keys;
	}
}
