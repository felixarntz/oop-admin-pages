<?php
/**
 * WordPress_Admin_Page_Factory class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Factory;

use Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Factory;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Menu_Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Submenu_Page;
use Leaves_And_Love\OOP_Admin_Pages\Exception\Config_Invalid_Exception;
use BrightNucleus\Config\ConfigInterface as Config;

/**
 * Class to create WordPress admin page instances.
 *
 * @since 1.0.0
 */
class WordPress_Admin_Page_Factory implements Admin_Page_Factory {

	const SKIP_MENU = 'skip_menu';

	/**
	 * Creates a new admin page instance.
	 *
	 * @since 1.0.0
	 *
	 * @param Config $config Admin page configuration. Must contain keys 'slug' (admin page identifier) 'title',
	 *                       'render_callback' (callable that receives the configuration as sole parameter) and
	 *                       'capability'. May also contain keys 'initialize_callback', 'menu_title', 'icon_url',
	 *                       'position', 'parent_slug', and 'skip_menu'. If 'skip_menu' is present, the admin page
	 *                       will not have any menu entry. If 'parent_slug' is present, the admin page will have a
	 *                       submenu entry. Otherwise the admin page will have a toplevel menu entry.
	 * @return Admin_Page Admin page instance.
	 *
	 * @throws Config_Invalid_Exception Thrown when the configuration is invalid.
	 */
	public function create_page( Config $config ) : Admin_Page {
		if ( $config->hasKey( self::SKIP_MENU ) ) {
			return new WordPress_Admin_Page( $config );
		}

		if ( $config->hasKey( WordPress_Admin_Submenu_Page::PARENT_SLUG ) ) {
			return new WordPress_Admin_Submenu_Page( $config );
		}

		return new WordPress_Admin_Menu_Page( $config );
	}
}
