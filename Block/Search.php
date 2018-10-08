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

class Search extends Category
{

    /**
     * @var \Magento\Search\Helper\Data
     */
    protected $_searchHelper;

    /**
     * Search constructor.
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param \Pyxl\Pixels\Helper\Facebook $facebook
     * @param \Pyxl\Pixels\Helper\Pinterest $pinterest
     * @param \Pyxl\Pixels\Helper\Criteo $criteo
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Search\Helper\Data $searchHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        \Pyxl\Pixels\Helper\Facebook $facebook,
        \Pyxl\Pixels\Helper\Pinterest $pinterest,
        \Pyxl\Pixels\Helper\Criteo $criteo,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Search\Helper\Data $searchHelper,
        array $data = []
    ) {
        parent::__construct($context, $registry, $facebook, $pinterest, $criteo, $customerSession, $data);
        $this->_searchHelper = $searchHelper;
    }

    /**
     * @return bool|string
     */
    public function getSearchString()
    {
        $query = $this->_searchHelper->getEscapedQueryText();
        if (!$query || $query !== "") :
            $query = false;
        endif;

        return $query;
    }
}
