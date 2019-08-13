<?php
/**
 * Clearandfizzy
 *
 * NOTICE OF LICENSE
 *
 *
 * THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS OF THIS CREATIVE
 * COMMONS PUBLIC LICENSE ("CCPL" OR "LICENSE"). THE WORK IS PROTECTED BY
 * COPYRIGHT AND/OR OTHER APPLICABLE LAW. ANY USE OF THE WORK OTHER THAN AS
 * AUTHORIZED UNDER THIS LICENSE OR COPYRIGHT LAW IS PROHIBITED.

 * BY EXERCISING ANY RIGHTS TO THE WORK PROVIDED HERE, YOU ACCEPT AND AGREE
 * TO BE BOUND BY THE TERMS OF THIS LICENSE. TO THE EXTENT THIS LICENSE MAY
 * BE CONSIDERED TO BE A CONTRACT, THE LICENSOR GRANTS YOU THE RIGHTS
 * CONTAINED HERE IN CONSIDERATION OF YOUR ACCEPTANCE OF SUCH TERMS AND
 * CONDITIONS.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please refer to http://www.clearandfizzy.com for more information.
 *
 * @category    Community
 * @package     Clearandfizzy_Reducedcheckout
 * @copyright   Copyright (c) 2015 Clearandfizzy ltd. (http://www.clearandfizzy.com)
 * @license     http://www.clearandfizzy.com/license.txt
 * @author		Gareth Price <gareth@clearandfizzy.com>
 * 
 */
class Clearandfizzy_Reducedcheckout_Model_System_Config_Source_Payment_Enabledmethods {

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