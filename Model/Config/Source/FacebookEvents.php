<?php
/**
 * @category    Pyxl
 * @package     Pyxl_Pixels
 * @copyright   2017 Joel Rainwater
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 * @author      Joel Rainwater <jrainwater@thinkpyxl.com>
 */

namespace Pyxl\Pixels\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class FacebookEvents implements OptionSourceInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('View Content'),
                'value' => 'ViewContent'
            ],
            [
                'label' => __('Search'),
                'value' => 'Search'
            ],
            [
                'label' => __('Add to Cart'),
                'value' => 'AddToCart'
            ],
            [
                'label' => __('Add to Wishlist'),
                'value' => 'AddToWishlist'
            ],
            [
                'label' => __('Initiate Checkout'),
                'value' => 'InitiateCheckout'
            ],
            [
                'label' => __('Add Payment Info'),
                'value' => 'AddPaymentInfo'
            ],
            [
                'label' => __('Make Purchase'),
                'value' => 'Purchase'
            ],
            [
                'label' => __('Lead'),
                'value' => 'Lead'
            ],
            [
                'label' => __('Complete Registration'),
                'value' => 'CompleteRegistration'
            ],
        ];
        return $options;
    }
}
