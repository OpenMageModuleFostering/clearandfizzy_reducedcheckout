<?php
require_once "Mage/Checkout/controllers/OnepageController.php";
class Clearandfizzy_Reducedcheckout_OnepageController extends Mage_Checkout_OnepageController
{
	public $layout;
	protected $_helper;


	public function _construct() {
		parent::_construct();
		$this->_helper = Mage::helper('clearandfizzy_reducedcheckout');
	} // end

	/**
	 * Save checkout method - set to guest method
	 */
	public function saveMethodAction()
	{
		if ($this->_expireAjax()) {
			return;
		} // end if


		if ($this->getRequest()->isPost()) {
			$method = $this->getCheckoutMethod();
			$result = $this->getOnepage()->saveCheckoutMethod($method);
		} // end if

	} // end if


	private function getCheckoutMethod() {

		switch ( $this->_helper->isGuestCheckoutOnly() ) {

			case true:
				$method = "guest";
			break;

			default:
				$method = $this->getRequest()->getPost('method');
			break;

		} // end

		return $method;

	} /// end


	/**
	 *
	 * $gotonext = false forces the method not to go to the next section and returning to the calling method
	 *
	 * (non-PHPdoc)
	 * @see Mage_Checkout_OnepageController::saveShippingMethodAction()
	 */
	public function saveShippingMethodAction($gotonext = true ) {

		if ($this->_expireAjax()) {
			return;
		} // end if

		// this is the default way
		$shipping = $this->getRequest()->getPost('shipping_method', '');

		// override the default value if we need to
		if ( $this->_helper->skipShippingMethod() == true) {
			$shipping = $this->_helper->getShippingMethod();
		} // end if

		// set the shipping method
		$result = $this->getOnepage()->saveShippingMethod($shipping);

		// calculations for the checkout totals
		$this->getOnepage()->getQuote()->collectTotals();
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		$this->getOnepage()->getQuote()->collectTotals()->save();

		// save shipping method event
		Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
				array('request'=>$this->getRequest(),
						'quote'=>$this->getOnepage()->getQuote()));


		$this->getOnepage()->getQuote()->setTotalsCollectedFlag(false);

		// attempt to load the next section
		if ( $gotonext == true ) {
			$result = $this->getNextSection($result, $current = 'shippingmethod');
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		} // end if


	} // end

	/**
	 * (non-PHPdoc)
	 * @see Mage_Checkout_OnepageController::savePaymentAction()
	 */
	public function savePaymentAction( $gotonext = true ) {

		if ($this->_expireAjax()) {
			return;
		} // end if

		// this is the default way
		$data = $this->getRequest()->getPost('payment', false);

		// override the default value if we need to
		if ( $this->_helper->skipPaymentMethod() == true) {
			$payment = $this->_helper->getPaymentMethod();
			$data = array('method' => $payment);
		} // end if

 		$result = $this->getOnepage()->savePayment($data);

		// get section and redirect data
		$redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();

		// attempt to load the next section
		if ( $gotonext == true ) {
			$result = $this->getNextSection($result, $current = 'payment');
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		} // end if

	} // end


	public function saveShippingAction($gotosection = true) {
		if ($this->_expireAjax()) {
			return;
		}

		if ($this->getRequest()->isPost()) {

			$data = $this->getRequest()->getPost('shipping', array());
			$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);

			// save the billing address info
			$result = $this->getOnepage()->saveShipping($data, $customerAddressId);

			// set the checkout method
			$this->saveMethodAction();

			// attempt to load the next section
			if ( $gotonext == true ) {
				$result = $this->getNextSection($result, $current = 'billing');
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
			} // end if

		}


	} // end

	/**
	 * save checkout billing address
	 */
	public function saveBillingAction()
	{

		if ($this->_expireAjax()) {
			return;
		}

		if ($this->getRequest()->isPost()) {

			if ( $this->_helper->isGuestCheckoutOnly() == true) {
				// set the checkout method
				$this->saveMethodAction();
			} // end if


			$data = $this->getRequest()->getPost('billing', array());
			$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

			if (isset($data['email'])) {
				$data['email'] = trim($data['email']);
			} // end if

			// save the billing address info
			$result = $this->getOnepage()->saveBilling($data, $customerAddressId);

			// render the onepage review
			if (!isset($result['error'])) {

				/* check quote for virtual */
				if ($this->getOnepage()->getQuote()->isVirtual()) {

					// find out which section we should go to next
					$result = $this->getNextSection($result, $current = 'billing');

				} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {

					// find out which section we should go to next
					$result = $this->getNextSection($result, $current = 'billing');
					$result['duplicateBillingInfo'] = 'true';

				} else {

					// go to the shipping section
					$result['goto_section'] = 'shipping';

				} // end if
			} // end

			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	} // end


	/**
	 * (non-PHPdoc)
	 * @see Mage_Checkout_OnepageController::_getReviewHtml()
	 */
	protected function _getReviewHtml() {
	 	$layout = $this->getLayout();
		$update = $layout->getUpdate();
		$update->merge('checkout_onepage_review');

		$layout->generateXml();
		$layout->generateBlocks();

		$output = $layout->getBlock('root')->toHtml();
		return $output;

	} // end

	public function progressAction()
	{
		$layout = $this->getLayout();
		$update = $layout->getUpdate();
		$update->load('checkout_onepage_progress');
		$layout->generateXml();
		$layout->generateBlocks();
		$output = $layout->getOutput();
		$this->renderLayout();
	}


	/**
	 *
	 * @param unknown $current_step
	 * @return string
	 */
	private function getNextSection($result, $current) {

		// set the shipping method
		if ( $this->_helper->skipShippingMethod() == true) {
			$this->saveShippingMethodAction($gotonext = false);
		} // end

		// set the payment method
		if ( $this->_helper->skipPaymentMethod() == true) {
			$this->savePaymentAction( $gotonext = false );
		} // end if

		switch ($current) {

			case "billing":
				if ($this->_helper->skipShippingMethod() == true && $this->_helper->skipPaymentMethod() == true) {

					$result['goto_section'] = 'review';
					$result['allow_sections'] = array('review');
					$result['update_section'] = array(
							'name' => 'review',
							'html' => $this->_getReviewHtml()
					);

				} elseif ( $this->_helper->skipShippingMethod() == true && $this->_helper->skipPaymentMethod() == false ) {

	                $result['goto_section'] = 'payment';
	                $result['allow_sections'] = array('payment');
	                $result['update_section'] = array(
	                    'name' => 'payment-method',
	                    'html' => $this->_getPaymentMethodsHtml()
	                );

				} elseif ( $this->_helper->skipShippingMethod() == false ) {

					$result['goto_section'] = 'shipping_method';
					$result['allow_sections'] = array('shipping');
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

				}// end
			break;

			case "shippingmethod":

				if ( $this->_helper->skipPaymentMethod() == true ) {

					$result['goto_section'] = 'review';
					$result['allow_sections'] = array('review');
					$result['update_section'] = array(
							'name' => 'review',
							'html' => $this->_getReviewHtml()
					);

				} elseif (  $this->_helper->skipPaymentMethod() == false ) {

					$result['goto_section'] = 'payment';
					$result['allow_sections'] = array('payment');
					$result['update_section'] = array(
							'name' => 'payment-method',
							'html' => $this->_getPaymentMethodsHtml()
					);
				} // end

			break;

			case "payment":
				$result['goto_section'] = 'review';
				$result['allow_sections'] = array('review');
				$result['update_section'] = array(
						'name' => 'review',
						'html' => $this->_getReviewHtml()
				);
			break;

		} // end sw

		return $result;

	} // end


} // end class

