<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Custom Payment Gateway
 * Plugin URI:        https://wpruby.com/plugin/woocommerce-custom-payment-gateway-pro/
 * Description:       Design your own payment gateway by drag and drop.
 * Version:           1.4.0
 * WC requires at least: 3.0
 * WC tested up to: 9.4
 * Requires Plugins: woocommerce
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * Text Domain:       woocommerce-other-payment-gateway
 * Domain Path: /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;

$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if(wpruby_custom_payment_is_woocommerce_active()){
	add_filter('woocommerce_payment_gateways', 'add_other_payment_gateway');
	function add_other_payment_gateway( $gateways ){
		$gateways[] = 'WC_Other_Payment_Gateway';
		return $gateways;
	}

	add_action('plugins_loaded', 'init_other_payment_gateway');
	function init_other_payment_gateway(){
		require 'class-woocommerce-other-payment-gateway.php';
	}

	add_action( 'plugins_loaded', 'other_payment_load_plugin_textdomain' );
	function other_payment_load_plugin_textdomain() {
	  load_plugin_textdomain( 'woocommerce-other-payment-gateway', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}



}


/**
 * @return bool
 */
function wpruby_custom_payment_is_woocommerce_active()
{
	$active_plugins = (array) get_option('active_plugins', array());

	if (is_multisite()) {
		$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	}

	return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
}

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

add_action( 'woocommerce_blocks_loaded',  function () {
    require_once plugin_dir_path(__FILE__). 'blocks/class-other-payment-block.php';
    add_action(
        'woocommerce_blocks_payment_method_type_registration',
        function( PaymentMethodRegistry $payment_method_registry ) {
            $payment_method_registry->register( new Other_Payment_Block );
        }
    );
});


add_action( 'before_woocommerce_init', function() {
    if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', __FILE__, true );
    }
} );
