<?php
/**
 * Magento Sz Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Sz Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/sz-edition
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
 * @category    Sz
 * @package     Sz_Rma
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/sz-edition
 */

//Product's Attribute is_returnable shouldn't be applied to grouped product
//Because it has no sense
$installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');

$applyTo = Mage_Catalog_Model_Product_Type::TYPE_SIMPLE . ',' .
    Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE . ',' .
    Mage_Catalog_Model_Product_Type::TYPE_BUNDLE;

$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'is_returnable', 'apply_to', $applyTo);