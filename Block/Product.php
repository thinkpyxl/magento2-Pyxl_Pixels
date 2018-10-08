<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   © Pyxl, Inc. All rights reserved.
 * @license     See LICENSE.txt for license details.
 * @author      Joel Rainwater <jrainwater@pyxl.com>
 */

namespace Pyxl\Pixels\Block;

class Product extends Core
{

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_registry->registry('current_product');
        }
        return $this->_product;
    }

    /**
     * Get product category name
     * This is pulled from registry so defers to
     * the current category if registered. This means
     * it will tell us where the user came from if
     * they came from a category.
     *
     * @return null|string
     */
    public function getCategory()
    {
        $result = '';
        if ($product = $this->getProduct()) {
            $category = $product->getCategory();
            if ($category && $category->getId()) {
                return $category->getName();
            }
        }
        return $result;
    }
}
