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
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 */

/**
 * Adds most attribute.
 *
 * @category   RocketWeb
 * @package    RocketWeb_ProductVideo
 * @author     Daniel Ifrim
 */

$installer = $this;
/* @var $installer RocketWeb_ProductVideo_Model_Resource_Eav_Mysql4_Setup */

$this->startSetup()->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('rw_youtube_videos')} (
  `video_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL default '0',
  `video_code` varchar(256) DEFAULT NULL,
  `video_title` text,
  `video_thumb_width` varchar(256) DEFAULT NULL,
  `video_thumb_height` varchar(256) DEFAULT NULL,
  `video_width` varchar(256) DEFAULT NULL,
  `video_height` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`video_id`),
  KEY `RW_YOUTUBE_VIDEO_PRODUCT_ID_PRODUCT_ENTITY_ID` (`product_id`),
  KEY `RW_YOUTUBE_VIDEO_STORE_ID_STORE_ID` (`store_id`),
  CONSTRAINT `RW_YOUTUBE_VIDEO_PRODUCT_ID_PRODUCT_ENTITY_ID` FOREIGN KEY (`product_id`) REFERENCES {$this->getTable('catalog_product_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `RW_YOUTUBE_VIDEO_STORE_ID_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



INSERT INTO {$this->getTable('rw_youtube_videos')} SELECT * FROM 
(
    SELECT NULL as video_id, c.entity_id as product_id, c.store_id, c.value as video_code, d.value as video_title, e.value as video_thumb_width, f.value as video_thumb_height, g.value as video_width, h.value as video_height FROM

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_varchar')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_code') as c

    LEFT JOIN

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_varchar')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_title') as d USING(entity_id, store_id)
    
    LEFT JOIN

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_int')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_thumb_width') as e USING(entity_id, store_id)
    
    LEFT JOIN

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_int')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_thumb_height') as f USING(entity_id, store_id)
    
    LEFT JOIN

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_int')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_width') as g USING(entity_id, store_id)
    
    LEFT JOIN

        (SELECT b.entity_id, b.store_id, b.value FROM {$this->getTable('eav_attribute')} AS a LEFT JOIN {$this->getTable('catalog_product_entity_int')} as b ON a.attribute_id = b.attribute_id WHERE a.attribute_code = 'rw_video_height') as h USING(entity_id, store_id)
) as i WHERE i.product_id IS NOT NULL;



DELETE FROM {$this->getTable('eav_attribute')} WHERE attribute_code='rw_video_code' OR attribute_code='rw_video_title' OR attribute_code='rw_video_thumb_width' OR attribute_code='rw_video_thumb_height' OR attribute_code='rw_video_width' OR attribute_code='rw_video_height';

DELETE FROM {$this->getTable('eav_attribute_group')} WHERE attribute_group_name = 'Video';

")->endSetup();