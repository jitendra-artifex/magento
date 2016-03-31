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

class Morningtime_TargetPay_ApiController extends Mage_Core_Controller_Front_Action
{
    /**
     * Get checkout session
     */
    public function getCheckout()
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
     * Get payment model
     */
    public function getApi()
    {
        return Mage::getSingleton('targetpay/api');
    }

    /**
     * Redirect action
     */
    public function redirectAction()
    {
        $order = Mage::getModel('sales/order')->loadByIncrementId($this->getCheckout()->getLastRealOrderId());
        if ($order->getId()) {
            $response = $this->getApi()->paymentRequest($order);
            if (!isset($response->error)) {
                $order->getPayment()->setMorningtimeResponseCode(0);
                $order->getPayment()->setTransactionId($response->id);
                $order->getPayment()->setLastTransId($response->id);
                $order->setTargetpayTransactionId($response->id);

                // Setting a History is required to store LastTransId!
                $paymentMethodCode = $order->getPayment()->getMethod();
                $newOrderStatus = $this->getApi()->getConfig()->getOrderStatus($paymentMethodCode);
                $order->addStatusToHistory($newOrderStatus, Mage::helper('targetpay')->__('Initiated payment process.'), $notified = false);
                $order->save();

                $this->saveCheckoutSession();
                $this->getResponse()->setBody($this->getLayout()->createBlock('targetpay/redirect')->setMessage(Mage::helper('targetpay')->__('You will be redirected to the payment gateway in a few seconds.'))->setRedirectUrl($response->url)->toHtml());
                return;
            }
            else {
                $errorMessage = Mage::helper('targetpay')->__('Error code %s: %s', (string)$response->code, (string)$response->string);
                $this->getCheckout()->addError($errorMessage);
            }
        }
        $this->_redirect('checkout/cart');
    }

    /**
     * Return action
     */
    public function returnAction()
    {
        $redirectUrl = 'checkout/cart';
        $transactionId = $this->getRequest()->getParam('trxid');
        $order = Mage::getModel('sales/order')->loadByAttribute('targetpay_transaction_id', $transactionId);
        if ($order->getId()) {
            $response = $this->getApi()->statusRequest($order);
            switch ($response->status) {
                case Morningtime_TargetPay_Model_Api::TARGETPAY_CHECK_CODE_OK :
                    $this->getProcess()->done();
                    $redirectUrl = 'checkout/onepage/success';
                    break;

                default :
                    $this->getProcess()->repeat();
                    $redirectUrl = 'checkout/cart';
            }
        }
        $this->_redirect($redirectUrl);
    }

    /**
     * Save checkout session
     */
    public function saveCheckoutSession()
    {
        $this->getCheckout()->setTargetPayQuoteId($this->getCheckout()->getLastSuccessQuoteId());
        $this->getCheckout()->setTargetPayOrderId($this->getCheckout()->getLastOrderId(true));
    }

}
