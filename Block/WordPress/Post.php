<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   © Pyxl, Inc. All rights reserved.
 * @license     See LICENSE.txt for license details.
 * @author      Joel Rainwater <jrainwater@pyxl.com>
 */

namespace Pyxl\Pixels\Block\WordPress;

class Post extends \Pyxl\Pixels\Block\Core
{

    /**
     * @var \FishPig\WordPress\Model\Post
     */
    protected $_post;

    /**
     * @return \FishPig\WordPress\Model\Post
     */
    public function getPost()
    {
        if (!$this->_post) {
            $this->_post = $this->_registry->registry('wordpress_post');
        }
        return $this->_post;
    }
}
