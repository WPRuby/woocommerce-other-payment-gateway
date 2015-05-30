<?php 

class WC_Other_Payment_Gateway extends WC_Payment_Gateway{



	
	public function __construct(){
		$this->id = 'auspost';
		$this->method_title = __('Other Payment','woocommerce-other-payment-gateway');
		$this->title = __('Other Payment','woocommerce-other-payment-gateway');
		$this->has_fields = true;

		$this->init_form_fields();
		$this->init_settings();


		$this->enabled = $this->get_option('enabled');
		$this->title = $this->get_option('title');
		
		
	
		



		add_action('woocommerce_update_options_shipping_'.$this->id, array($this, 'process_admin_options'));


	}


	public function init_form_fields(){
		
		
				$this->form_fields = array(

					'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
					'type' 			=> 'checkbox',
					'label' 		=> __( 'Enable Australian Post', 'woocommerce' ),
					'default' 		=> 'yes'
					),
					'title' => array(
						'title' 		=> __( 'Method Title', 'woocommerce' ),
						'type' 			=> 'text',
						'description' 	=> __( 'This controls the title', 'woocommerce' ),
						'default'		=> __( 'Australian Post Shipping', 'woocommerce' ),
						'desc_tip'		=> true,
					),
					'description' => array(
										'title' => __( 'Customer Message', 'woocommerce' ),
										'type' => 'textarea',
										'default' => ''
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
		<h3><?php _e( 'Austrlia Post Settings', 'woocommerce' ); ?></h3>
		<table class="form-table">
		<?php
			// Generate the HTML For the settings form.
			$this->generate_settings_html();
		?>
		</table><!--/.form-table-->
		<p>
			
			<h3>Notes: </h3>
			<ol>
				<li><a target="_blank" href="http://auspost.com.au/parcels-mail/size-and-weight-guidelines.html">Weight and Size Guidlines </a>from Australia Post.</li>
				<li>Do you ship internationally? Do you charge handling fees? <a href="http://waseem-senjer.com/product/australian-post-woocommerce-extension-pro/" target="_blank">Get the PRO</a> version from this plugin with other cool features for <span style="color:green;">only 9$</span> </li>
				<li>If you encountered any problem with the plugin, please do not hesitate <a target="_blank" href="http://waseem-senjer.com/submit-ticket/">submitting a support ticket</a>.</li>
				<li>If you like the plugin please leave me a <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/australian-post-woocommerce-extension?filter=5#postform">★★★★★</a> rating. A huge thank you from me in advance!</li>
				
			</ol>

			
		</p>
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
	$order->add_order_note($_POST['p'],1);
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
		<p>
			<label>Option</label>
			<textarea name="p"></textarea>
		</p>

		<?php
	}
	


	





}