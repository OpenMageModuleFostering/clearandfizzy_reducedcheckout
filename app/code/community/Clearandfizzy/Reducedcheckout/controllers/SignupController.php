<?php
/**
 * 
 * @author Gareth
 *
 */
class Clearandfizzy_Reducedcheckout_SignupController extends Mage_Core_Controller_Front_Action
{
	
	/**
	 * Grab the form submission, inject needed data into the form post before forwarding onto the magento create account controller.
	 * 
	 */
	public function indexAction() {
		$helper = Mage::helper('clearandfizzy_reducedcheckout/order');

		//get the current order
		$order = $helper->getOrder();
		
		// grab the details we need from the order
		$firstname = $order->getCustomerFirstname();
		$lastname = $order->getCustomerLastname();
		$email = $order->getCustomerEmail();
		$password = $this->getRequest()->getParam('password');
		$confirmation = $this->getRequest()->getParam('password');
		
		// put them in the form submission 
		$this->getRequest()->setPost('firstname', $firstname);
		$this->getRequest()->setPost('lastname', $lastname);
		$this->getRequest()->setPost('email', $email);
		$this->getRequest()->setPost('password', $password);
		$this->getRequest()->setPost('confirmation', $password);
		$this->getRequest()->setPost('success_url', Mage::getUrl('customer/account/*'));
		
		// there are two parts to this process..
		// Once the customer account is created we observe the "customer_register_success" event
		// and add the addresses / order etc in there.
		
		// set this before any observers fire
		Mage::register($helper->getSessionKey(), true);
		
		// forward onto the account creation action
		$this->_forward('createpost','account','customer');		
		
	} // end 
	
} // end class