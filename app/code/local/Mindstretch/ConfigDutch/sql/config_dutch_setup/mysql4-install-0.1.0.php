<?php
/**
 * Magento
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
 * @category  Mindstretch
 * @package   Mindstretch_ConfigDutch
 * @author    Mindstretch <www.mindstretch.nl>
 * @copyright 2009-2011 Mindstretch
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.mindstretch.nl/
 */

$configData = Mage::getConfig()->getNode('default/config_dutch')->asArray();

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$taxTables = array(
    'tax_calculation_rule',
    'tax_class',
    'tax_calculation_rate',
    'tax_calculation'
);

foreach ($taxTables as $table) {
    /* truncate table (not delete) */
    $this->_conn->delete($this->getTable($table));
    $data = $this->getInsertData($table);

    /* insert new tax settings */
    foreach ($data as $insert) {
        $this->_conn->insert($this->getTable($table), $insert);
    }
}
$query = "DELETE FROM {$this->getTable('directory_country_format')}";
$installer->run($query);
$query="INSERT INTO {$this->getTable('directory_country_format')}  VALUES ('1','NL', 'html','{{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}} {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}<br/>{{depend company}}{{var company}}<br/>{{/depend}}{{if street1}}{{var street1}}{{/if}} {{depend street2}}{{var street2}}{{/depend}} {{depend street3}}{{var street3}}{{/depend}}{{depend street4}}{{var street4}}{{/depend}}<br/>{{if postcode}}{{var postcode}}  {{if city}}{{var city}}<br/>{{var country}}<br/>{{depend telephone}}T: {{var telephone}}{{/depend}}{{depend fax}}<br/>F: {{var fax}}{{/depend}}')";
$installer->run($query);
$query="INSERT INTO {$this->getTable('directory_country_format')}  VALUES ('2','NL', 'text','{{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}} {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}{{depend company}}{{var company}}{{/depend}}{{if street1}}{{var street1}}{{/if}}{{depend street2}}{{var street2}}{{/depend}}{{depend street3}}{{var street3}}{{/depend}}{{depend street4}}{{var street4}}{{/depend}}{{if postcode}}{{var postcode}}  {{if city}}{{var city}}<br/>{{var country}}<br/>{{depend telephone}}T: {{var telephone}}{{/depend}}{{depend fax}}F: {{var fax}}{{/depend}}')";
$installer->run($query);
$query="INSERT INTO {$this->getTable('directory_country_format')}  VALUES ('3','NL', 'pdf','{{depend prefix}}{{var prefix}} {{/depend}}{{var firstname}} {{depend middlename}}{{var middlename}} {{/depend}}{{var lastname}}{{depend suffix}} {{var suffix}}{{/depend}}|{{depend company}}{{var company}}|{{/depend}}{{if street1}}{{var street1}}{{/if}} {{depend street2}}{{var street2}}{{/depend}} {{depend street3}}{{var street3}}{{/depend}}{{depend street4}}{{var street4}}{{/depend}}|{{if postcode}}{{var postcode}}  {{if city}}{{var city}}|{{var country}}|{{depend telephone}}T: {{var telephone}}{{/depend}}|{{depend fax}}<br/>F: {{var fax}}{{/depend}}|')";
$installer->run($query);

$condition = 'scope = \'default\' AND scope_id = 0 AND path = \'catalog/category/root_id\'';
$this->_conn->delete($this->getTable('core_config_data'), $condition);

