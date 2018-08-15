<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/wackywombaat12
 * @since      1.0.0
 *
 * @package    Quick_Order
 * @subpackage Quick_Order/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Quick_Order
 * @subpackage Quick_Order/includes
 * @author     Jack Boyle <jackboyle85@gmail.com>
 */
class Quick_Order_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::create_page( 'Quick Order', 'publish', 'page', 'quick-order', '[quick_order_page]' );

	}

	/**
	 * Create main service page and return ID.
	 *
	 * @param      string $title          The title of the page.
	 * @param      string $post_status    The status of the page.
	 * @param      string $post_type      The type of the post.
	 * @param      string $slug           The slug of the page.
	 * @param      string $content        The content of the page.
	 */
	public static function create_page( $title, $post_status, $post_type, $slug, $content ) {

		$page = get_page_by_path( $slug, OBJECT, 'page' );

		if ( ! isset( $page ) ) {

			$new_post = array(
				'post_title'   => $title,
				'post_status'  => $post_status,
				'post_type'    => $post_type,
				'post_content' => $content,
			);

			wp_insert_post( $new_post );
		}
	}

}
