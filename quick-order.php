<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/wackywombaat12
 * @since             1.0.0
 * @package           Quick_Order
 *
 * @wordpress-plugin
 * Plugin Name:       Quick Order
 * Plugin URI:        https://github.com/wackywombaat12
 * Description:       Quick Ordering for products using WooCommerce.
 * Version:           1.0.0
 * Author:            Jack Boyle
 * Author URI:        https://github.com/wackywombaat12
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quick-order
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	/**
	 * Currently plugin version.
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * Rename this for your plugin and update it as you release new versions.
	 */
	define( 'QUICK_ORDER_VERSION', '1.0.0' );

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-quick-order-activator.php
	 */
	function activate_quick_order() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-order-activator.php';
		Quick_Order_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-quick-order-deactivator.php
	 */
	function deactivate_quick_order() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-quick-order-deactivator.php';
		Quick_Order_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_quick_order' );
	register_deactivation_hook( __FILE__, 'deactivate_quick_order' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-quick-order.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_quick_order() {

		$plugin = new Quick_Order();
		$plugin->run();

	}
	run_quick_order();
}