/* set different config data */
$installer->setConfigData('general/locale/code', 'nl_NL');
$installer->setConfigData('general/locale/timezone', 'Europe/Berlin');
$installer->setConfigData('currency/options/base', 'EUR');
$installer->setConfigData('currency/options/default', 'EUR');
$installer->setConfigData('currency/options/allow', 'EUR');
$installer->setConfigData('general/country/allow', 'NL');
$installer->setConfigData('catalog/category/root_id', '0');
$installer->setConfigData('general/country/default', 'NL');
$installer->setConfigData('general/country/allow', 'NL');
$installer->setConfigData('general/locale/firstday', '1');
$installer->setConfigData('general/locale/weekend', '0,6');
$installer->setConfigData('design/package/ua_regexp', 'a:0:{}');
$installer->setConfigData('design/head/default_title', $configData['default']['shop_name']);
$installer->setConfigData('design/head/title_prefix', '');
$installer->setConfigData('design/head/title_suffix', '');
$installer->setConfigData('design/head/default_description', $configData['default']['meta_description']);
$installer->setConfigData('design/head/default_keywords', $configData['default']['meta_keywords']);
$installer->setConfigData('design/head/default_robots', $configData['default']['meta_robots']);
$installer->setConfigData('design/head/includes', '');
$installer->setConfigData('design/header/logo_src', 'images/logo.gif');
$installer->setConfigData('design/header/logo_alt', $configData['default']['shop_name']);
$installer->setConfigData('design/header/welcome', $configData['default']['welcome_msg']);
$installer->setConfigData('design/footer/copyright', $configData['default']['copyright']);
$installer->setConfigData('design/footer/absolute_footer', '');
$installer->setConfigData('design/watermark/image_size', '');
$installer->setConfigData('design/watermark/image_position', 'stretch');
$installer->setConfigData('design/watermark/small_image_size', '');
$installer->setConfigData('design/watermark/small_image_position', 'stretch');
$installer->setConfigData('design/watermark/thumbnail_size', '');
$installer->setConfigData('design/watermark/thumbnail_position', 'stretch');
$installer->setConfigData('trans_email/ident_general/name', $configData['default']['contact_name']);
$installer->setConfigData('trans_email/ident_general/email', $configData['default']['contact_email']);
$installer->setConfigData('trans_email/ident_sales/name', $configData['default']['contact_sales_name']);
$installer->setConfigData('trans_email/ident_sales/email', $configData['default']['contact_sales_email']);
$installer->setConfigData('trans_email/ident_support/name', $configData['default']['contact_support_name']);
$installer->setConfigData('trans_email/ident_support/email', $configData['default']['contact_support_email']);
$installer->setConfigData('trans_email/ident_custom1/name', $configData['default']['contact_custom1_name']);
$installer->setConfigData('trans_email/ident_custom1/email', $configData['default']['contact_custom1_email']);
$installer->setConfigData('trans_email/ident_custom2/name', $configData['default']['contact_custom2_name']);
$installer->setConfigData('trans_email/ident_custom2/email', $configData['default']['contact_custom2_email']);
$installer->setConfigData('contacts/contacts/enabled', '1');
$installer->setConfigData('contacts/email/recipient_email', $configData['default']['contact_recipient']);
$installer->setConfigData('contacts/email/sender_email_identity', 'general');
$installer->setConfigData('catalog/review/allow_guest', '1');
$installer->setConfigData('catalog/frontend/list_mode', 'grid-list');
$installer->setConfigData('catalog/frontend/grid_per_page_values', '9,15,30');
$installer->setConfigData('catalog/frontend/grid_per_page', '9');
$installer->setConfigData('catalog/frontend/list_per_page_values', '5,10,15,20,25');
$installer->setConfigData('catalog/frontend/list_per_page', '10');
$installer->setConfigData('catalog/productalert/allow_price', '0');
$installer->setConfigData('catalog/productalert/allow_stock', '0');
$installer->setConfigData('catalog/productalert/email_identity', 'general');
$installer->setConfigData('catalog/productalert_cron/frequency', 'D');
$installer->setConfigData('crontab/jobs/catalog_product_alert/schedule/cron_expr', '0 0 * * *');
$installer->setConfigData('crontab/jobs/catalog_product_alert/run/model', 'productalert/observer::process');
$installer->setConfigData('catalog/productalert_cron/time', '00,00,00');
$installer->setConfigData('catalog/productalert_cron/error_email', '');
$installer->setConfigData('catalog/productalert_cron/error_email_identity', 'general');
$installer->setConfigData('catalog/recently_products/scope', 'website');
$installer->setConfigData('catalog/recently_products/viewed_count', '5');
$installer->setConfigData('catalog/recently_products/compared_count', '5');
$installer->setConfigData('catalog/price/scope', '0');
$installer->setConfigData('catalog/search/min_query_length', '1');
$installer->setConfigData('catalog/search/max_query_length', '128');
$installer->setConfigData('catalog/search/max_query_words', '10');
$installer->setConfigData('catalog/search/search_type', '1');
$installer->setConfigData('catalog/search/use_layered_navigation_count', '2000');
$installer->setConfigData('catalog/navigation/max_depth', '0');
$installer->setConfigData('catalog/seo/search_terms', '1');
$installer->setConfigData('catalog/seo/site_map', '1');
$installer->setConfigData('catalog/seo/product_url_suffix', '.html');
$installer->setConfigData('catalog/seo/category_url_suffix', '.html');
$installer->setConfigData('catalog/seo/product_use_categories', '1');
$installer->setConfigData('catalog/seo/title_separator', '-');
$installer->setConfigData('catalog/downloadable/order_status', 'complete');
$installer->setConfigData('catalog/downloadable/downloads_number', '0');
$installer->setConfigData('catalog/downloadable/shareable', '0');
$installer->setConfigData('catalog/downloadable/samples_title', 'Samples');
$installer->setConfigData('catalog/downloadable/links_title', 'Links');
$installer->setConfigData('catalog/downloadable/links_target_new_window', '1');
$installer->setConfigData('catalog/downloadable/content_disposition', 'inline');
$installer->setConfigData('catalog/downloadable/disable_guest_checkout', '1');
$installer->setConfigData('sitemap/category/changefreq', 'daily');
$installer->setConfigData('sitemap/category/priority', '0.5');
$installer->setConfigData('sitemap/product/changefreq', 'daily');
$installer->setConfigData('sitemap/product/priority', '1');
$installer->setConfigData('sitemap/page/changefreq', 'daily');
$installer->setConfigData('sitemap/page/priority', '0.25');
$installer->setConfigData('sitemap/generate/enabled', '1');
$installer->setConfigData('sitemap/generate/time', '00,00,00');
$installer->setConfigData('sitemap/generate/frequency', 'D');
$installer->setConfigData('crontab/jobs/sitemap_generate/schedule/cron_expr', '0 0 * * *');
$installer->setConfigData('crontab/jobs/sitemap_generate/run/model', 'sitemap/observer::scheduledGenerateSitemaps');
$installer->setConfigData('sitemap/generate/error_email', '');
$installer->setConfigData('sitemap/generate/error_email_identity', 'general');
$installer->setConfigData('sendfriend/email/enabled', '1');
$installer->setConfigData('sendfriend/email/allow_guest', '0');
$installer->setConfigData('sendfriend/email/max_recipients', '5');
$installer->setConfigData('sendfriend/email/max_per_hour', '5');
$installer->setConfigData('sendfriend/email/check_by', '0');
$installer->setConfigData('newsletter/subscription/un_email_identity', 'support');
$installer->setConfigData('newsletter/subscription/success_email_identity', 'general');
$installer->setConfigData('newsletter/subscription/confirm_email_identity', 'support');
$installer->setConfigData('newsletter/subscription/confirm', '1');
$installer->setConfigData('newsletter/sending/set_return_path', '0');
$installer->setConfigData('customer/online_customers/online_minutes_interval', '');
$installer->setConfigData('customer/account_share/scope', '1');
$installer->setConfigData('customer/create_account/default_group', '1');
$installer->setConfigData('customer/create_account/email_domain', $configData['default']['email_domain']);
$installer->setConfigData('customer/create_account/email_identity', 'general');
$installer->setConfigData('customer/create_account/confirm', '0');
$installer->setConfigData('customer/password/forgot_email_identity', 'support');
$installer->setConfigData('customer/address/street_lines', '3');
$installer->setConfigData('customer/address/prefix_show', 'req');
$installer->setConfigData('customer/address/prefix_options', $configData['default']['prefix_options']);
$installer->setConfigData('customer/address/middlename_show', '0');
$installer->setConfigData('customer/address/suffix_show', '');
$installer->setConfigData('customer/address/suffix_options', '');
$installer->setConfigData('customer/address/dob_show', '');
$installer->setConfigData('customer/address/taxvat_show', '');
$installer->setConfigData('wishlist/general/active', '1');
$installer->setConfigData('wishlist/email/email_identity', 'general');
$installer->setConfigData('sales_email/order/enabled', '1');
$installer->setConfigData('sales_email/order/identity', 'sales');
$installer->setConfigData('sales_email/order/copy_to', '');
$installer->setConfigData('sales_email/order/copy_method', 'bcc');
$installer->setConfigData('sales_email/order_comment/enabled', '1');
$installer->setConfigData('sales_email/order_comment/identity', 'sales');
$installer->setConfigData('sales_email/order_comment/copy_to', '');
$installer->setConfigData('sales_email/order_comment/copy_method', 'bcc');
$installer->setConfigData('sales_email/invoice/enabled', '1');
$installer->setConfigData('sales_email/invoice/identity', 'sales');
$installer->setConfigData('sales_email/invoice/copy_to', '');
$installer->setConfigData('sales_email/invoice/copy_method', 'bcc');
$installer->setConfigData('sales_email/invoice_comment/enabled', '1');
$installer->setConfigData('sales_email/invoice_comment/identity', 'sales');
$installer->setConfigData('sales_email/invoice_comment/copy_to', '');
$installer->setConfigData('sales_email/invoice_comment/copy_method', 'bcc');
$installer->setConfigData('sales_email/shipment/enabled', '1');
$installer->setConfigData('sales_email/shipment/identity', 'sales');
$installer->setConfigData('sales_email/shipment/copy_to', '');
$installer->setConfigData('sales_email/shipment/copy_method', 'bcc');
$installer->setConfigData('sales_email/shipment_comment/enabled', '1');
$installer->setConfigData('sales_email/shipment_comment/identity', 'sales');
$installer->setConfigData('sales_email/shipment_comment/copy_to', '');
$installer->setConfigData('sales_email/shipment_comment/copy_method', 'bcc');
$installer->setConfigData('sales_email/creditmemo/enabled', '1');
$installer->setConfigData('sales_email/creditmemo/identity', 'sales');
$installer->setConfigData('sales_email/creditmemo/copy_to', '');
$installer->setConfigData('sales_email/creditmemo/copy_method', 'bcc');
$installer->setConfigData('sales_email/creditmemo_comment/enabled', '1');
$installer->setConfigData('sales_email/creditmemo_comment/identity', 'sales');
$installer->setConfigData('sales_email/creditmemo_comment/copy_to', '');
$installer->setConfigData('sales_email/creditmemo_comment/copy_method', 'bcc');
$installer->setConfigData('tax/classes/shipping_tax_class', '4');
$installer->setConfigData('tax/calculation/based_on', 'origin');
$installer->setConfigData('tax/calculation/price_includes_tax', '1');
$installer->setConfigData('tax/calculation/shipping_includes_tax', '0');
$installer->setConfigData('tax/calculation/apply_after_discount', '0');
$installer->setConfigData('tax/calculation/discount_tax', '1');
$installer->setConfigData('tax/calculation/apply_tax_on', '0');
$installer->setConfigData('tax/defaults/country', 'NL');
$installer->setConfigData('tax/defaults/region', '');

