<?php

use Exception;
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;


/**
 * Cheque payment method integration
 *
 * @since 2.6.0
 */
final class Other_Payment_Block extends AbstractPaymentMethodType {

    private $gateway;
    /**
     * Payment method name defined by payment methods extending this class.
     *
     * @var string
     */
    protected $name = 'other_payment';


    /**
     * Initializes the payment method type.
     */
    public function initialize() {
        $this->settings = get_option( "woocommerce_{$this->name}_settings", [] );

    }

    /**
     * Returns if this payment method should be active. If false, the scripts will not be enqueued.
     *
     * @return boolean
     */
    public function is_active() {
        return ! empty( $this->settings[ 'enabled' ] ) && 'yes' === $this->settings[ 'enabled' ];
    }


    public function get_payment_method_script_handles() {

        $asset_path   = plugin_dir_path( __DIR__ ) . 'blocks/build/index.asset.php';
        $version      = null;
        $dependencies = array();
        if( file_exists( $asset_path ) ) {
            $asset        = require $asset_path;
            $version      = isset( $asset[ 'version' ] ) ? $asset[ 'version' ] : $version;
            $dependencies = isset( $asset[ 'dependencies' ] ) ? $asset[ 'dependencies' ] : $dependencies;
        }

        wp_register_script(
            'wc-other-payment-integration',
            plugin_dir_url( __DIR__ ) . 'blocks/build/index.js',
            $dependencies,
            $version,
            true
        );

        return array( 'wc-other-payment-integration' );

    }


    /**
     * Returns an array of key=>value pairs of data made available to the payment methods script.
     *
     * @return array
     */
    public function get_payment_method_data() {
        return [
            'title'       => $this->get_setting( 'title' ),
            'description' => $this->get_setting( 'description' ),
            'is_required' => $this->get_setting( 'text_box_required' ),
            'hide_text_box' => $this->get_setting( 'hide_text_box' ),
            'supports'    => $this->get_supported_features(),
        ];
    }
}