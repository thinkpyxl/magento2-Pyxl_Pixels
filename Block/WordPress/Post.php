<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
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
	public function getPost() {
		if (!$this->_post) {
			$this->_post = $this->_registry->registry('wordpress_post');
		}
		return $this->_post;
	}

}