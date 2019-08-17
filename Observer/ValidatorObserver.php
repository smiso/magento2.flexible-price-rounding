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

namespace SmileSolutions\FlexiblePriceRounding\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use SmileSolutions\FlexiblePriceRounding\Helper\Data as PriceHelper;
use SmileSolutions\FlexiblePriceRounding\Model\Math;

/**
 * SalesRule Validator Observer
 */
class ValidatorObserver implements ObserverInterface
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
     * Initialize Observer
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
     * Rounding Calculated Discount
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->_helper->isEnabled() ||
            !$this->_helper->isRoundingDiscount()
        ) {
            return;
        }

        $discount = $observer->getEvent()->getResult();
        $discount->setAmount(
            $this->_math->round($discount->getAmount())
        );
    }
}
