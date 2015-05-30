<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Other Payment Gateway
 * Plugin URI:        http://waseem-senjer.com/
 * Description:       Do NOT miss any sale!
 * Version:           1.0.0
 * Author:            Waseem Senjer
 * Author URI:        http://waseem-senjer.com
 * Text Domain:       woocommerce-other-payment-gateway
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


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

}