<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Customized Payment Gateway
 * Plugin URI:        https://waseem-senjer.com/product/woocommerce-customized-payment-gateway-pro/
 * Description:       Do NOT miss any sale!
 * Version:           1.0.2
 * Author:            Waseem Senjer
 * Author URI:        http://waseem-senjer.com
 * Text Domain:       woocommerce-other-payment-gateway
 * Domain Path: /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

define('WCCUSTOMPAYMENT_LITE_URL', plugin_dir_url(__FILE__));
$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if(in_array('woocommerce/woocommerce.php', $active_plugins)){


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