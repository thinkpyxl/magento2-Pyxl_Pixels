<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
 */

namespace Pyxl\Pixels\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Checkout extends Core
{

	/**
	 * @var \Magento\Quote\Model\Quote
	 */
	protected $_quote;

	/**
	 * @var \Magento\Sales\Model\Order
	 */
	protected $_order;

	/**
	 * @var float
	 */
	protected $_itemsQty;

	/**
	 * @var \Magento\Checkout\Model\Session
	 */
	protected $_checkoutSession;

	/**
	 * Checkout constructor.
	 *
	 * @param Template\Context $context
	 * @param Registry $registry
	 * @param \Pyxl\Pixels\Helper\Facebook $facebook
	 * @param \Pyxl\Pixels\Helper\Pinterest $pinterest
	 * @param \Pyxl\Pixels\Helper\Criteo $criteo
	 * @param \Magento\Customer\Model\Session $customerSession
	 * @param \Magento\Checkout\Model\Session $checkoutSession
	 * @param array $data
	 */
	public function __construct(
		Template\Context $context,
		Registry $registry,
		\Pyxl\Pixels\Helper\Facebook $facebook,
		\Pyxl\Pixels\Helper\Pinterest $pinterest,
		\Pyxl\Pixels\Helper\Criteo $criteo,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Checkout\Model\Session $checkoutSession,
		array $data = []
	) {
		parent::__construct( $context, $registry, $facebook, $pinterest, $criteo, $customerSession, $data );
		$this->_checkoutSession = $checkoutSession;
	}

	/**
	 * @return \Magento\Quote\Model\Quote
	 */
	public function getQuote() {
		if (!$this->_quote) {
			$this->_quote = $this->_checkoutSession->getQuote();
		}
		return $this->_quote;
	}

	/**
	 * @return \Magento\Sales\Model\Order
	 */
	public function getOrder() {
		if (!$this->_order) {
			$this->_order = $this->_checkoutSession->getLastRealOrder();
		}
		return $this->_order;
	}

	/**
	 * Returns grand total rounded to 2 decimals
	 *
	 * @return float
	 */
	public function getGrandTotal() {
		return round(
			$this->getOrder()->getGrandTotal(),
			2
		);
	}

	/**
	 * Returns all item SKUs in json format for FB
	 * Also counts total qty while we're looping
	 *
	 * @return string
	 */
	public function getItemIds() {
		$ids = [];
		$qty = 0;
		if ($order = $this->getOrder()) {
			$items = $order->getAllVisibleItems();
			/** @var \Magento\Sales\Model\Order\Item $item */
			foreach ($items as $item) {
				if ($item->getParentItem()) {
					continue;
				}
				$ids[] = $item->getSku();
				$qty += round($item->getQtyOrdered());
			}
		}
		$this->_itemsQty = $qty; // save this for later
		return json_encode(array_unique($ids));
	}

	/**
	 * @return float|int
	 */
	public function getItemsQty() {
		// just in case it didn't save or run before
		if (!$this->_itemsQty) {
			$qty = 0;
			if ($order = $this->getOrder()) {
				$items = $order->getAllVisibleItems();
				/** @var \Magento\Sales\Model\Order\Item $item */
				foreach ($items as $item) {
					if ($item->getParentItem()) {
						continue;
					}
					$qty += round($item->getQtyOrdered());
				}
			}
			$this->_itemsQty = $qty;
		}
		return $this->_itemsQty;
	}

	/**
	 * Returns json encoded item array
	 * from order for given vendor
	 *
	 * @param string $vendor
	 * @return mixed|string
	 */
	public function getOrderItems($vendor) {
		$itemData = [];
		if ($vendor && $order = $this->getOrder()) {
			/** @var \Magento\Sales\Model\Order\Item $item */
			foreach ($order->getAllVisibleItems() as $item) {
				switch ($vendor) {
					case 'pinterest':
						$itemData[] = $this->buildPinterestItem(
							$item->getName(),
							$item->getSku(),
							round($item->getPrice(), 2),
							round($item->getQtyOrdered())
						);
						break;
					case 'criteo':
						$itemData[] = $this->buildCriteoItem(
							$item->getSku(),
							round($item->getPrice(), 2),
							round($item->getQtyOrdered())
						);
						break;
					default:
						break;
				}
			}
		}
		return json_encode($itemData);
	}

	/**
	 * Returns json encoded item array
	 * from quote for given vendor
	 *
	 * @param string $vendor
	 * @return mixed|string
	 */
	public function getQuoteItems($vendor) {
		$itemData = [];
		if ($vendor && $quote = $this->getQuote()) {
			/** @var \Magento\Quote\Model\Quote\Item $item */
			foreach ($quote->getAllVisibleItems() as $item) {
				switch ($vendor) {
					case 'pinterest':
						$itemData[] = $this->buildPinterestItem(
							$item->getName(),
							$item->getSku(),
							round($item->getPrice() - $item->getDiscountAmount(),2),
							round($item->getQty())
						);
						break;
					case 'criteo':
						$itemData[] = $this->buildCriteoItem(
							$item->getSku(),
							round($item->getPrice() - $item->getDiscountAmount(),2),
							round($item->getQty())
						);
						break;
					default:
						break;
				}
			}
		}
		return json_encode($itemData);
	}

	/**
	 * @param string $id
	 * @param float $price
	 * @param int|float $qty
	 *
	 * @return array
	 */
	protected function buildCriteoItem( $id, $price, $qty ) {
		return [
			'id' => $id,
			'price' => $price,
			'quantity' => $qty
		];
	}

	/**
	 * @param string $name
	 * @param string $id
	 * @param float $price
	 * @param int|float $qty
	 *
	 * @return array
	 */
	protected function buildPinterestItem( $name, $id, $price, $qty ) {
		return [
			"product_name" => $name,
			"product_id" => $id,
			"product_price" => $price,
			"product_quantity" => $qty
		];
	}

}