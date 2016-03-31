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

class Morningtime_TargetPay_Model_Api extends Mage_Payment_Model_Method_Abstract
{
    protected $_formBlockType = 'targetpay/form';
    protected $_infoBlockType = 'targetpay/info';

    // Magento features
    protected $_isGateway = false;
    protected $_canOrder = false;
    protected $_canAuthorize = false;
    protected $_canCapture = false;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canRefundInvoicePartial = false;
    protected $_canVoid = false;
    protected $_canUseInternal = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = false;
    protected $_isInitializeNeeded = true;
    protected $_canFetchTransactionInfo = false;
    protected $_canReviewPayment = false;
    protected $_canCreateBillingAgreement = false;
    protected $_canManageRecurringProfiles = false;

    // Restrictions
    protected $_allowCurrencyCode = array();

    // Local constants
    const REQUEST_ONCE = 0;
    const TARGETPAY_CHECK_CODE_OK = '000000';
    const DIRECT_TYPE = 1;

    public function __construct()
    {
        $this->_config = Mage::getSingleton('targetpay/config');
        return $this;
    }

    /**
     * Return configuration instance
     *
     * @return Morningtime_TargetPay_Model_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Validate if payment is possible
     *  - check allowed currency codes
     *
     * @return bool
     */
    public function validate()
    {
        parent::validate();
        $currency_code = $this->getCurrencyCode();
        if (!empty($this->_allowCurrencyCode) && !in_array($currency_code, $this->_allowCurrencyCode)) {
            $errorMessage = Mage::helper('targetpay')->__('Selected currency (%s) is not compatible with this payment method.', $currency_code);
            Mage::throwException($errorMessage);
        }
        return $this;
    }

    /**
     * Get redirect URL after placing order
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return $this->getConfig()->getApiUrl('redirect');
    }

    /**
     * Decide currency code type
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        if ($this->getConfig()->getServiceConfigData('base_currency')) {
            $currencyCode = Mage::app()->getStore()->getBaseCurrencyCode();
        }
        else {
            $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        }
        return $currencyCode;
    }

    /**
     * Decide grand total
     *
     * @param $order Mage_Sales_Model_Order
     * @return string
     */
    public function getGrandTotal($order)
    {
        if ($this->getConfig()->getServiceConfigData('base_currency')) {
            $amount = intval($order->getBaseGrandTotal() * 100 + 0.5);
        }
        else {
            $amount = intval($order->getGrandTotal() * 100 + 0.5);
        }
        return $amount;
    }

