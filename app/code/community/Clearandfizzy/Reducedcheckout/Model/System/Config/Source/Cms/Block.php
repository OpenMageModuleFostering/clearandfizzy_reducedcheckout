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
 * @copyright   Copyright (c) 2013 Clearandfizzy Ltd. (http://www.clearandfizzy.com)
 * @license     http://creativecommons.org/licenses/by-nd/3.0/ Creative Commons (CC BY-ND 3.0) 
 * @author		Gareth Price <gareth@clearandfizzy.com>
 * 
 */
class Clearandfizzy_Reducedcheckout_Model_System_Config_Source_Cms_Block
{

    protected $_options;

    public function toOptionArray()
    {
        return $this->toOptionIdArray();
    }
    
    /**
     * Returns pairs identifier - title for unique identifiers
     * and pairs identifier|block_id - title for non-unique after first
     *
     * @return array
     */
    public function toOptionIdArray()
    {

    	if (!$this->_options) {
    		$collection = Mage::getResourceModel('cms/block_collection')->load();
    	 
	    	$this->_options = array();
	    	$existingIdentifiers = array();

	    	// look though collection
	    	foreach ($collection as $item) {
	    		$identifier = $item->getData('identifier');
	    
	    		$data['value'] = $identifier;
	    		$data['label'] = $item->getData('title');
	    
	    		if (in_array($identifier, $existingIdentifiers)) {
	    			$data['value'] .= '|' . $item->getData('block_id');
	    		} else {
	    			$existingIdentifiers[] = $identifier;
	    		} // end if
	    
	    		$this->_options[] = $data;
	    	} // end for
    	} // end if
	    
    	return $this->_options;
    } // end fun
    
    
}
