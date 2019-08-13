<?php 
/**
 * 
 * @author Gareth
 *
 */
class Clearandfizzy_Reducedcheckout_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
	
	public function addBlock($string) {
		
		$cms_block = Mage::getModel('cms/block');
		
		$cms_block->setData('title', 'ReducedCheckout - Order Success Page - Customer Registration Form');
		$cms_block->setData('identifier', 'reducedcheckout_success_form_register');
		$cms_block->setData('content', $string );

		// all stores
		$stores = array();
		$stores[] = 0;
		foreach ( Mage::app()->getStores() as $store) {
			$stores[] = $store->getId();
		} // end 
		
		$cms_block->setData('stores', $stores);
		$cms_block->setData('is_active', '1');
		$cms_block->save();
	 	
	} // end 
	
}
