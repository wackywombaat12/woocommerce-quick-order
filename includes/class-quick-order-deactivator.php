<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/wackywombaat12
 * @since      1.0.0
 *
 * @package    Quick_Order
 * @subpackage Quick_Order/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Quick_Order
 * @subpackage Quick_Order/includes
 * @author     Jack Boyle <jackboyle85@gmail.com>
 */
class Quick_Order_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		self::delete_page( 'quick-order' );
	}

	/**
	 * Delete Page Quick Order.
	 *
	 * @param      string $slug           The slug of the page.
	 */
	public static function delete_page( $slug ) {

		$page = get_page_by_path( $slug, OBJECT, 'page' );

		if ( isset( $page ) ) {
			wp_delete_post( $page->ID, true );
		}
	}

}
