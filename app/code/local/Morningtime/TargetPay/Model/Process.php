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

class Morningtime_TargetPay_Model_Process extends Varien_Object
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
     * Return payment API model
     *
     * @return Morningtime_TargetPay_Model_Api
     */
    protected function getApi()
    {
        return Mage::getSingleton('targetpay/api');
    }

    /**
     * Success process
     * [multi-method] [single-service]
     *
     * Update succesful (paid) orders, send order email, create invoice
     * and send invoice email. Restore quote and clear cart.
     *
     * @param $order object Mage_Sales_Model_Order
     * @param $note string Backend order history note
     * @param $transactionId string Transaction ID
     * @param $responseCode integer Response code
     * @param $frontend boolean
     */
    public function success(Mage_Sales_Model_Order $order, $note, $transactionId, $responseCode = 1, $frontend = false)
    {
        if ($order->getId() && $responseCode != $order->getPayment()->getMorningtimeResponseCode()) {
            $order->getPayment()->setMorningtimeResponseCode($responseCode);
            $order->getPayment()->setTransactionId($transactionId);
            $order->getPayment()->setLastTransId($transactionId);

            // Multi-method API
            $paymentMethodCode = $order->getPayment()->getMethod();

            // Send order email
            if (!$order->getEmailSent() && $this->getApi()->getConfig()->getServiceConfigData('order_email')) {
                $order->sendNewOrderEmail()->setEmailSent(true);
            }

            // Set processing status
            $processingOrderStatus = $this->getApi()->getConfig()->getProcessingStatus($paymentMethodCode);
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, $processingOrderStatus, $note, $notified = false);
            $order->save();

            // Create invoice
            if ($this->getApi()->getConfig()->getServiceConfigData('invoice_create')) {
                $this->invoice($order);
            }
        }

        if ($frontend) {
            $this->restore();
            $this->clear();
        }
    }

    /**
     * Create automatic invoice
     * [multi-method] [single-service]
     *
     * @param $order Mage_Sales_Model_Order
     */
    public function invoice($order)
    {
        if (!$order->hasInvoices() && $order->canInvoice()) {
            $invoice = $order->prepareInvoice();
            if ($invoice->getTotalQty() > 0) {
                $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $transaction = Mage::getModel('core/resource_transaction')->addObject($invoice)->addObject($invoice->getOrder());
                $transaction->save();
                $invoice->addComment(Mage::helper('targetpay')->__('Automatic invoice.'), false);

                // Send invoice email
                if (!$invoice->getEmailSent() && $this->getApi()->getConfig()->getServiceConfigData('invoice_email')) {
                    $invoice->sendEmail()->setEmailSent(true);
                }
                $invoice->save();
            }
        }
    }

    /**
     * Cancel process
     *
     * Update failed, cancelled, declined, rejected etc. orders. Cancel
     * the order and show user message. Restore quote.
     *
     * @param $order object Mage_Sales_Model_Order
     * @param $note string Backend order history note
     * @param $transactionId string Transaction ID
     * @param $responseCode integer Response code
     * @param $frontend boolean
     */
    public function cancel(Mage_Sales_Model_Order $order, $note, $transactionId, $responseCode = 1, $frontend = false)
    {
        if ($order->getId() && $responseCode != $order->getPayment()->getMorningtimeResponseCode()) {
            $order->getPayment()->setMorningtimeResponseCode($responseCode);
            $order->getPayment()->setTransactionId($transactionId);
            $order->getPayment()->setLastTransId($transactionId);

            // Cancel order
            $order->addStatusToHistory($order->getStatus(), $note, $notified = true);
            $order->cancel()->save();
        }

        if ($frontend) {
            $this->restore();
            $message = Mage::helper('targetpay')->__('Payment failed. Please try again.');
            $this->getCheckout()->addError($message);
        }
    }

    /**
     * Done processing
     *
     * Restore checkout session and clear cart for success page.
     */
    public function done()
    {
        $this->restore();
        $this->clear();
    }

    /**
     * Restore process
     *
     * Restore checkout session and show payment failed message.
     */
    public function repeat()
    {
        $this->restore();
        $message = Mage::helper('targetpay')->__('Payment failed. Please try again.');
        $this->getCheckout()->addError($message);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->getCheckout()->getQuote()->setIsActive(false)->save();
    }

    /**
     * Restore checkout session
     */
    public function restore()
    {
        $this->getCheckout()->setQuoteId($this->getCheckout()->getTargetPayQuoteId(true));
        $this->getCheckout()->setLastOrderId($this->getCheckout()->getTargetPayOrderId(true));
    }

}
