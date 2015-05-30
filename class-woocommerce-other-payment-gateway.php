<?php 

class WC_Other_Payment_Gateway extends WC_Payment_Gateway{



	
	public function __construct(){
		$this->id = 'other_payment';
		$this->method_title = __('Other Payment','woocommerce-other-payment-gateway');
		$this->title = __('Other Payment','woocommerce-other-payment-gateway');
		$this->has_fields = true;

		$this->init_form_fields();
		$this->init_settings();


		$this->enabled = $this->get_option('enabled');
		$this->title = $this->get_option('title');
		$this->description = $this->get_option('description');
		
		
	
		



		add_action('woocommerce_update_options_payment_gateways_'.$this->id, array($this, 'process_admin_options'));


	}


	public function init_form_fields(){
		
		
				$this->form_fields = array(

					'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Enable Other Payment', 'woocommerce' ),
					'default' 		=> 'yes'
					),
					'title' => array(
						'title' 		=> __( 'Method Title', 'woocommerce' ),
						'type' 			=> 'text',
						'description' 	=> __( 'This controls the title', 'woocommerce' ),
						'default'		=> __( 'Other Payment', 'woocommerce' ),
						'desc_tip'		=> true,
					),
					'description' => array(
						'title' => __( 'Customer Message', 'woocommerce' ),
						'type' => 'textarea',
						'default' => 'None of the other payment options are suitable for you? please drop us a note about your favourable payment option and we will contact you as soon as possible.',
						'description' 	=> __( 'The message which you want it to appear to the customer in the checkout page.', 'woocommerce' ),

					)
			 );
		
		

	}

	
	
	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function admin_options() {

		?>
		<h3><?php _e( 'Other Payment Settings', 'woocommerce' ); ?></h3>
		<table class="form-table">
		<?php
			// Generate the HTML For the settings form.
			$this->generate_settings_html();
		?>
		</table><!--/.form-table-->
		<?php
	}

	public function is_available(  ){
		return true;
	}

	function process_payment( $order_id ) {
	global $woocommerce;
	$order = new WC_Order( $order_id );

	// Mark as on-hold (we're awaiting the cheque)
	$order->update_status('on-hold', __( 'Awaiting payment', 'woocommerce' ));

	// Reduce stock levels
	$order->reduce_order_stock();
	$order->add_order_note(esc_html($_POST[ $this->id.'-admin-note']),1);
	// Remove cart
	$woocommerce->cart->empty_cart();

	// Return thankyou redirect
	return array(
		'result' => 'success',
		'redirect' => $this->get_return_url( $order )
	);


	
}

	public function payment_fields(){
		
		?>
		<fieldset>
			<p class="form-row form-row-wide">
				<label for="<?php echo $this->id; ?>-admin-note"><?php echo esc_attr($this->description); ?> <span class="required">*</span></label>
				<textarea id="<?php echo $this->id; ?>-admin-note" class="input-text" type="text" name="<?php echo $this->id; ?>-admin-note"></textarea>
			</p>						
			<div class="clear"></div>
		</fieldset>
		

		<?php
	}
	


	





}