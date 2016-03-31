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
 * @package    AW_Helpdeskultimate
 * @version    2.9.7
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-COMMUNITY.txt
 */

class AW_Helpdeskultimate_Model_Attachment extends AW_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('helpdeskultimate/attachment');
    }

    protected function _beforeSave()
    {
        if (is_array($this->getData('attachments')))
            $this->setData('attachments', @serialize($this->getData('attachments')));
        return parent::_beforeSave();
    }

    protected function _afterLoad()
    {
        if (!is_array($this->getData('attachments')))
            $this->setData('attachments', @unserialize($this->getData('attachments')));
        return parent::_afterLoad();
    }

    public function loadByUid($uid)
    {
        return $this->load($uid, 'uid');
    }
}
