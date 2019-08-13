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
class Clearandfizzy_Reducedcheckout_Model_Notification_Feed extends Mage_AdminNotification_Model_Feed {
	
	const XML_FEED_URL_PATH     = 'clearandfizzy_reducedcheckout_settings/adminnotification/feed_url';
	
	
	/**
	 * Because we're using Constants we need to pull this code into the right scope.
	 * (non-PHPdoc)
	 * @see Mage_AdminNotification_Model_Feed::getFeedUrl()
	 */
	public function getFeedUrl()
	{
				
		if (is_null($this->_feedUrl)) {
			$this->_feedUrl = 'http://' . Mage::getStoreConfig(self::XML_FEED_URL_PATH);
		}
				
		return $this->_feedUrl;
	}
	
} // end 