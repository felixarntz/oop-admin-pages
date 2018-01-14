<?php
/**
 * WordPress_Admin_Panels class
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Panels;

use Leaves_And_Love\OOP_Admin_Pages\Exception\Invalid_Admin_Panel_Exception;

/**
 * Class holding the available WordPress admin panels.
 *
 * @since 1.0.0
 */
final class WordPress_Admin_Panels {

	const SITE    = 'site';
	const NETWORK = 'network';
	const USER    = 'user';

	/**
	 * Available admin panels.
	 *
	 * @since 1.0.0
	 * @static
	 * @var array
	 */
	private static $panels = array();

	/**
	 * Whether the available admin panels have been initialized yet.
	 *
	 * @since 1.0.0
	 * @static
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * Gets an instance of an admin panel.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $slug Admin panel identifier.
	 * @return WordPress_Admin_Panel Admin panel instance.
	 *
	 * @throws Invalid_Admin_Panel_Exception Thrown when admin panel identifier is invalid.
	 */
	public static function get_panel( string $slug ) : WordPress_Admin_Panel {
		self::maybe_initialize();

		if ( ! isset( self::$panels[ $slug ] ) ) {
			throw new Invalid_Admin_Panel_Exception( sprintf( 'An admin panel with the identifier %s is not available.', $slug ) );
		}

		return self::$panels[ $slug ];
	}

	/**
	 * Gets the current admin panel.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @return WordPress_Admin_Panel Admin panel instance.
	 */
	public static function get_current_panel() : WordPress_Admin_Panel {
		switch ( true ) {
			case is_user_admin():
				return self::get_panel( self::USER );
			case is_network_admin():
				return self::get_panel( self::NETWORK );
			default:
				return self::get_panel( self::SITE );
		}
	}

	/**
	 * Instantiates the available admin panels as necessary.
	 *
	 * @since 1.0.0
	 * @static
	 */
	private static function maybe_initialize() {
		if ( self::$initialized ) {
			return;
		}

		self::initialize();

		self::$initialized = true;
	}

	/**
	 * Instantiates the available admin panels.
	 *
	 * @since 1.0.0
	 * @static
	 */
	private static function initialize() {
		self::$panels = array(
			self::SITE    => new WordPress_Site_Admin_Panel(),
			self::NETWORK => new WordPress_Network_Admin_Panel(),
			self::USER    => new WordPress_User_Admin_Panel(),
		);
	}
}
