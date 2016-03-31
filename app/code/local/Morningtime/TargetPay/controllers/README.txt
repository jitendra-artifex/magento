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

-----------------------
Available notifications
-----------------------

 - PUSH before USER: notification to Return
 - USER redirect to Return
 
---------------------
Notification strategy
---------------------

 - PUSH: single status 0/1
   TargetPay returns an instant push notification before the user is redirected.
 - USER: redirect to return

------------------------------
Implemented controller actions
------------------------------

 - ApiController.php: Basic user redirect actions 
   @url targetpay/api/redirect       Redirects user to payment URL
   @url targetpay/api/return         User redirect: Return
   
 - PushController.php: Receive and process push notifications
   @url targetpay/push/notify       Update order based on status codes
   