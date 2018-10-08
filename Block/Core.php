<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   © Pyxl, Inc. All rights reserved.
 * @license     See LICENSE.txt for license details.
 * @author      Joel Rainwater <jrainwater@pyxl.com>
 */

namespace Pyxl\Pixels\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Core extends \Magento\Framework\View\Element\Template
{

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var \Pyxl\Pixels\Helper\Facebook
     */
    protected $_facebookHelper;

    /**
     * @var \Pyxl\Pixels\Helper\Pinterest
     */
    protected $_pinterestHelper;

    /**
     * @var \Pyxl\Pixels\Helper\Criteo
     */
    protected $_criteoHelper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var array
     */
    protected $_events;

    /**
     * Core constructor.
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param \Pyxl\Pixels\Helper\Facebook $facebook
     * @param \Pyxl\Pixels\Helper\Pinterest $pinterest
     * @param \Pyxl\Pixels\Helper\Criteo $criteo
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Pyxl\Pixels\Helper\Facebook $facebook,
        \Pyxl\Pixels\Helper\Pinterest $pinterest,
        \Pyxl\Pixels\Helper\Criteo $criteo,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_registry = $registry;
        $this->_facebookHelper = $facebook;
        $this->_pinterestHelper = $pinterest;
        $this->_criteoHelper = $criteo;
        $this->_customerSession = $customerSession;
        $this->_events = [
            'fb' => $facebook->getEvents(),
            'pinterest' => $pinterest->getEvents()
        ];
    }

    /**
     * @return \Pyxl\Pixels\Helper\Facebook
     */
    public function getFacebookHelper()
    {
        return $this->_facebookHelper;
    }

    /**
     * @return \Pyxl\Pixels\Helper\Pinterest
     */
    public function getPinterestHelper()
    {
        return $this->_pinterestHelper;
    }

    /**
     * @return \Pyxl\Pixels\Helper\Criteo
     */
    public function getCriteoHelper()
    {
        return $this->_criteoHelper;
    }

    /**
     * Check to see if given even should be
     * tracked for given vendor.
     *
     * @param string $event
     * @param string $vendor
     *
     * @return bool
     */
    public function shouldTrackEvent($event, $vendor)
    {
        if ($event && $vendor && isset($this->_events[$vendor])) {
            return in_array($event, $this->_events[$vendor]);
        }
        return false;
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

    /**
     * Get the current customer email if logged in
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return trim(strtolower($this->_customerSession->getCustomer()->getEmail()));
        }
        return '';
    }
}
