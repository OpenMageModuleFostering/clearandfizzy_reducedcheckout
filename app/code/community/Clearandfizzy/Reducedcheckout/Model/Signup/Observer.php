<?php 

class Clearandfizzy_Reducedcheckout_Model_Signup_Observer extends Mage_Core_Model_Observer {
	
	protected $_helper;
	
	public function __construct() {
		$this->_helper = Mage::helper('clearandfizzy_reducedcheckout/order');
	} // end 
		
	/**
	 * Observes the user register event.
	 * @param Varien_Event_Observer $observer
	 */
	public function checkCustomerCreated(Varien_Event_Observer $observer) {
		$helper 	= $this->_helper;
		
		// if this session key does not exist then we have nothing to do
		if (Mage::registry($helper->getSessionKey()) == false) {
			return;
		} // end if
		
		$customer 	= $observer->getCustomer();
		$order 		= $helper->getOrder();
		
		$address 	= Mage::getModel('customer/address');
		$billing	= $order->getBillingAddress();
		$shipping	= $order->getShippingAddress();		

		// assign this order to the current customer
		$order = $this->_assignCustomerToOrder($order, $customer);
		
		// assign bill and shipping to the customer
		$billing = $this->_prepareAddress($billing, $customer);
		$address->setData($billing->getData());
		$customer->addAddress($address);
		$customer->save();
		
		// un-register this key
		Mage::unregister($helper->getSessionKey());
		
		return true;		
	} // end 
	
	/**
	 * Assign a customer to an order
	 * @param unknown $order
	 * @param unknown $customer
	 * @return unknown
	 */
	protected function _assignCustomerToOrder($order, $customer) {
	
		// assign the customer to the order
		$order->setCustomerId($customer->getId());
		$order->save();
	
		return $order;
	}
	
	/**
	 * Remove some values from the address
	 * @param unknown $address
	 * @param unknown $customer
	 * @return unknown
	 */
	protected function _prepareAddress($address, $customer) {
		$address->unsetData('entity_id');
		$address->setCustomerId($customer->getId());
		$address->setIsDefaultBilling(true);
	
		return $address;
	} // end	
	
} // end