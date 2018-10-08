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

/**
 * Class Core
 * @package Pyxl\Pixels\Helper
 *
 * Abstract helper all vendor helpers will extend
 */
abstract class Core extends \Magento\Framework\App\Helper\AbstractHelper
{

	/**
	 * @var array
	 */
	protected $_settings;

	/**
	 * @var array
	 */
	protected $_config;

	/**
	 * Core constructor.
	 *
	 * @param Context $context
	 */
	public function __construct( Context $context ) {
		parent::__construct( $context );
		$this->_config = $this->scopeConfig->getValue(
			'pyxl_pixels',
			\Magento\Store\Model\ScopeInterface::SCOPE_STORE
		);
	}

	/**
	 * Returns if given vendor Events is enabled
	 *
	 * @return bool
	 */
	public function isEnabled() {
		return $this->_settings['enable'];
	}

	/**
	 * Returns given vendor Account ID
	 *
	 * @return string|null
	 */
	public function getAccountId() {
		return $this->_settings['account_id'];
	}

	/**
	 * Returns all selected events to be tracked of given vendor
	 *
	 * @return array|null
	 */
	public function getEvents() {
		$events = $this->_settings['events'];
		return explode(',', $events);
	}

	/**
	 * Check if the given event is selected to be tracked
	 *
	 * @param string $event
	 * @return bool
	 */
	public function shouldTrackEvent( $event ) {
		if ($event) {
			return in_array($event, $this->getEvents());
		}
		return false;
	}

}