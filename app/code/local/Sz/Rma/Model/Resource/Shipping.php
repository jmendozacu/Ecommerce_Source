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
 * RMA shipping resource model
 *
 * @category   Sz
 * @package    Sz_Rma
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Sz_Rma_Model_Resource_Shipping extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Internal constructor
     */
    protected function _construct() {
        $this->_init('sz_rma/rma_shipping_label', 'entity_id');
    }

    /**
     * Delete tracking numbers for current rma shipping label
     *
     * @var Sz_Rma_Model_Rma|int $rma
     * @return string
     */
    public function deleteTrackingNumbers($rma)
    {
        if (!is_int($rma)) {
            $rma = $rma->getId();
        }

        $adapter = $this->_getWriteAdapter();

        $where = $adapter->quoteInto('rma_entity_id = ? ', $rma);
        $where .= $adapter->quoteInto(
            'AND is_admin = ? ',
            Sz_Rma_Model_Shipping::IS_ADMIN_STATUS_ADMIN_LABEL_TRACKING_NUMBER
        );

        return $adapter->delete($this->getTable('sz_rma/rma_shipping_label'), $where);
    }
}
