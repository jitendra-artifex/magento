<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-COMMUNITY.txt
 * 
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Advancedreports
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-COMMUNITY.txt
 */?>
<?php
class AW_Advancedreports_DayofweekController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('report/advancedreports/dayofweek')
            ->_addBreadcrumb(Mage::helper('advancedreports')->__('Advanced'), Mage::helper('advancedreports')->__('Advanced'))
            ->_addBreadcrumb(Mage::helper('advancedreports')->__('Sales by Day of Week'), Mage::helper('advancedreports')->__('Sales by Day of Week'))
            ->_addContent( $this->getLayout()->createBlock('advancedreports/advanced_dayofweek') )
            ->renderLayout();
    }

    public function exportOrderedCsvAction()
    {
        $fileName   = 'dayofweek.csv';
        $content    = $this->getLayout()->createBlock('advancedreports/advanced_dayofweek_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportOrderedExcelAction()
    {
        $fileName   = 'dayofweek.xml';
        $content    = $this->getLayout()->createBlock('advancedreports/advanced_dayofweek_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName, $content);
    }

}

