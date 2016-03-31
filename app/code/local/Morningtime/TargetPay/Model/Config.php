<?php
/**
 * Morningtime Extensions
 * http://shop.morningtime.com
 *
 * @extension   Morningtime TargetPay iDEAL, Mister Cash, Directebanking, Wallie, Paysafecard
 * @type        Payment method
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
 * @category    Morningtime
 * @package     Morningtime_TargetPay
 * @copyright   Copyright (c) 2011-2012 Morningtime Internetbureau B.V. (http://www.morningtime.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Morningtime_TargetPay_Model_Config extends Mage_Payment_Model_Config
{
    const PAYMENT_SERVICES_PATH = 'payment_services/morningtime_targetpay/';
    const API_CONTROLLER_PATH = 'targetpay/api/';
    const PUSH_CONTROLLER_PATH = 'targetpay/push/';

    // Default order statuses
    const DEFAULT_STATUS_PENDING = 'pending';
    const DEFAULT_STATUS_PENDING_PAYMENT = 'pending_payment';
    const DEFAULT_STATUS_PROCESSING = 'processing';

    /**
     * Get store configuration
     */
    public function getPaymentConfigData($method, $key, $storeId = null)
    {
        return Mage::getStoreConfig('payment/' . $method . '/' . $key, $storeId);
    }

    public function getServiceConfigData($key, $storeId = null)
    {
        return Mage::getStoreConfig(self::PAYMENT_SERVICES_PATH . $key, $storeId);
    }

    /**
     * Return order description
     *
     * @param Mage_Sales_Model_Order
     * @return string
     */
    public function getOrderDescription($order)
    {
        return Mage::helper('targetpay')->__('Order %s', $order->getIncrementId());
    }

    /**
     * Functions for default new/pending/processing statuses
     */
    public function getOrderStatus($code)
    {
        $status = $this->getPaymentConfigData($code, 'order_status');
        if (empty($status)) {
            $status = self::DEFAULT_STATUS_PENDING;
        }
        return $status;
    }

    public function getProcessingStatus($code)
    {
        $status = $this->getPaymentConfigData($code, 'processing_status');
        if (empty($status)) {
            $status = self::DEFAULT_STATUS_PROCESSING;
        }
        return $status;
    }

    /**
     * Return URLs
     */
    public function getApiUrl($key, $storeId = null)
    {
        return Mage::getUrl(self::API_CONTROLLER_PATH . $key, array(
            '_store' => $storeId,
            '_secure' => true
        ));
    }

    public function getPushUrl($key, $storeId = null)
    {
        return Mage::getUrl(self::PUSH_CONTROLLER_PATH . $key, array(
            '_store' => $storeId,
            '_secure' => true
        ));
    }

}
