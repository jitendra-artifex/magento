<?php
/**
* aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE-COMMUNITY.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * aheadWorks does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * aheadWorks does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Onsale
 * @version    2.3.2
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE-COMMUNITY.txt
 */

    /**
 * On Sale Data Helper
 */
class AW_Onsale_Helper_Data extends Mage_Core_Helper_Abstract 
{
     /**
     * Current product instance
     * @var Mage_Catalog_Model_Product
     */
	protected $_product;

    /**
     * Cached collection
     * @var Mage_Catalog_Model_Eav_Resource_Product_Collection
     */
    protected $_collection;

    /**
     * Category id
     * @var int|string
     */
    protected $_categoryId;

    /**
     * Default attributes for select with product
     * @var array
     */
    protected $_attributesToSelect = array(
                    'aw_os_product_display',
                    'aw_os_product_image',
                    'aw_os_product_text',
                    'aw_os_product_position',
                    'aw_os_category_display',
                    'aw_os_category_image',
                    'aw_os_category_text',
                    'aw_os_category_position' );

    /**
     * Retrives Product label html
     * (Deprecated from 2.0 Saved for backfunctionality)
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
	public function getProductOnsaleLabelHtml($product) 
    {
        return $this->getProductLabelHtml( $product );
    }
        
    /**
     * Retrives Category label html
     * (Deprecated from 2.0 Saved for backfunctionality)
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
	public function getCategoryOnsaleLabelHtml($product) 
    {
        return $this->getCategoryLabelHtml( $product );
	}

    /**
     * Retrives Product label html
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
    public function getProductLabelHtml( $product )
    {
        return Mage::getSingleton('core/layout')
                ->createBlock('onsale/product_label')
                ->setTemplate('onsale/product/label.phtml')
                ->setProductFlag()
                ->setProduct($product)
                ->toHtml();
    }

    /**
     * Retrives Category label html
     * @param Mage_Catalog_Model_Product $product
     * @return string
     */
    public function getCategoryLabelHtml( $product )
    {
        return Mage::getSingleton('core/layout')
                ->createBlock('onsale/product_label')
                ->setTemplate('onsale/category/label.phtml')
                ->setCategoryFlag()
                ->setProduct($product)
                ->toHtml();
    }

    /**
     * Set up category id
     * @param int|string $categoryId
     * @return AW_Onsale_Helper_Data
     */
    public function setCategoryId( $categoryId )
    {
        $this->_categoryId = $categoryId;
        return $this;
    }

    /**
     * Retrives product collection for this category
     * @return Mage_Catalog_Model_Eav_Resource_Product_Collection
     */
    public function getCollection()
    {
        if ( ! $this->_collection )
        {
            $collection = Mage::getModel('catalog/product')->getLoadedProductCollection();
            if( ! $collection )
            $this->_collection = Mage::getModel('catalog/product')
                                 ->getCollection()
                                 ->setStoreId( Mage::app()->getStore()->getId() )
                                 ->addCategoryFilter( Mage::getSingleton('catalog/category')->setId( $this->_categoryId ) )
                                 ->addAttributeToSelect( Mage::getSingleton('catalog/config')->getProductAttributes() );

            else
            $this->_collection = $collection
                                 ->setStoreId( Mage::app()->getStore()->getId() )
                                 ->addCategoryFilter( Mage::getSingleton('catalog/category')->setId( $this->_categoryId ) )
                                 ->addAttributeToSelect( Mage::getSingleton('catalog/config')->getProductAttributes() );
                                 
            if ( count( $this->_attributesToSelect ) )
            {
                foreach ( $this->_attributesToSelect as $code )
                {
                    $this->_collection->addAttributeToSelect( $code );
                }
            }
        }
        return $this->_collection;
    }

    /**
     * Retrives product instance
     * @param int|string $id
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct($id)
    {
        if(! $this->_product)
            return Mage::getModel('catalog/product')->load($id);
        else
            return $this->_product;

    }

    /**
     * Retrives configuration from product attributes
     * @param string $route
     * @param string $name
     * @param int|string $productId
     * @return mixed
     */
    public function confGetEavValue($route, $name, $product)
    {
        $old = Mage::registry('os_product');

        if (!isset($old['entity_id']) || ($old['entity_id'] !== $product->getId())) {
            /*@deprecated. Reason: big load time*/
            #$product = $this->getProduct($product->getId());
            Mage::unregister('os_product');
            Mage::register('os_product', $product->getData());
        }
        $product = Mage::registry('os_product');

        $name = 'aw_os_' . $route . '_' . $name;
        
        $ttr = isset($product[$name]) ? $product[$name] : '';

        return $ttr;
    }

    /**
     * Retrives configuration from all labels
     * @param string $type
     * @param string $route
     * @param string $name
     * @param object $product
     * @return mixed
     */
    public function confGetCustomValue( $route, $type, $name, $product, $useSystemValue = false )
    {
        if ( $route && $type && $name )
        {
            if ( $type === AW_Onsale_Block_Product_Label::TYPE_CUSTOM )
            {
                $value = $this->confGetEavValue( $route, $name, $product );
                if (!$useSystemValue || $value) {
                    return $value;
                }
                else {
                    return Mage::getStoreConfig("onsale/".$route."_".AW_Onsale_Block_Product_Label::TYPE_ONSALE."_label/".$name);
                }
            }
            else
            {
                return Mage::getStoreConfig("onsale/".$route."_".$type."_label/".$name);
            }
            return Mage::getStoreConfig("onsale/".$route."_".$type."_label/".$name);
        }
        else
        {
            return null;
        }
    }

    /**
     * Retrives product attribute
     * @param string $code
     * @param int|string $productId
     * @return mixed
     */
    public function getAttribute( $code, $product )
    {
        if (($attributes = $product->getAttributes()) && count($attributes)){
            foreach($attributes as $attribute){
                if ($attribute->getAttributeCode() == $code){
                    if ($attribute->getFrontendInput() == 'price') {
                        return Mage::app()->getStore()->convertPrice($attribute->getFrontend()->getValue($product), true);
                    } else {
                        $value = $attribute->getFrontend()->getValue($product);
                        if (is_string($value)){
                            return $value;
                        } else {
                            return null;
                        }
                    }
                }
            }
        }
        return null;
    }

    /**
     * Retrives stock attribute
     * @param string $code
     * @param int|string $productId
     * @return mixed
     */
    public function getStockAttribute( $code, $product )
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
        if ( $stockItem ){
            $this->_inStock = intval($stockItem->getQty());
            return $stockItem->getData($code);
        } else {
            return null;
        }
    }

    /**
     * Retrives custom product attribute
     * @param string $code
     * @param int|string $productId
     * @return mixed
     */
    public function getCustomAttributeValue( $attribute, $product )
    {
        $this->getCollection()->addAttributeToSelect( $attribute )->_loadAttributes()   ;
        return $this->getAttribute( $attribute, $product );
    }
}