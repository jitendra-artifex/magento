<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Mindstretch
 * @package   Mindstretch_ConfigDutch
 * @author    Mindstretch <www.mindstretch.nl>
 * @copyright 2009-2011 Mindstretch
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.mindstretch.nl/
 */

class Mindstretch_ConfigDutch_Model_Setup extends Mage_Core_Model_Resource_Setup
{
    /**
     * get data for tax_calculation_rule
     *
     * @return array
     */
    protected function _getTaxCalcRuleData() 
    {
        $taxCalcRuleData = array(
            array(
                'tax_calculation_rule_id' => 3,
                'code' => 'Producten met 19% BTW',
                'priority' => 1,
                'position' => 0
                ),
            array(
                'tax_calculation_rule_id' => 4,
                'code' => 'Producten met 6% BTW',
                'priority' => 2,
                'position' => 0
                ),
            array(
                'tax_calculation_rule_id' => 5,
                'code' => 'Verzendkosten met 19% BTW',
                'priority' => 3,
                'position' => 0
                )
        );
        
        return $taxCalcRuleData;
    }
    
    /**
     * get data for tax_class
     *
     * @return array
     */
    protected function _getTaxClassData() 
    {
        $taxClassData = array(
            array(
                'class_id' => 1,
                'class_name' => 'Omzetbelasting 19%',
                'class_type' => 'PRODUCT'
            ),
            array(
                'class_id' => 2,
                'class_name' => 'Omzetbelasting 6%',
                'class_type' => 'PRODUCT'
            ),
            array(
                'class_id' => 3,
                'class_name' => 'BTW',
                'class_type' => 'CUSTOMER'
            ),
            array(
                'class_id' => 4,
                'class_name' => 'Verzendkosten 19%',
                'class_type' => 'PRODUCT'
            )
        );
        
        return $taxClassData;
    }
    
    /**
     * get data for tax_calculation_rate
     *
     * @return array
     */
    protected function _getTaxCalcRateData() 
    {
        $taxCalcRateData = array(
            array(
                'tax_calculation_rate_id' => 3,
                'tax_country_id' => 'NL',
                'tax_region_id' => 0,
                'tax_postcode' => '*',
                'code' => '19% BTW',
                'rate' => 19.0000,
                'zip_is_range' => NULL,
                'zip_from' => NULL,
                'zip_to' => NULL
            ),
            array(
                'tax_calculation_rate_id' => 4,
                'tax_country_id' => 'NL',
                'tax_region_id' => 0,
                'tax_postcode' => '*',
                'code' => '0% BTW',
                'rate' => 0.0000,
                'zip_is_range' => NULL,
                'zip_from' => NULL,
                'zip_to' => NULL
            ),
            array(
                'tax_calculation_rate_id' => 5,
                'tax_country_id' => 'NL',
                'tax_region_id' => 0,
                'tax_postcode' => '*',
                'code' => '6% BTW',
                'rate' => 6.0000,
                'zip_is_range' => NULL,
                'zip_from' => NULL,
                'zip_to' => NULL
            )
        );
        
        return $taxCalcRateData;
    }
    
    /**
     * get data for table tax_calculation
     *
     * @return array
     */
    protected function _getTaxCalcData() 
    {
        $taxCalcData = array(
            array(
                'tax_calculation_rate_id' => 3,
                'tax_calculation_rule_id' => 3,
                'customer_tax_class_id' => 3,
                'product_tax_class_id' => 1
            ),
            array(
                'tax_calculation_rate_id' => 3,
                'tax_calculation_rule_id' => 5,
                'customer_tax_class_id' => 3,
                'product_tax_class_id' => 4
            ),
            array(
                'tax_calculation_rate_id' => 5,
                'tax_calculation_rule_id' => 4,
                'customer_tax_class_id' => 3,
                'product_tax_class_id' => 2
            )
        );
        
        return $taxCalcData;
    }
    
    /**
     * return insert data for table
     *
     * @param string $tableName table name
     *
     * @return array
     */
    public function getInsertData($tableName)     
    {
        switch ($tableName) {
            case 'tax_calculation_rule':
                return $this->_getTaxCalcRuleData();
                break;
            case 'tax_class':
                return $this->_getTaxClassData();
                break;
            case 'tax_calculation_rate':
                return $this->_getTaxCalcRateData();
                break;
            case 'tax_calculation':
                return $this->_getTaxCalcData();
                break;
            default:
                break;
        }
    }
}
