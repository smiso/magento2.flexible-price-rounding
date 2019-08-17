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

namespace SmileSolutions\FlexiblePriceRounding\Plugin;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Locale\FormatInterface;
use Magento\Directory\Model\Currency as CurrencyInterface;
use SmileSolutions\FlexiblePriceRounding\Helper\Data as PriceHelper;
use SmileSolutions\FlexiblePriceRounding\Model\Math;

/**
 * Currency Plugin
 */
class Currency
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
     * Locale Format
     *
     * @var FormatInterface
     */
    protected $_localeFormat;

    /**
     * Initialize Plugin
     *
     * @param Math $math
     * @param FormatInterface $localeFormat
     * @param PriceHelper $helper
     */
    public function __construct(
        Math $math,
        FormatInterface $localeFormat,
        PriceHelper $helper
    )
    {
        $this->_math = $math;
        $this->_localeFormat = $localeFormat;
        $this->_helper = $helper;
    }

    /**
     * Convert and Round Price to Currency Format
     *
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param float $price
     * @param mixed $toCurrency
     * @return float
     * @throws InputException
     */
    public function aroundConvert(
        CurrencyInterface $subject, $proceed, $price, $toCurrency = null
    )
    {
        $price = $proceed($price, $toCurrency);

        if ($this->isRoundEnabled($subject, $toCurrency)) {
            $price = $this->round($price);
            $price = $this->subtract($price);
        }

        return $price;
    }

    /**
     * Retrieve the Formatted Price
     *
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param float $price
     * @param array $options
     * @return string
     */
    public function aroundFormatTxt(
        CurrencyInterface $subject, $proceed, $price, $options = []
    )
    {
        return ($this->_helper->isEnabled())
            ? $this->formatTxt($proceed, $price, $options)
            : $proceed($price, $options);
    }

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @param CurrencyInterface $currency
     * @param mixed $toCurrency
     * @return bool
     * @throws InputException
     */
    public function isRoundEnabled(CurrencyInterface $currency, $toCurrency)
    {
        if (!$this->_helper->isEnabled()) {
            return false;
        }
        if (!$this->_helper->isRoundingBasePrice()) {
            if (is_null($toCurrency) ||
                $this->getCurrencyCode($toCurrency) == $currency->getCode()
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Retrieve the Formatted Price
     *
     * @param callable $proceed
     * @param float $price
     * @param array $options
     * @return string
     */
    protected function formatTxt($proceed, $price, $options = [])
    {
        $price = $this->getNumber($price);

        if (!$this->_helper->isShowDecimalZero() &&
            intval($price) == $price) {
            $options['precision'] = 0;
        }

        if (!$this->_helper->isReplaceZeroPrice() || 0 != $price) {
            return $proceed($price, $options);
        }
        return sprintf(
            '<span class="price-free">%s</span>',
            $this->_helper->getZeroPriceText()
        );
    }

    /**
     * Retrieve the First Found Number from an String
     *
     * @param string|float|int $price
     * @return float|null
     */
    protected function getNumber($price)
    {
        if (!is_numeric($price)) {
            return $this->_localeFormat->getNumber($price);
        }
        return $price;
    }

    /**
     * Formats a Number as a Currency String
     *
     * @param float $price
     * @return string
     */
    protected function format($price)
    {
        return sprintf('%0.4F', $price);
    }

    /**
     * Retrieve the Price With a Subtracted Amount
     *
     * @param float $price
     * @return float
     */
    protected function subtract($price)
    {
        if ($this->_helper->isSubtract()) {
            $price = $price - $this->_helper->getAmount();
        }
        return (0 < $price)
            ? $price
            : $this->format(0);
    }

    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    protected function round($price)
    {
        return $this->format(
            $this->_math->round($price)
        );
    }

    /**
     * Retrieve Currency Code
     *
     * @param mixed $toCurrency
     * @return string
     * @throws InputException
     */
    protected function getCurrencyCode($toCurrency)
    {
        if (is_string($toCurrency)) {
            $code = $toCurrency;
        } elseif ($toCurrency instanceof CurrencyInterface) {
            $code = $toCurrency->getCurrencyCode();
        } else {
            throw new InputException(
                __('Please correct the target currency.')
            );
        }
        return $code;
    }
}
