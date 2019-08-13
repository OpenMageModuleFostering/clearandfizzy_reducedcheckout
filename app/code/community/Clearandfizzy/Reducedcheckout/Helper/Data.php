<?php

class Clearandfizzy_Reducedcheckout_Helper_Data extends Mage_Core_Helper_Abstract {

	public function getPaymentMethod() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/default_payment');
		return $value;
	} // end

	public function getShippingMethod() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/default_shipping');
		return $value;
	} // end

	public function isGuestCheckoutOnly() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/guestcheckoutonly');
		return $value;
	} // end

	/**
	 * Returns true if we should force the payment method
	 * @return boolean
	 */
	public function skipPaymentMethod() {
		$code = $this->getPaymentMethod();

		switch ($code) {

			case "noskip":
				return false;
			break;

			default:
				return true;
			break;

		} // end sw

	} // end fun

	/**
	 * Returns true if we should force the shipping method
	 * @return boolean
	 */
	public function skipShippingMethod() {
		$code = $this->getShippingMethod();

		switch ($code) {

			case "noskip":
				return false;
			break;

			default:
				return true;
			break;

		} // end sw

	} // end fun

}

