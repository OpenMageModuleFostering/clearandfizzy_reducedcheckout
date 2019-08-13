<?php

class Clearandfizzy_Reducedcheckout_Model_System_Config_Source_Payment_EnabledMethods {

	public function toOptionArray()
	{

		$active_methods = Mage::getSingleton('payment/config')->getActiveMethods();

		$methods = array();
		$methods['noskip'] = Mage::helper('clearandfizzy_reducedcheckout')->__("Do not skip [Default Magento]");

		foreach ( $active_methods as $code => $value ) {

			switch ($code) {

				// we can't skip this method so make sure its not added to the array
				case "ccsave":
				break;

				default:
					$label = Mage::getStoreConfig('payment/'.$code.'/title');
					$methods[$code] = $label;
				break;

			} // end


		} // end

		return $methods;

	} // end fun


} // end class