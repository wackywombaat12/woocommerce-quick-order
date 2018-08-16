<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/wackywombaat12
 * @since      1.0.0
 *
 * @package    Quick_Order
 * @subpackage Quick_Order/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quick_Order
 * @subpackage Quick_Order/public
 * @author     Jack Boyle <jackboyle85@gmail.com>
 */
class Quick_Order_Endpoints_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name       The name of the plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Function quick_order_get_products_by_category.
	 * Ajax handler retrieving products by category.
	 */
	public function quick_order_api_init() {
		register_rest_route( 'quick-order/v1', '/categories', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'quick_order_get_product_categories' ),
		) );
		register_rest_route( 'quick-order/v1', '/products/(?P<id>\d+)/(?P<page>\d+)', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'quick_order_get_products_by_category' ),
		) );
	}

	/**
	 * Function quick_order_get_products_by_category.
	 * Ajax handler retrieving product categories.
	 *
	 * @param array $data Options for the function.
	 * @return string|null List of products or null if none.
	 */
	public function quick_order_get_products_by_category( $data ) {

		$page        = $data['page'];
		$category_id = $data['id'];

		$category = get_term_by( 'id', $category_id, 'product_cat' );
		if ( $category ) {
			$cat_slug = $category->slug;

			// Get draft products.
			$args     = array(
				'category' => [ $cat_slug ],
				'paginate' => true,
				'return'   => 'ids',
				'limit'    => 20,
				'page'     => $page,
			);
			$products = wc_get_products( $args );

			$product_ids            = $products->products;
			$image_size             = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_gallery_thumbnail' );
			$currency_symbol        = get_woocommerce_currency_symbol();
			$final_data['products'] = [];
			foreach ( $product_ids as $id ) {
				$product = new WC_Product( $id );
				$status  = $product->get_status();

				// Only send published products.
				if ( 'publish' === $status ) {
					$url = get_the_post_thumbnail_url( $id, $image_size );
					if ( ! $url ) {
						$url = wc_placeholder_img_src( 'woocommerce_gallery_thumbnail' );
					}
					$product_data = [
						'id'     => $id,
						'sku'    => $product->get_sku(),
						'name'   => $product->get_name(),
						'price'  => $product->get_price_html(),
						'image'  => $url,
						'page'   => $data['page'],
						'status' => $product->get_stock_status(),

					];
					array_push( $final_data['products'], $product_data );
				}
			}
			$final_data['totalPages'] = $products->max_num_pages;
			return $final_data;
		}
		return null;
	}

	/**
	 * Function quick_order_get_product_categories.
	 * Ajax handler retrieving product categories.
	 */
	public function quick_order_get_product_categories() {

		$orderby    = 'name';
		$order      = 'asc';
		$hide_empty = true;
		$cat_args   = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'fields'     => 'id=>name',
		);

		$product_categories = get_terms( 'product_cat', $cat_args );

		if ( ! empty( $product_categories ) ) {
			return $product_categories;
		}
	}

}
