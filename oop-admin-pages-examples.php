<?php
/**
 * Examples for the OOP Admin Pages library, as a WordPress plugin.
 *
 * @package Leaves_And_Love\OOP_Admin_Pages\Examples
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: OOP Admin Pages Examples
 * Plugin URI:  https://github.com/felixarntz/oop-admin-pages
 * Description: Examples for the OOP Admin Pages library, as a WordPress plugin.
 * Version:     1.0.0
 * Author:      Felix Arntz
 * Author URI:  https://leaves-and-love.net
 * License:     GNU General Public License v2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: oop-admin-pages
 * Tags:        admin pages, oop, library, wordpress
 */

defined( 'ABSPATH' ) || exit;

use Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Collection\Base_Admin_Page_Collection as Page_Collection;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page_Factory\WordPress_Admin_Page_Factory as Page_Factory;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Page as Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Menu_Page as Menu_Page;
use Leaves_And_Love\OOP_Admin_Pages\Admin_Page\WordPress_Admin_Submenu_Page as Submenu_Page;
use BrightNucleus\Config\Config;

if ( ! interface_exists( 'Leaves_And_Love\OOP_Admin_Pages\Admin_Page' ) ) {
	if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
	} else {
		wp_die( 'OOP Admin Pages library could not be loaded!' );
	}
}

add_action( 'init', function() {
	if ( ! is_admin() ) {
		return;
	}

	// This instantiates the WordPress admin page factory (since we're in WordPress, of course).
	$factory = new Page_Factory();

	// Instantiate a new admin page collection with a configuration.
	$collection = new Page_Collection( new Config( array(

		// This tells the collection to use our above factory.
		Page_Collection::FACTORY => $factory,

		// The following array is the actual admin pages configuration.
		Page_Collection::PAGES   => array(

			// This is a very basic admin page that renders as a toplevel menu.
			array(
				Menu_Page::SLUG            => 'my-menu-page',
				Menu_Page::TITLE           => __( 'Menu Page', 'oop-admin-pages' ),
				Menu_Page::MENU_TITLE      => __( 'Menu', 'oop-admin-pages' ),
				Menu_Page::CAPABILITY      => 'manage_options',
				Menu_Page::RENDER_CALLBACK => function( $config ) {
					?>
					<div class="wrap">
						<h1><?php echo esc_html( $config['title'] ); ?></h1>
						<p class="description"><?php esc_html_e( 'This is a menu page.', 'oop-admin-pages' ); ?></p>
					</div>
					<?php
				},
			),

			// This is a very basic admin page that renders as a submenu.
			array(
				Submenu_Page::SLUG            => 'my-submenu-page',
				Submenu_Page::TITLE           => __( 'Submenu Page', 'oop-admin-pages' ),
				Submenu_Page::MENU_TITLE      => __( 'Submenu', 'oop-admin-pages' ),
				Submenu_Page::CAPABILITY      => 'manage_options',
				Submenu_Page::PARENT_SLUG     => 'my-menu-page',
				Submenu_Page::RENDER_CALLBACK => function( $config ) {
					?>
					<div class="wrap">
						<h1><?php echo esc_html( $config['title'] ); ?></h1>
						<p class="description"><?php esc_html_e( 'This is a submenu page.', 'oop-admin-pages' ); ?></p>
					</div>
					<?php
				},
			),

			// This is a very basic admin page that does not have any menu entry.
			array(
				Page::SLUG              => 'my-page',
				Page::TITLE             => __( 'Page without Menu', 'oop-admin-pages' ),
				Page::CAPABILITY        => 'manage_options',
				Page_Factory::SKIP_MENU => true,
				Page::RENDER_CALLBACK   => function( $config ) {
					?>
					<div class="wrap">
						<h1><?php echo esc_html( $config['title'] ); ?></h1>
						<p class="description"><?php esc_html_e( 'This is a page that does not have any menu entry.', 'oop-admin-pages' ); ?></p>
					</div>
					<?php
				},
			),

			// This is a little more realistic admin submenu page in the "Tools" menu that allows you to send an email through WordPress.
			array(
				Submenu_Page::SLUG                => 'send-email',
				Submenu_Page::TITLE               => __( 'Send Email', 'oop-admin-pages' ),
				Submenu_Page::CAPABILITY          => 'manage_options',
				Submenu_Page::PARENT_SLUG         => 'tools.php',
				Submenu_Page::RENDER_CALLBACK     => function( $config ) {
					?>
					<div class="wrap">
						<h1><?php echo esc_html( $config['title'] ); ?></h1>

						<p class="description">
							<?php esc_html_e( 'This form allows you to send an email through WordPress.', 'oop-admin-pages' ); ?>
						</p>

						<?php
						if ( ! empty( $_GET['result'] ) ) {
							switch ( $_GET['result'] ) {
								case 'success':
									$class   = 'notice notice-success';
									$message = __( 'The email was sent successfully!', 'oop-admin-pages' );
									break;
								case 'invalid_nonce':
									$class   = 'notice notice-error';
									$message = __( 'The email was not sent because of an invalid nonce!', 'oop-admin-pages' );
									break;
								case 'invalid_email':
									$class   = 'notice notice-error';
									$message = __( 'The email was not sent because you did not specify a valid email address!', 'oop-admin-pages' );
									break;
								default:
									$class   = 'notice notice-error';
									$message = __( 'The email was not sent due to an unknown error!', 'oop-admin-pages' );
							}

							?>
							<div class="<?php echo esc_attr( $class ); ?>">
								<p><?php echo esc_html( $message ); ?></p>
							</div>
							<?php
						}
						?>

						<form method="POST">
							<table class="form-table">
								<tbody>
									<tr>
										<th scope="row">
											<label for="email-address"><?php esc_html_e( 'Email Address', 'oop-admin-pages' ); ?></label>
										</th>
										<td>
											<input type="email" id="email-address" name="email_address" class="regular-text" />
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="email-subject"><?php esc_html_e( 'Subject', 'oop-admin-pages' ); ?></label>
										</th>
										<td>
											<input type="text" id="email-subject" name="email_subject" class="regular-text" />
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label for="email-message"><?php esc_html_e( 'Message', 'oop-admin-pages' ); ?></label>
										</th>
										<td>
											<textarea id="email-message" name="email_message" class="regular-text" rows="12"></textarea>
										</td>
									</tr>
								</tbody>
							</table>

							<?php
							wp_nonce_field( 'send-email', 'email_nonce' );
							submit_button( __( 'Send', 'oop-admin-pages' ) );
							?>
						</form>
					</div>
					<?php
				},
				Submenu_Page::INITIALIZE_CALLBACK => function() {
					if ( empty( $_POST ) ) {
						return;
					}

					$post_data = wp_unslash( $_POST );

					if ( empty( $post_data['email_nonce'] ) || ! wp_verify_nonce( $post_data['email_nonce'], 'send-email' ) ) {
						$result = 'invalid_nonce';
					} else {
						$address = is_email( $post_data['email_address'] );
						$subject = $post_data['email_subject'];
						$message = $post_data['email_message'];

						if ( ! $address ) {
							$result = 'invalid_email';
						} else {
							$sent = wp_mail( $address, $subject, $message );

							if ( ! $sent ) {
								$result = 'unknown_error';
							} else {
								$result = 'success';
							}
						}
					}

					wp_safe_redirect( add_query_arg( 'result', $result, wp_get_referer() ) );
					exit;
				},
			),
		),
	) ) );

	$collection->register();
});
