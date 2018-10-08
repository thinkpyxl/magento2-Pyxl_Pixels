<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
 */

namespace Pyxl\Pixels\Helper;

use Magento\Framework\App\Helper\Context;

class Facebook extends Core
{

	/**
	 * @var array
	 */
	protected $_settings;

	/**
	 * Facebook constructor.
	 *
	 * @param Context $context
	 */
	public function __construct( Context $context ) {
		parent::__construct( $context );
		$this->_settings =
			isset($this->_config['fb'])
				? $this->_config['fb']
				: ['enable' => false];
	}

}