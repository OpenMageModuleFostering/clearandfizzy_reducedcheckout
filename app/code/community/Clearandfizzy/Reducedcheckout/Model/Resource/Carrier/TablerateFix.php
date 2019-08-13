<?php 

class Clearandfizzy_ReducedCheckout_Model_Resource_Carrier_TablerateFix extends Mage_Shipping_Model_Resource_Carrier_Tablerate 
{

	/**
	 * (non-PHPdoc)
	 * @see Mage_Shipping_Model_Resource_Carrier_Tablerate::getRate()
	 */
	public function getRate(Mage_Shipping_Model_Rate_Request $request)	{
		if ( Mage::helper('clearandfizzy_reducedcheckout')->isFix28112Enabled() ) {
			return $this->__getRate($request);
		} // end 
		
		// otherwise return the magento code
		return parent::getRate($request);
		
	} // end fun
	
	/**
	 * This is a bug fix for 
	 * (non-PHPdoc)
	 * @see Mage_Shipping_Model_Resource_Carrier_Tablerate::getRate()
	 */
	private function __getRate(Mage_Shipping_Model_Rate_Request $request) {	
        $adapter = $this->_getReadAdapter();

        $bind = array(
            ':website_id' => (int) $request->getWebsiteId(),
            ':country_id' => $request->getDestCountryId(),
            ':region_id' => (int) $request->getDestRegionId(),
            ':postcode' => $request->getDestPostcode()
        );

        // condition_value DESC fix
        $select = $adapter->select()
            ->from($this->getMainTable())
            ->where('website_id = :website_id')
            ->order(array('dest_country_id DESC', 'dest_region_id DESC', 'dest_zip DESC', 'condition_value DESC'))
            ->limit(1);

        // Render destination condition
        $orWhere = '(' . implode(') OR (', array(
            "dest_country_id = :country_id AND dest_region_id = :region_id AND dest_zip = :postcode",
            "dest_country_id = :country_id AND dest_region_id = :region_id AND dest_zip = ''",

            // Handle asterix in dest_zip field
            "dest_country_id = :country_id AND dest_region_id = :region_id AND dest_zip = '*'",
            "dest_country_id = :country_id AND dest_region_id = 0 AND dest_zip = '*'",
            "dest_country_id = '0' AND dest_region_id = :region_id AND dest_zip = '*'",
            "dest_country_id = '0' AND dest_region_id = 0 AND dest_zip = '*'",

            "dest_country_id = :country_id AND dest_region_id = 0 AND dest_zip = ''",
            "dest_country_id = :country_id AND dest_region_id = 0 AND dest_zip = :postcode",
            "dest_country_id = :country_id AND dest_region_id = 0 AND dest_zip = '*'",
        )) . ')';
        $select->where($orWhere);

        // Render condition by condition name
        if (is_array($request->getConditionName())) {
            $orWhere = array();
            $i = 0;
            foreach ($request->getConditionName() as $conditionName) {
                $bindNameKey  = sprintf(':condition_name_%d', $i);
                $bindValueKey = sprintf(':condition_value_%d', $i);
                $orWhere[] = "(condition_name = {$bindNameKey} AND condition_value <= {$bindValueKey})";
                $bind[$bindNameKey] = $conditionName;
                $bind[$bindValueKey] = $request->getData($conditionName);
                $i++;
            }

            if ($orWhere) {
                $select->where(implode(' OR ', $orWhere));
            }
        } else {
            $bind[':condition_name']  = $request->getConditionName();
            $bind[':condition_value'] = $request->getData($request->getConditionName());

            $select->where('condition_name = :condition_name');
            $select->where('condition_value <= :condition_value');
        }
        
        $result = $adapter->fetchRow($select, $bind);
        // Normalize destination zip code
        if ($result && $result['dest_zip'] == '*') {
            $result['dest_zip'] = '';
        }
        return $result;
		
	} // end 	
	
} // end 