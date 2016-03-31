<?php
/**
 * @category	Solide Webservices
 * @package		Flexslider
 */

class SolideWebservices_Flexslider_Model_Layout_Generate_Observer {

	/**
	 * Add scripts depending on configuration values
	 */
	public function loadScripts($observer) {

		if (Mage::helper('flexslider')->isEnabled() == 1) {
			$_head = $this->__getHeadBlock();
			if ($_head) {
				$_head->addFirst('skin_css', 		'flexslider/css/flexslider.css');
				$_head->addFirst('skin_css', 		'flexslider/css/styles.css.php');
				$_head->addEnd('js',				'flexslider/jquery.flexslider-min.js');

				if (Mage::helper('flexslider')->isjQueryEnabled() == 1) {
					if (Mage::helper('flexslider')->versionjQuery() == 'latest') {
						$_head->addBefore(	'js', 	'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', 	'flexslider/jquery.flexslider-min.js');
						$_head->addAfter(	'js', 	'flexslider/jquery.noconflict.js', 								'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
					} elseif (Mage::helper('flexslider')->versionjQuery() == '1.9.1') {
						$_head->addBefore(	'js', 	'flexslider/jquery-1.9.1.min.js', 		'flexslider/jquery.flexslider-min.js');
						$_head->addAfter(	'js', 	'flexslider/jquery.noconflict.js', 		'flexslider/jquery-1.9.1.min.js');
					} elseif (Mage::helper('flexslider')->versionjQuery() == '1.8.3') {
						$_head->addBefore(	'js', 	'flexslider/jquery-1.8.3.min.js', 		'flexslider/jquery.flexslider-min.js');
						$_head->addAfter(	'js', 	'flexslider/jquery.noconflict.js', 		'flexslider/jquery-1.8.3.min.js');
					} elseif (Mage::helper('flexslider')->versionjQuery() == 'oldest') {
						$_head->addBefore(	'js', 	'flexslider/jquery-1.4.3.min.js', 		'flexslider/jquery.flexslider-min.js');
						$_head->addAfter(	'js', 	'flexslider/jquery.noconflict.js', 		'flexslider/jquery-1.4.3.min.js');
					}
					$_head->addAfter(		'js', 	'flexslider/jquery.easing.js', 			'flexslider/jquery.noconflict.js');
					$_head->addAfter(		'js', 	'flexslider/jquery.mousewheel.js', 		'flexslider/jquery.easing.js');
				}
			}
		}
	}

	/*
	 * Get head block
	 */
	private function __getHeadBlock() {
		return Mage::getSingleton('core/layout')->getBlock('flexslider_head');
	}

}