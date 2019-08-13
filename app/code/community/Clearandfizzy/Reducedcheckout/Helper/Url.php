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
* @copyright   Copyright (c) 2014 Clearandfizzy Ltd. (http://www.clearandfizzy.com)
* @license     http://creativecommons.org/licenses/by-nd/3.0/ Creative Commons (CC BY-ND 3.0)
* @author		Gareth Price <gareth@clearandfizzy.com>
*
*/
class Clearandfizzy_Reducedcheckout_Helper_Url extends Mage_Core_Helper_Abstract {
	
	protected $is_secure;
	
	public function _construct() {
		parent::_construct();
		$this->is_secure = Mage::app()->getStore()->isCurrentlySecure();
	} // end 
	
	
	/**
	 * 
	 */
	public function getProgressUrl() {
		return Mage::getUrl('reducedcheckout/onepage/progress', array("_secure" => $this->is_secure));
	} // end 
	
	public function getReviewUrl() {
		return Mage::getUrl('reducedcheckout/onepage/review', array("_secure" => $this->is_secure));
	} // end
	
	public function getSaveMethodUrl() {
		return Mage::getUrl('reducedcheckout/onepage/saveMethod', array("_secure" => $this->is_secure));
	}

	public function getFailureUrl() {
		return Mage::getUrl('checkout/cart', array("_secure" => $this->is_secure));
	}
	
	public function getAddressUrl() {
		return Mage::getUrl('reducedcheckout/onepage/getAddress', array("_secure" => $this->is_secure));
	} // end 
		
	public function getSaveBillingUrl() {
		return Mage::getUrl('reducedcheckout/onepage/saveBilling', array("_secure" => $this->is_secure));
	} // end 

	public function getSaveShippingUrl() {
		return Mage::getUrl('reducedcheckout/onepage/saveShipping', array("_secure" => $this->is_secure));
	}

	public function getSaveShippingMethod() {
		return Mage::getUrl('reducedcheckout/onepage/saveShippingMethod', array("_secure" => $this->is_secure));
	}

	public function getSavePaymentUrl() {
		return Mage::getUrl('reducedcheckout/onepage/savePayment', array("_secure" => $this->is_secure));
	}
	
} // end class