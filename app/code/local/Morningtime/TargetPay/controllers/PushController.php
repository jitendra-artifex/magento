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

class Morningtime_TargetPay_PushController extends Mage_Core_Controller_Front_Action
{
    /**
     * Return checkout session
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Return order process instance
     *
     * @return Morningtime_TargetPay_Model_Process
     */
    public function getProcess()
    {
        return Mage::getSingleton('targetpay/process');
    }

    /**
     * Return payment API model
     *
     * @return Morningtime_TargetPay_Model_Api
     */
    protected function getApi()
    {
        return Mage::getSingleton('targetpay/api');
    }

    /**
     * Success action
     *
     * @see targetpay/push/notify
     */
    public function notifyAction()
    {
        $transactionId = $this->getRequest()->getParam('trxid');
        $order = Mage::getModel('sales/order')->loadByAttribute('targetpay_transaction_id', $transactionId);
        if ($order->getId() && !$order->getMorningtimeResponseCode()) {
            $response = $this->getApi()->statusRequest($order);
            switch ($response->status) {
                case Morningtime_TargetPay_Model_Api::TARGETPAY_CHECK_CODE_OK :
                    $note = Mage::helper('targetpay')->__('Payment Status: Success.');
                    $this->getProcess()->success($order, $note, $transactionId, 1);
                    break;

                default :
                    $note = Mage::helper('targetpay')->__('Response Code %s: %s.', $response->status, $response->message);
                    $this->getProcess()->cancel($order, $note, $transactionId, -1);
            }

            // Debug in
            $this->saveDebugIn($response);
        }
        exit ;
    }

    /**
     * Debug in
     *
     * @param $response The XML response object
     */
    public function saveDebugIn($response)
    {
        if ($this->getApi()->getConfig()->getServiceConfigData('debug_flag')) {
            $url = $this->getRequest()->getPathInfo();
            $data = print_r($response, true);
            $debug = Mage::getModel('targetpay/api_debug')->setDir('in')->setUrl($url)->setData('data', $data)->save();
        }
    }

}
