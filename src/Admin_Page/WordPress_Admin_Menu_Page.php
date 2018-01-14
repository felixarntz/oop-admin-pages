<?php
/**
 * WordPress_Admin_Menu_Page class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page;

/**
 * Class representing a WordPress admin page that also has a top-level menu entry.
 *
 * @since 1.0.0
 */
class WordPress_Admin_Menu_Page extends WordPress_Admin_Page {

	const MENU_TITLE  = 'menu_title';
	const ICON_URL    = 'icon_url';
	const POSITION    = 'position';

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
			$menu_title = $this->hasConfigKey( self::MENU_TITLE ) ? $this->getConfigKey( self::MENU_TITLE ) : $title;
			$icon_url   = $this->hasConfigKey( self::ICON_URL ) ? $this->getConfigKey( self::ICON_URL ) : '';
			$position   = $this->hasConfigKey( self::POSITION ) ? $this->getConfigKey( self::POSITION ) : null;

			$hook_suffix = add_menu_page( $title, $menu_title, $capability, $slug, array( $this, 'render' ), $icon_url, $position );

			add_action( "load-{$hook_suffix}", array( $this, 'initialize' ) );
		};
	}
}
