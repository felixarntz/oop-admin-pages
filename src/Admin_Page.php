<?php
/**
 * Admin_Page interface
 *
 * @package Leaves_And_Love\OOP_Admin_Pages
 * @since 1.0.0
 */

namespace Leaves_And_Love\OOP_Admin_Pages;

/**
 * Interface representing an admin page.
 *
 * @since 1.0.0
 */
interface Admin_Page {

	/**
	 * Gets the slug of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page slug.
	 */
	public function get_slug() : string;

	/**
	 * Gets the title of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page title.
	 */
	public function get_title() : string;

	/**
	 * Gets the URL of the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Admin page URL.
	 */
	public function get_url() : string;

	/**
	 * Registers the admin page within the environment.
	 *
	 * @since 1.0.0
	 */
	public function register();

	/**
	 * Initializes the admin page on pageload.
	 *
	 * This method must be called before any output is printed.
	 *
	 * @since 1.0.0
	 */
	public function initialize();

	/**
	 * Renders the admin page content.
	 *
	 * @since 1.0.0
	 */
	public function render();
}
