<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
 */

namespace Pyxl\Pixels\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CatalogBlockProductListObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * CatalogBlockProductListObserver constructor.
     *
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->_registry = $registry;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->_registry->registry('pyxl_pixels_product_collection')) {
            $collection = $observer->getData('collection');
            $this->_registry->register('pyxl_pixels_product_collection', $collection);
        }
    }
}
