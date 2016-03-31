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

class Morningtime_TargetPay_Model_Api_Paysafecard extends Morningtime_TargetPay_Model_Api
{
    protected $_code = 'targetpay_paysafecard';
    protected $_allowCurrencyCode = array(
        'EUR',
        'GBP',
        'MXN',
        'LVL',
        'SEK',
        'NOK',
        'USD'
    );

    // Special country codes
    protected $default_country = 1;
    protected $available_countries = array(
        'NL' => 31,
        'UK' => 44,
        'ES' => 34,
        'DE' => 49,
        'BE' => 32,
        'MX' => 52,
        'LV' => 371,
        'SE' => 46,
        'NO' => 47,
        'US' => 1
    );

    // Special language codes
    protected $default_language = 'en';
    protected $available_languages = array(
        'nl',
        'en',
        'es',
        'fr',
        'lv',
        'ru',
        'de',
        'tr',
        'sv',
        'no'
    );

}