if(isset($configData['default']['zip']))
	$zip = $configData['default']['zip'];
else
	$zip = "";

$installer->setConfigData('tax/defaults/postcode', $zip);
$installer->setConfigData('tax/display/column_in_summary', '2');
$installer->setConfigData('tax/display/full_summary', '1');
$installer->setConfigData('tax/display/shipping', '2');
$installer->setConfigData('tax/display/type', '2');
$installer->setConfigData('tax/display/zero_tax', '1');
$installer->setConfigData('tax/weee/enable', '0');
$installer->setConfigData('tax/weee/display_list', '0');
$installer->setConfigData('tax/weee/display', '0');
$installer->setConfigData('tax/weee/display_sales', '0');
$installer->setConfigData('tax/weee/display_email', '0');
$installer->setConfigData('tax/weee/discount', '0');
$installer->setConfigData('tax/weee/apply_vat', '0');
$installer->setConfigData('tax/weee/include_in_subtotal', '0');
$installer->setConfigData('checkout/options/onepage_checkout_disabled', '0');
$installer->setConfigData('checkout/options/guest_checkout', '1');
$installer->setConfigData('checkout/options/enable_agreements', '1');
$installer->setConfigData('checkout/cart/delete_quote_after', '30');
$installer->setConfigData('checkout/cart/redirect_to_cart', '1');
$installer->setConfigData('checkout/cart/grouped_product_image', 'itself');
$installer->setConfigData('checkout/cart/configurable_product_image', 'parent');
$installer->setConfigData('checkout/cart_link/use_qty', '0');
$installer->setConfigData('checkout/sidebar/display', '1');
$installer->setConfigData('checkout/sidebar/count', '3');
$installer->setConfigData('checkout/payment_failed/reciever', 'general');
$installer->setConfigData('checkout/payment_failed/identity', 'general');
$installer->setConfigData('checkout/payment_failed/copy_to', '');
$installer->setConfigData('checkout/payment_failed/copy_method', 'bcc');
$installer->setConfigData('shipping/origin/country_id', 'NL');
$installer->setConfigData('shipping/origin/region_id', '');
$installer->setConfigData('shipping/origin/postcode', $zip);
$installer->setConfigData('shipping/origin/city', $configData['default']['city']);
$installer->setConfigData('shipping/option/checkout_multiple', '1');
$installer->setConfigData('shipping/option/checkout_multiple_maximum_qty', '100');
$installer->setConfigData('dev/restrict/allow_ips', '');
$installer->setConfigData('dev/debug/profiler', '0');
$installer->setConfigData('dev/translate_inline/active', '0');
$installer->setConfigData('dev/translate_inline/active_admin', '0');
$installer->setConfigData('dev/log/active', '0');
$installer->setConfigData('dev/log/file', 'system.log');
$installer->setConfigData('dev/log/exception_file', 'exception.log');
$installer->setConfigData('dev/js/deprecation', '0');
$installer->setConfigData('sales/totals_sort/subtotal', '10');
$installer->setConfigData('sales/totals_sort/discount', '20');
$installer->setConfigData('sales/totals_sort/shipping', '30');
$installer->setConfigData('sales/totals_sort/weee', '50');
$installer->setConfigData('sales/totals_sort/tax', '90');
$installer->setConfigData('sales/totals_sort/grand_total', '100');
$installer->setConfigData('sales/reorder/allow', '1');
$installer->setConfigData('sales/identity/address', $configData['default']['invoice_address']);
$installer->setConfigData('sales/minimum_order/active', '0');
$installer->setConfigData('sales/minimum_order/amount', '');
$installer->setConfigData('sales/minimum_order/description', '');
$installer->setConfigData('sales/minimum_order/error_message', '');
$installer->setConfigData('sales/minimum_order/multi_address', '0');
$installer->setConfigData('sales/minimum_order/multi_address_description', '');
$installer->setConfigData('sales/minimum_order/multi_address_error_message', '');
$installer->setConfigData('sales/gift_messages/allow_order', '0');
$installer->setConfigData('sales/gift_messages/allow_items', '0');
$installer->setConfigData('catalog/custom_options/date_fields_order', 'd,m,y');
$installer->setConfigData('catalog/custom_options/time_format', '24h');
$installer->setConfigData('google/googlebase/target_country', 'NL');
$installer->setConfigData('payment/free/title', 'Geen betaalinformatie benodigd');
$installer->setConfigData('payment/checkmo/title', 'Overboeking');
/* disallow reorder */
$installer->setConfigData('sales/reorder/allow', '0');

/* shipping method codes */
$shippingMethods = array(
    'dhl',
    'ups',
    'usps',
    'fedex',
    'flatrate',
    'tablerate',
    'freeshipping'
);

$errorMsg = 'Deze verzendmethode is momenteel niet beschikbaar. ';
$errorMsg .= 'Neem contact met ons op als u vragen hebt.';

/* set default error message for shipping methods */
foreach ($shippingMethods as $method) {
    $installer->setConfigData('carriers/' . $method . '/specificerrmsg', $errorMsg);
}

/* add weight attribute */
$attributeParameters = array(
    'label' => 'Gewicht',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,    
    'required' => true,
    'user_defined' => true,    
    'default' => '1'
);
$setup->addAttribute('catalog_product', 'weight', $attributeParameters);
// Unfortunately the following fields are not processed by addAttribute method.
// The code bellow will update default values, used in addAttribute.
$attributeParameters = array(
    'is_global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'is_visible' => true,
    'is_filterable' => true,
    'is_searchable' => true,
    'is_comparable' => true,
    'is_visible_on_front' => true,
    'is_visible_in_advanced_search' => true,
    'used_in_product_listing' => true,    
);
$setup->updateAttribute('catalog_product', 'weight', $attributeParameters);

$installer->endSetup();
