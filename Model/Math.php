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

namespace SmileSolutions\FlexiblePriceRounding\Model;

use SmileSolutions\FlexiblePriceRounding\Helper\Data as PriceHelper;

/**
 * Math Model
 */
class Math
{
    /**
     * Round Fractions Up
     */
    const TYPE_CEIL = 'ceil';

    /**
     * Round Fractions Down
     */
    const TYPE_FLOOR = 'floor';

    /**
     * Swedish Round Fractions Up
     */
    const TYPE_SWEDISH_CEIL = 'swedish_ceil';

    /**
     * Swedish Round Fractions
     */
    const TYPE_SWEDISH_ROUND = 'swedish_round';

    /**
     * Swedish Round Fractions Down
     */
    const TYPE_SWEDISH_FLOOR = 'swedish_floor';

    /**
     * Excel Round Fractions Up
     */
    const TYPE_EXCEL_CEIL = 'excel_ceil';

    /**
     * Excel Round Fractions
     */
    const TYPE_EXCEL_ROUND = 'excel_round';

    /**
     * Excel Round Fractions Down
     */
    const TYPE_EXCEL_FLOOR = 'excel_floor';

    /**
     * Round Price Helper
     *
     * @var PriceHelper
     */
    protected $_helper;

    /**
     * Initialize Model
     *
     * @param PriceHelper $helper
     */
    public function __construct(
        PriceHelper $helper
    )
    {
        $this->_helper = $helper;
    }

    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    public function round($price)
    {
        $helper = $this->_helper;
        $fraction = $helper->getSwedishFraction();
        $precision = $helper->getPrecision();
        $multiplier = pow(10, abs($precision));
        switch ($helper->getRoundType()) {
            case self::TYPE_CEIL:
                $price = round($price, $precision, PHP_ROUND_HALF_UP);
                break;
            case self::TYPE_FLOOR:
                $price = round($price, $precision, PHP_ROUND_HALF_DOWN);
                break;
            case self::TYPE_SWEDISH_CEIL:
                $price = ceil($price / $fraction) * $fraction;
                break;
            case self::TYPE_SWEDISH_ROUND:
                $price = round($price / $fraction) * $fraction;
                break;
            case self::TYPE_SWEDISH_FLOOR:
                $price = floor($price / $fraction) * $fraction;
                break;
            case self::TYPE_EXCEL_CEIL:
                $price = $precision < 0
                    ? ceil($price / $multiplier) * $multiplier
                    : ceil($price * $multiplier) / $multiplier;
                break;
            case self::TYPE_EXCEL_ROUND:
                $price = $precision < 0
                    ? round($price / $multiplier) * $multiplier
                    : round($price * $multiplier) / $multiplier;
                break;
            case self::TYPE_EXCEL_FLOOR:
                $price = $precision < 0
                    ? floor($price / $multiplier) * $multiplier
                    : floor($price * $multiplier) / $multiplier;
                break;
        }
        return $price;
    }
}
