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
class Quick_Order_Public {

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
	 * Quick Order Shortcode.
	 */
	public function quick_order_page() {
		ob_start();
		$page        = 1;
		$category_id = 17;

		$category = get_term_by( 'id', $category_id, 'product_cat' );
		if ( $category ) {
			$cat_slug = $category->slug;
			$args     = array(
				'category' => [ $cat_slug ],
				'paginate' => true,
				'return'   => 'ids',
				'page'     => $page,
			);
			$products = wc_get_products( $args );
			$product_ids            = $products->products;
			$image_size             = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_gallery_thumbnail' );
			$currency_symbol        = get_woocommerce_currency_symbol();
			$final_data['products'] = [];
			
			foreach ( $product_ids as $id ) {
				$product = new WC_Product( $id );
				$url     = get_the_post_thumbnail_url( $id, $image_size );
				if ( ! $url ) {
					$url = wc_placeholder_img_src( 'woocommerce_gallery_thumbnail' );
				}
				$product_data = [
					'id'      => $id,
					'sku'     => $product->get_sku(),
					'name'    => $product->get_name(),
					'price'   => $product->get_price(),
					'image'   => $url,
					'page'    => $data['page'],
					'status'  => $product->get_stock_status(),

				];
				array_push( $final_data['products'], $product_data );
			}
			print_r( $final_data );
		}
		?>
			<input id="quick_order_nonce" type="hidden" name="quick_order_nonce" value="'<?php echo esc_html( wp_create_nonce( 'quick-order-nonce' ) ); ?>'">
			<div id="quick-order-app">	
			</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( is_page( 'quick-order' ) ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quick-order-public.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quick_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quick_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( is_page( 'quick-order' ) ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../build/bundle.js', [ 'jquery' ], $this->version, true );
		}

	}

}
