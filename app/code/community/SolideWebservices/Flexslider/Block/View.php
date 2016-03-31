<?php
/**
 * @category	Solide Webservices
 * @package		Flexslider
 */
 
class SolideWebservices_Flexslider_Block_View extends Mage_Core_Block_Template {

	protected $_position = null;
	protected $_isActive = 1;
	protected $_collection;

	/**
	 * Get Collection
	 *
	 * @return $this->_collection
	 *
	 */
	protected function _getCollection($position = null) {
		if ($this->_collection) {
			return $this->_collection;
		}

		$this->_collection = Mage::getModel('flexslider/group')->getCollection()
				->addEnableFilter($this->_isActive);

		$groupcode = $this->getCode();

		if ($groupcode) {
			$this->_collection->addGroupCodeFilter($groupcode);
		} else {
			$storeId = Mage::app()->getStore()->getId();
			if (!Mage::app()->isSingleStoreMode()) {
				$this->_collection->addStoreFilter($storeId);
			}

			if (Mage::registry('current_category')) {
				$_categoryId = Mage::registry('current_category')->getId();
				$this->_collection->addCategoryFilter($_categoryId);
			} elseif (Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms') {
				$_pageId = Mage::getBlockSingleton('cms/page')->getPage()->getPageId();
				$this->_collection->addPageFilter($_pageId);
			}

			if ($position) {
				$this->_collection->addPositionFilter($position);
			} elseif ($this->_position) {
				$this->_collection->addPositionFilter($this->_position);
			}
		}

		return $this->_collection;
	}

	/**
	 * Determine whether a valid group is set
	 *
	 * @return bool
	 */
	public function hasValidGroup()	{
		if ($this->helper('flexslider')->isEnabled()) {
			return is_object($this->_getCollection());
		}
		return false;
	}

	/**
	 * Retrieve a collection of active slides of the current group
	 *
	 * @return SolideWebservices_Flexslider_Model_Mysql4_Slide_Collection
	 */
	public function getSlides($groupId) {		
		$slide_collection = Mage::getModel('flexslider/slide')->getCollection()
				->addGroupIdFilter($groupId)
				->addIsEnabledFilter('is_enabled', '1')
				->addOrderBySortOrder('ASC');

		return $slide_collection;
	}

}