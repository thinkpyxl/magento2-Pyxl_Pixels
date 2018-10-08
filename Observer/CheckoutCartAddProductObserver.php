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

class CheckoutCartAddProductObserver implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Pyxl\Pixels\Helper\Facebook
     */
    protected $_fbHelper;

    /**
     * @var \Pyxl\Pixels\Helper\Pinterest
     */
    protected $_pinterestHelper;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_resolver;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * CheckoutCartAddProductObserver constructor.
     *
     * @param \Magento\Checkout\Model\Session $session
     * @param \Pyxl\Pixels\Helper\Facebook $facebook
     * @param \Pyxl\Pixels\Helper\Pinterest $pinterest
     * @param \Magento\Framework\Locale\ResolverInterface $resolver
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Checkout\Model\Session $session,
        \Pyxl\Pixels\Helper\Facebook $facebook,
        \Pyxl\Pixels\Helper\Pinterest $pinterest,
        \Magento\Framework\Locale\ResolverInterface $resolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_checkoutSession = $session;
        $this->_fbHelper = $facebook;
        $this->_pinterestHelper = $pinterest;
        $this->_resolver = $resolver;
        $this->_storeManager = $storeManager;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->shouldTrackAddToCart()) {
            /** @var \Magento\Catalog\Model\Product $product */
            $product = $observer->getData('product');
            /** @var \Magento\Framework\App\RequestInterface $request */
            $request = $observer->getData('request');
            /** @var array $params */
            $params = $request->getParams();

            $qty = 1;
            if (isset($params['qty'])) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_resolver->getLocale()]
                );
                $qty = $filter->filter($params['qty']);
            }

            $data = [
                'skus' => [$product->getSku()],
                'value' => ($product->getFinalPrice([$qty])),
                'currency' => $this->getCurrencyCode(),
                'qty' => $qty
            ];
            $this->_checkoutSession->setAddToCartData($data);
        }
    }

    /**
     * This checks each of the vendors to see if at least
     * one of them is enabled and set to track AddToCart
     *
     * @return bool
     */
    protected function shouldTrackAddToCart()
    {
        return (
            ($this->_fbHelper->isEnabled() && $this->_fbHelper->shouldTrackEvent('AddToCart')) ||
            ($this->_pinterestHelper->isEnabled() && $this->_pinterestHelper->shouldTrackEvent('AddToCart'))
        );
    }

    /**
     * Gets the current store currency code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->_storeManager
            ->getStore()
            ->getCurrentCurrency()
            ->getCode();
    }
}
