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

class PinterestEvents implements OptionSourceInterface
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
                'label' => __('Checkout'),
                'value' => 'checkout'
            ],
            [
                'label' => __('Add to Cart'),
                'value' => 'AddToCart'
            ],
            [
                'label' => __('Page Visit'),
                'value' => 'pagevisit'
            ],
            [
                'label' => __('Signup'),
                'value' => 'signup'
            ],
            // @todo implement watch video
            [
                'label' => __('Watch Video'),
                'value' => 'watchvideo'
            ],
            [
                'label' => __('Lead'),
                'value' => 'lead'
            ],
            [
                'label' => __('Search'),
                'value' => 'search'
            ],
            [
                'label' => __('View Category'),
                'value' => 'viewcategory'
            ],
        ];
        return $options;
    }
}
