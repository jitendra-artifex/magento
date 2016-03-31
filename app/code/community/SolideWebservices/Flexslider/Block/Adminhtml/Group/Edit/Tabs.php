<?php
/**
 * @category	Solide Webservices
 * @package		Flexslider
 */
 
class SolideWebservices_Flexslider_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

	public function __construct() {
		parent::__construct();
		$this->setId('flexslider_group_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('flexslider')->__('Flexslider - Groups'));
	}

	protected function _beforeToHtml() {
		$this->addTab('general_section', array(
			'label'		=> Mage::helper('flexslider')->__('General Information'),
			'title'		=> Mage::helper('flexslider')->__('General Information'),
			'content'	=> $this->getLayout()->createBlock('flexslider/adminhtml_group_edit_tab_form')->toHtml(),
		))->addTab('page_section', array(
			'label'		=> Mage::helper('flexslider')->__('Display on Pages'),
			'title'		=> Mage::helper('flexslider')->__('Display on Pages'),
			'content'	=> $this->getLayout()->createBlock('flexslider/adminhtml_group_edit_tab_page')->toHtml(),
		))->addTab('category_section', array(
			'label'		=> Mage::helper('flexslider')->__('Display on Categories'),
			'title'		=> Mage::helper('flexslider')->__('Display on Categories'),
			'content'	=> $this->getLayout()->createBlock('flexslider/adminhtml_group_edit_tab_category')->toHtml(),
		));
		if ($this->getRequest()->getParam('id')) {
			$this->addTab('slides_section', array(
				'label'		=> Mage::helper('flexslider')->__('Slides of this Group'),
				'title'		=> Mage::helper('flexslider')->__('Slides of this Group'),
				'content'	=> $this->getLayout()->createBlock('flexslider/adminhtml_group_edit_tab_slides')->toHtml(),
			))->addTab('xml_section', array(
				'label'		=> Mage::helper('flexslider')->__('Use Code Inserts'),
				'title'		=> Mage::helper('flexslider')->__('Use Code Inserts'),
				'content'	=> $this->getLayout()->createBlock('flexslider/adminhtml_group_edit_tab_XML')->toHtml(),
			));
		}
		

		return parent::_beforeToHtml();
	}
}