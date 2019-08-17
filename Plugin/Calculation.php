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
 * @author      Daniel Kradolfer <kra@smilesolutions.ch>
 *
 * @package     SmileSolutions_FlexiblePriceRounding
 * @copyright   Copyright (c) 2019 Daniel Kradolfer, smile solutions gmbh <kra@smilesolutions.ch>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


namespace SmileSolutions\FlexiblePriceRounding\Plugin;

use SmileSolutions\FlexiblePriceRounding\Helper\Data as PriceHelper;
use SmileSolutions\FlexiblePriceRounding\Model\Math;

class Calculation
{
    /**
     * Round Price Helper
     *
     * @var PriceHelper
     */
    protected $_helper;

    /**
     * Math Processor
     *
     * @var Math
     */
    protected $_math;

    /**
     * Initialize Plugin
     *
     * @param Math $math
     * @param PriceHelper $helper
     */
    public function __construct(
        Math $math,
        PriceHelper $helper
    )
    {
        $this->_math = $math;
        $this->_helper = $helper;
    }

    /**
     * Round Tax
     *
     * @param $subject
     * @param $price
     * @return array
     */
    public function beforeRound($subject, $price)
    {
        if ($this->_helper->isEnabled() &&
            $this->_helper->isRoundingTax()) {
            $price = $this->_math->round($price);
        }
        return [$price];
    }
}