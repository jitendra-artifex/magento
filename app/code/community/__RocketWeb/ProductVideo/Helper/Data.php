<?php

/**
 * RocketWeb
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   RocketWeb
 * @package    RocketWeb_ProductVideo
 * @copyright  Copyright (c) 2011 RocketWeb (http://rocketweb.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     RocketWeb
 */

class RocketWeb_ProductVideo_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_TINYBOX_ENABLED         = 'rocketweb_productvideo/settings/tinybox';
	const XML_PATH_DEFAULT_THUMB_WIDTH     = 'rocketweb_productvideo/settings/default_thumb_width';
	const XML_PATH_DEFAULT_THUMB_HEIGHT    = 'rocketweb_productvideo/settings/default_thumb_height';
	const XML_PATH_DEFAULT_WIDTH           = 'rocketweb_productvideo/settings/default_width';
	const XML_PATH_DEFAULT_HEIGHT          = 'rocketweb_productvideo/settings/default_height';
	const XML_PATH_OVERLAY_OPACITY         = 'rocketweb_productvideo/settings/overlay_opacity';

    public function getTinyBoxEnabled()
    {
        return Mage::getStoreConfig(self::XML_PATH_TINYBOX_ENABLED);
    }

	public function getDefaultThumbWidth()
	{
		return Mage::getStoreConfig(self::XML_PATH_DEFAULT_THUMB_WIDTH);
	}
	
	public function getDefaultThumbHeight()
	{
		return Mage::getStoreConfig(self::XML_PATH_DEFAULT_THUMB_HEIGHT);
	}
	
	public function getDefaultWidth()
	{
		return Mage::getStoreConfig(self::XML_PATH_DEFAULT_WIDTH);
	}
	
	public function getDefaultHeight()
	{
		return Mage::getStoreConfig(self::XML_PATH_DEFAULT_HEIGHT);
	}

	public function getOverlayOpacity()
	{
		return Mage::getStoreConfig(self::XML_PATH_OVERLAY_OPACITY);
	}
}