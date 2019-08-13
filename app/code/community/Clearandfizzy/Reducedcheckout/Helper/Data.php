<?php

class Clearandfizzy_Reducedcheckout_Helper_Data extends Mage_Core_Helper_Abstract {

	const LOGIN_STEP_DEFAULT 	= 0;
	const LOGIN_STEP_GUESTONLY 	= 1;
	const LOGIN_STEP_CUSTOM 	= 2;
	
	public function getPaymentMethod() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/default_payment');
		return $value;
	} // end

	public function getShippingMethod() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/default_shipping');
		return $value;
	} // end

	public function isLoginStepDefault() {
		return ( $this->getLoginStepType() == self::LOGIN_STEP_DEFAULT);
	} // end
	
	public function isLoginStepGuestOnly() {
		return ( $this->getLoginStepType() == self::LOGIN_STEP_GUESTONLY);
	} // end
	
	public function isLoginStepCustom() {
		return ( $this->getLoginStepType() == self::LOGIN_STEP_CUSTOM);
	} // end 
	
	protected function getLoginStepType() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/loginstep_type');
		return $value;
	} // end	
	
	public function isFix28112Enabled() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/enable28112fix');
		return $value;
	} // end

	public function guestsCanRegisterOnOrderSuccess() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/register_on_order_success');
		return $value;
	} // end
	
	public function getCMSBlockIdForOrderSuccessForm() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout/register_on_order_success_cms_block');
		return $value;
	} // end
	
	public function getCustomerGroupsEnabled() {
		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout_customergroups/customergroups_enabled');
		return $value;
	} // end 
		
	public function getShippingCustomerGroups() {

		if ($this->getCustomerGroupsEnabled() == 0) {
			return array();
		} // end

		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout_customergroups/shipping_noskip_customergroups');
		$value = explode(',', $value);

		return $value;
	} // end

	public function getPaymentCustomerGroups() {

		if ($this->getCustomerGroupsEnabled() == 0) {
			return array();
		} // end

		$value = Mage::getStoreConfig('clearandfizzy_reducedcheckout_settings/reducedcheckout_customergroups/payment_noskip_customergroups');
		$value = explode(',', $value);

		return $value;
	} // end

	/**
	 * Returns the current logged in customers group.
	 * If the customer is not logged in return false
	 *
	 * @return boolean
	 */
	protected function getCurrentCustomersGroup() {

		// Check Customer is loggedin or not
		if(Mage::getSingleton('customer/session')->isLoggedIn()){

			// Get group Id
			$groupId = Mage::getSingleton('customer/session')->getCustomerGroupId();

			return $groupId;
			//Get customer Group name
			//$group = Mage::getModel('customer/group')->load($groupId);
			//return $group->getCode();
		} // end

		return false;
	} // end


	/**
	 * Returns true if we should force the payment method
	 * @return boolean
	 */
	public function skipPaymentMethod() {
		$code = $this->getPaymentMethod();
		$noskip_groups = $this->getPaymentCustomerGroups();
		$current_group = $this->getCurrentCustomersGroup();

		switch ($code) {

			case "noskip":
				$return = false;
			break;

			default:
				$return = $this->skipThisSection($current_group, $noskip_groups);
			break;

		} // end sw

		return $return;

	} // end fun

	/**
	 * Returns true if we should force the shipping method
	 * @return boolean
	 */
	public function skipShippingMethod() {
		$code = $this->getShippingMethod();
		$noskip_groups = $this->getShippingCustomerGroups();
		$current_group = $this->getCurrentCustomersGroup();

		switch ($code) {

			case "noskip":
				$return = false;
			break;

			default:
				$return = $this->skipThisSection($current_group, $noskip_groups);
			break;

		} // end sw

		return $return;

	} // end fun


	/**
	 * Returns true if we should skip this section
	 *
	 * @param int $current_group customers group id
	 * @param array $noskip_groups array of groupid's
	 */
	private function skipThisSection($current_group, $noskip_groups) {

//   		var_dump($current_group);
//   		var_dump($noskip_groups);
//   		var_dump(is_array($noskip_groups));
//   		var_dump(array_search($current_group, $noskip_groups));

		// if we find the current users groupid in the "dont skip" array, tell checkout not to skip this section
		if ( $current_group !== false && is_array($noskip_groups) && array_search($current_group, $noskip_groups) > -1 ) {
			return false;
		} // end

		return true;

	} // end


}

