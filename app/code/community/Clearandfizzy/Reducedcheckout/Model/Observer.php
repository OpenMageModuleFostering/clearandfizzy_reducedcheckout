<?php

class Clearandfizzy_Reducedcheckout_Model_Observer extends Mage_Core_Model_Observer {

	public function checkReducedCheckout(Varien_Event_Observer $observer) {

		$enabled = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/isenabled');

		// return early if we're not enabled
		if ($enabled != true) {
			return;
		} // end

		$handles = $observer->getEvent()->getLayout()->getUpdate()->getHandles();

		// find the handle we're looking for
		if ( array_search('checkout_onepage_index', $handles) == true ) {

			$update = $observer->getEvent()->getLayout()->getUpdate();
			$update->addHandle('clearandfizzy_checkout_reduced');

			// should we remove the login step..
			if (
				Mage::getSingleton('customer/session')->isLoggedIn() == false && 
				Mage::helper('clearandfizzy_reducedcheckout/data')->isLoginStepGuestOnly() == true) {
					$update->addHandle('clearandfizzy_checkout_reduced_forceguestonly');
			} // end

			// should we remove the login step..
			if (
				Mage::getSingleton('customer/session')->isLoggedIn() == false &&
				Mage::helper('clearandfizzy_reducedcheckout/data')->isLoginStepCustom() == true) {
					$update->addHandle('clearandfizzy_checkout_reduced_login_custom');
			} // end			
			
			// should we remove the payment method step..
			if (Mage::helper('clearandfizzy_reducedcheckout/data')->skipShippingMethod() == true) {
				$update->addHandle('clearandfizzy_checkout_reduced_skip_shippingmethod');
			} // end

			// should we remove the shipping method step..
			if (Mage::helper('clearandfizzy_reducedcheckout/data')->skipPaymentMethod() == true) {
				$update->addHandle('clearandfizzy_checkout_reduced_skip_paymentmethod');
			} // end

		} // end
		
		
		//checkout_onepage_success
		if ( array_search('checkout_onepage_success', $handles) == true ) {
			
			$update = $observer->getEvent()->getLayout()->getUpdate();
			$update->addHandle('clearandfizzy_checkout_reduced');

			// enable register on order success..
			// only change the handle 
			if ( $this->_isValidGuest() && Mage::helper('clearandfizzy_reducedcheckout/data')->guestsCanRegisterOnOrderSuccess() == true) {
				$update->addHandle('clearandfizzy_checkout_reduced_success_register');
			} // end
			
		} // end if					

		return;

	} // end

	/**
	 * Returns true if the the user is not logged in and email doesn't already exist.
	 * @return boolean
	 */
	protected function _isValidGuest() {
		if (Mage::getSingleton('customer/session')->isLoggedIn() || $this->_customerExists() ) {
			return false;
		} // end
		
		return true;
	} // end 

	/**
	 * Returns true if the last order's email address already exists
	 * @return boolean
	 */
	protected function _customerExists() {
		$helper = Mage::helper('clearandfizzy_reducedcheckout/order');
		$email 	= $helper->getEmail();
		
		$customer = Mage::getSingleton('customer/customer')
								->setStore(Mage::app()->getStore())
								->loadByEmail($email);

		if ($customer->getId()) {
			return true;
		} // end 
		
		return false;
		
	}
	

} // end

