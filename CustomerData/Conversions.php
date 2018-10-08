<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
 */

namespace Pyxl\Pixels\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class Conversions
	extends \Magento\Framework\DataObject
	implements SectionSourceInterface
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
	 * Conversions constructor.
	 *
	 * @param \Magento\Checkout\Model\Session $session
	 * @param \Pyxl\Pixels\Helper\Facebook $facebook
	 * @param \Pyxl\Pixels\Helper\Pinterest $pinterest
	 * @param array $data
	 */
	public function __construct(
		\Magento\Checkout\Model\Session $session,
		\Pyxl\Pixels\Helper\Facebook $facebook,
		\Pyxl\Pixels\Helper\Pinterest $pinterest,
		array $data = []
	) {
		parent::__construct( $data );
		$this->_checkoutSession = $session;
		$this->_fbHelper = $facebook;
		$this->_pinterestHelper = $pinterest;
	}

	/**
	 * Get data
	 *
	 * @return array
	 */
	public function getSectionData() {
		$data = [
			'events' => []
		];

		// make sure data exists first
		if ($this->_checkoutSession->hasAddToCartData()) {
			/**
			 * @var $checkoutData array
			 * Formatted as
			 * [
			 *  'skus' => [string],
			 *  'value' => float,
			 *  'currency' => string,
			 *  'qty' => int
			 * ]
			 */
			$checkoutData = $this->_checkoutSession->getAddToCartData();

			// Check for FB tracking enabled
			if ($this->_fbHelper->isEnabled() && $this->_fbHelper->shouldTrackEvent('AddToCart')) {
				$data['events'][] = [
					'vendor' => 'facebook',
					'eventName' => 'AddToCart',
					'eventData' => $this->buildFacebookData($checkoutData)
				];
			}

			// Check for Pinterest tracking enabled
			if ($this->_pinterestHelper->isEnabled() && $this->_pinterestHelper->shouldTrackEvent('AddToCart')) {
				$data['events'][] = [
					'vendor' => 'pinterest',
					'eventName' => 'AddToCart',
					'eventData' => $this->buildPinterestData($checkoutData)
				];
			}
		}

		return $data;
	}

	/**
	 * Build Facebook formatted array from AddToCart data
	 *
	 * @param array $checkoutData
	 * @return array
	 */
	protected function buildFacebookData( $checkoutData ) {
		$fbData = [
			'content_type' => 'product',
			'content_ids' => $checkoutData['skus'],
			'value' => $checkoutData['value'],
			'currency' => $checkoutData['currency']
		];
		return $fbData;
	}

	/**
	 * Build Pinterest formatted array from AddToCart data
	 *
	 * @param array $checkoutData
	 * @return array
	 */
	protected function buildPinterestData( $checkoutData ) {
		$pinData = [
			'value' => $checkoutData['value'],
			'order_quantity' => $checkoutData['qty'],
			'currency' => $checkoutData['currency']
		];
		return $pinData;
	}

}