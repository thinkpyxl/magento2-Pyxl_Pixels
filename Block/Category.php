<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   © Pyxl, Inc. All rights reserved.
 * @license     See LICENSE.txt for license details.
 * @author      Joel Rainwater <jrainwater@pyxl.com>
 */

namespace Pyxl\Pixels\Block;

class Category extends Core
{

    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $_category;

    /**
     * @var array
     */
    protected $_items;

    /**
     * @return \Magento\Catalog\Model\Category
     */
    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = $this->_registry->registry('current_category');
        }
        return $this->_category;
    }

    /**
     * Gets json string of all products in current category
     *
     * @return string
     */
    public function getProductsArray()
    {
        return json_encode($this->getItems());
    }

    /**
     * Gets only the first 3 items for criteo json
     *
     * @return string
     */
    public function getCriteoItems()
    {
        return json_encode(
            array_slice($this->getItems(), 0, 3)
        );
    }

    /**
     * Gets and saves array of items
     * @todo Optimize this if only calling criteo with limit of 3
     *
     * @return array
     */
    public function getItems()
    {
        if (!$this->_items) {
            $items = [];
            /** @var \Magento\Eav\Model\Entity\Collection\AbstractCollection $collection */
            if ($collection = $this->_registry->registry('pyxl_pixels_product_collection')) {
                /** @var \Magento\Catalog\Model\Product $item */
                foreach ($collection as $item) {
                    $items[] = $item->getSku();
                }
            }
            $this->_items = $items;
        }
        return $this->_items;
    }
}
