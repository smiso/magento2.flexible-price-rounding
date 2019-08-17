<?php
/**
 * Flexible Price Rounding
 *
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @author      Karliuka Vitalii <karliuka.vitalii@gmail.com>
 * @author      Daniel Kradolfer <kra@smilesolutions.ch>
 *
 * @package     SmileSolutions_FlexiblePriceRounding (former Faonni_Price)
 * @copyright   Copyright (c) 2019 Daniel Kradolfer, smile solutions gmbh <kra@smilesolutions.ch>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * -----------------------------------------------------------------------------------------
 * based on:
 * =========
 * Package: Faonni_Price 2.0.13 (https://github.com/karliuka/m2.Price)
 * Copyright (c) 2016 Karliuka Vitalii (karliuka.vitalii@gmail.com)
 * License: http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * -----------------------------------------------------------------------------------------
 */

namespace SmileSolutions\FlexiblePriceRounding\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use SmileSolutions\FlexiblePriceRounding\Model\Math;

/**
 * Round Type Source Option
 */
class Type implements OptionSourceInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Math::TYPE_CEIL, 'label' => __('Round fractions up')],
            ['value' => Math::TYPE_FLOOR, 'label' => __('Round fractions down')],
            ['value' => Math::TYPE_SWEDISH_CEIL, 'label' => __('Swedish Round up')],
            ['value' => Math::TYPE_SWEDISH_ROUND, 'label' => __('Swedish Round')],
            ['value' => Math::TYPE_SWEDISH_FLOOR, 'label' => __('Swedish Round down')],
            ['value' => Math::TYPE_EXCEL_CEIL, 'label' => __('Excel Round up')],
            ['value' => Math::TYPE_EXCEL_ROUND, 'label' => __('Excel Round')],
            ['value' => Math::TYPE_EXCEL_FLOOR, 'label' => __('Excel Round down')]
        ];
    }
}