    /**
     * Post with CURL and return response
     *
     * @param $postUrl The URL with ?key=value
     * @param $postData string Message
     * @return reponse XML Object
     */
    public function curlPost($postUrl, $postData = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, "$postData");
        }

        $response = curl_exec($ch);
        return $response;
    }

    /**
     * Return TargetPay language code
     *
     * @param $class string Api class
     * @return string TargetPay language code
     */
    public function getLanguageCode($class)
    {
        $object = new $class;
        $language = Mage::app()->getLocale()->getLocaleCode();
        if (in_array($language, $object->available_languages)) {
            $code = strtoupper($language);
        }
        else {
            $code = strtoupper($object->default_language);
        }
        return $code;
    }

    /**
     * Return TargetPay country code
     *
     * @param $class string Api class
     * @param $country string 2-letter iso country code
     * @return string TargetPay country code
     */
    public function getCountryCode($class, $country)
    {
        $object = new $class;
        if (in_array($country, $object->available_countries)) {
            $code = (int)$object->available_countries[$country];
        }
        else {
            $code = (int)$object->default_country;
        }
        return $code;
    }

    /**
     * Create payment request
     */
    public function paymentRequest(Mage_Sales_Model_Order $order)
    {
        $storeId = $order->getStoreId();
        $paymentMethodCode = $order->getPayment()->getMethod();
        $billingAddress = $order->getBillingAddress();

        $query = array();
        $query['rtlo'] = $this->getConfig()->getServiceConfigData('rtlo', $storeId);
        $query['amount'] = $this->getGrandTotal($order);
        $query['returnurl'] = $this->getConfig()->getApiUrl('return', $storeId);
        $query['reporturl'] = $this->getConfig()->getPushUrl('notify', $storeId);
        $query['description'] = $this->getConfig()->getOrderDescription($order);

        switch ($paymentMethodCode) {
            case 'targetpay_ideal' :
                $query['bank'] = $order->getPayment()->getTargetpayIssuerId();
                $requestPath = 'ideal/start';
                break;

            case 'targetpay_direct' :
                $query['lang'] = $this->getLanguageCode('Morningtime_TargetPay_Model_Api_Direct');
                $query['country'] = $this->getCountryCode('Morningtime_TargetPay_Model_Api_Direct', $billingAddress->getCountry());
                $query['userip'] = Mage::helper('targetpay')->getRealIpAddr();
                $query['type'] = self::DIRECT_TYPE;
                $requestPath = 'directebanking/start';
                break;

            case 'targetpay_mrcash' :
                $query['lang'] = $this->getLanguageCode('Morningtime_TargetPay_Model_Api_Mrcash');
                $query['userip'] = Mage::helper('targetpay')->getRealIpAddr();
                $requestPath = 'mrcash/start';
                break;

            case 'targetpay_paysafecard' :
                $requestPath = 'wallie/start';
                $query['language'] = $this->getLanguageCode('Morningtime_TargetPay_Model_Api_Paysafecard');
                $query['country'] = $this->getCountryCode('Morningtime_TargetPay_Model_Api_Country', $billingAddress->getCountry());
                $query['userip'] = Mage::helper('targetpay')->getRealIpAddr();
                break;

            default :
        }

        $queryString = http_build_query($query, '', '&');

        $response = new stdClass;
        $request = $this->curlPost('https://www.targetpay.com/' . $requestPath . '?' . $queryString);
        if ($request) {

            // Return format: 000000 TransactionId|PaymentUrl (success)
            // or: 000000 ErrorMessage (failure)
            $response->code = substr($request, 0, 6);
            $response->string = str_replace($response->code . ' ', '', $request);

            // If success, reponse text contains trxid and pay_url
            $string = explode('|', $response->string);
            if ($response->code == self::TARGETPAY_CHECK_CODE_OK) {
                $response->id = $string[0];
                $response->url = $string[1];
            }
            else {
                $response->error = $string;
            }
        }
        else {
            $response->error = Mage::helper('targetpay')->__('Payment request failed. Please contact the merchant.');
        }
        return $response;
    }

    /**
     * Check payment by transaction ID
     */
    public function statusRequest(Mage_Sales_Model_Order $order)
    {
        $storeId = $order->getStoreId();
        $paymentMethodCode = $order->getPayment()->getMethod();

        $query = array();
        $query['rtlo'] = $this->getConfig()->getServiceConfigData('rtlo', $storeId);
        $query['test'] = (int)$this->getConfig()->getServiceConfigData('test_flag');
        $query['trxid'] = $order->getTargetpayTransactionId();
        $query['once'] = self::REQUEST_ONCE;

        switch ($paymentMethodCode) {
            case 'targetpay_ideal' :
                $requestPath = 'ideal/check';
                break;

            case 'targetpay_direct' :
                $requestPath = 'directebanking/check';
                break;

            case 'targetpay_mrcash' :
                $requestPath = 'mrcash/check';
                break;

            case 'targetpay_paysafecard' :
                $requestPath = 'wallie/check';
                break;

            default :
        }

        $queryString = http_build_query($query, '', '&');

        $response = new stdClass;
        $request = $this->curlPost('https://www.targetpay.com/' . $requestPath . '?' . $queryString);
        if ($request) {

            // Return format: 000000 ResponseMessage
            $response->status = substr($request, 0, 6);
            $response->message = str_replace($response->status . ' ', '', $request);
        }
        return $response;
    }

}
