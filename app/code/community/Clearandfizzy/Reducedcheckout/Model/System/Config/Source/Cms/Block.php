<?php
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
