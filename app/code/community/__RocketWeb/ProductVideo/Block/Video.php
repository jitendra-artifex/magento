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

/**
 * Simple product video view
 *
 */
class RocketWeb_ProductVideo_Block_Video extends Mage_Catalog_Block_Product_View_Abstract
{
    protected $_videosCollection = null;
	
	
    public function getCode($video)
	{
	   return $video->getVideoCode();
	}
    
    public function getTitle($video)
	{
		if ($video->getVideoTitle())
		{
			return $video->getVideoTitle();
		}
		else
		{
			return $this->getProduct()->getName();
		}
	}
    
    public function getThumbWidth($video)
	{
		if ($video->getVideoThumbWidth())
		{
			return $video->getVideoThumbWidth();
		}
		else
		{
			return $this->helper('productvideo/data')->getDefaultThumbWidth();
		}
	}
	
	public function getThumbHeight($video)
	{
		if ($video->getVideoThumbHeight())
		{
			return $video->getVideoThumbHeight();
		}
		else
		{
			return $this->helper('productvideo/data')->getDefaultThumbHeight();
		}
		return $height;
	}
	
	public function getWidth($video)
	{
		if ($video->getVideoWidth())
		{
			return $video->getVideoWidth();
		}
		else
		{
			return $this->helper('productvideo/data')->getDefaultWidth();
		}
	}

	public function getHeight($video)
	{
		if ($video->getVideoHeight())
		{
			return $video->getVideoHeight();
		}
		else
		{
			return $this->helper('productvideo/data')->getDefaultHeight();
		}
	}

    public function getHost($video)
    {
        if ($video->getVideoHost())
        {
            return $video->getVideoHost();
        }

        return false;
    }
    
    protected function _getProductVideos()
    {
        $storeId = Mage::app()->getStore()->getId();
        
        if (is_null($this->_videosCollection))
    	{
            $this->_videosCollection = $this->_getVideosCollection($storeId)->getSize() ? $this->_getVideosCollection($storeId) : $this->_getVideosCollection();
    	}
        
        return $this->_videosCollection;
    }
    
    
    protected function _getVideosCollection($storeId = 0)
    {
        return Mage::getModel('productvideo/videos')
            ->getCollection()
 			->addFieldToFilter('product_id', $this->getProduct()->getId())
            ->addFieldToFilter('store_id', $storeId);
    }

    protected function _getVimeoThumbnail($id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "vimeo.com/api/v2/video/".$id.".php");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = unserialize(curl_exec($ch));
        $thumbnail = $output[0]['thumbnail_medium'];
        curl_close($ch);
        return $thumbnail;
    }
}