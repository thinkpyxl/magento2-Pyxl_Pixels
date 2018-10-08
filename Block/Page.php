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

class Page extends Core
{

    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_page;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        \Pyxl\Pixels\Helper\Facebook $facebook,
        \Pyxl\Pixels\Helper\Pinterest $pinterest,
        \Pyxl\Pixels\Helper\Criteo $criteo,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Cms\Model\Page $page,
        array $data = []
    ) {
        parent::__construct($context, $registry, $facebook, $pinterest, $criteo, $customerSession, $data);
        $this->_page = $page;
    }

    /**
     * Retrieve Page instance
     *
     * @return \Magento\Cms\Model\Page|null
     */
    public function getPage()
    {
        return $this->_page ?: null;
    }
}
