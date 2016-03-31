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

class Morningtime_TargetPay_Model_Api_Ideal extends Morningtime_TargetPay_Model_Api
{
    protected $_code = 'targetpay_ideal';
    protected $_formBlockType = 'targetpay/form_ideal';

    // Restrictions
    protected $_allowCurrencyCode = array('EUR');

    protected $_issuerList = null;

    /**
     * Get issuer list
     */
    public function getIssuers()
    {
        if ($this->_issuerList == null) {
            $this->_issuerList = $this->requestIssuers();
        }
        return $this->_issuerList;
    }

    /**
     * Get available issuers from TargetPay
     */
    public function requestIssuers()
    {
        $query = array();
        $query['format'] = 'xml';
        $queryString = http_build_query($query, '', '&');

        $issuers = array();
        $request = $this->curlPost('https://www.targetpay.com/ideal/getissuers.php' . '?' . $queryString);
        if ($request) {
            $xml = new SimpleXMLElement($request);
            foreach ($xml->issuer as $issuer) {
                $attributes = $issuer[0]->attributes();
                $issuers[(string)$attributes->id] = (string)$issuer;
            }
        }

        return $issuers;
    }

}
