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

$installer = $this;
/* @var $installer Mage_Core_Model_Mysql4_Setup */

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('targetpay/api_debug')}`;
CREATE TABLE `{$this->getTable('targetpay/api_debug')}` (
  `debug_id` int(10) unsigned NOT null auto_increment,
  `debug_at` timestamp NOT null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `dir` enum('in', 'out'),
  `url` varchar(255),
  `data` text,
  PRIMARY KEY  (`debug_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();

$installer->addAttribute('quote_payment', 'targetpay_issuer_id', array());
$installer->addAttribute('order_payment', 'targetpay_issuer_id', array());
$installer->addAttribute('order', 'targetpay_transaction_id', array());
$installer->addAttribute('order_payment', 'morningtime_response_code', array('type' => 'int'));
