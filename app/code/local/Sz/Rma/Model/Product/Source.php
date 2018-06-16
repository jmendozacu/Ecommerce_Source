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

/**
 * Source Model of Product's Attribute Enable RMA
 *
 * @category   Sz
 * @package    Sz_Rma
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Sz_Rma_Model_Product_Source extends Mage_Eav_Model_Entity_Attribute_Source_Boolean
{
    /**
     * XML configuration path allow RMA on product level
     */
    const XML_PATH_PRODUCTS_ALLOWED = 'sales/sz_rma/enabled_on_product';

    /**
     * Constants - attribute value
     */
    const ATTRIBUTE_ENABLE_RMA_YES = 1;
    const ATTRIBUTE_ENABLE_RMA_NO = 0;
    const ATTRIBUTE_ENABLE_RMA_USE_CONFIG = 2;

    /**
     * Retrieve all attribute options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('sz_rma')->__('Yes'),
                    'value' => self::ATTRIBUTE_ENABLE_RMA_YES
                ),
                array(
                    'label' => Mage::helper('sz_rma')->__('No'),
                    'value' => self::ATTRIBUTE_ENABLE_RMA_NO
                ),
                array(
                    'label' => Mage::helper('sz_rma')->__('Use config'),
                    'value' => self::ATTRIBUTE_ENABLE_RMA_USE_CONFIG
                )
            );
        }
        return $this->_options;
    }
}
