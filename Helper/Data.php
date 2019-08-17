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

namespace SmileSolutions\FlexiblePriceRounding\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Round Price Helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled Config Path
     */
    const XML_ROUND_ENABLED = 'smilesolutions_fpr/flexiblepricerounding/enabled';

    /**
     * Subtract Config Path
     */
    const XML_ROUND_SUBTRACT = 'smilesolutions_fpr/flexiblepricerounding/subtract';

    /**
     * Rounding Base Price Config Path
     */
    const XML_ROUND_BASE_PRICE = 'smilesolutions_fpr/flexiblepricerounding/rounding_base_price';

    /**
     * Rounding Type Config Path
     */
    const XML_ROUND_TYPE = 'smilesolutions_fpr/flexiblepricerounding/rounding_type';

    /**
     * Rounding Subtract Amount Config Path
     */
    const XML_ROUND_AMOUNT = 'smilesolutions_fpr/flexiblepricerounding/rounding_amount';

    /**
     * Rounding Precision Config Path
     */
    const XML_ROUND_PRECISION = 'smilesolutions_fpr/flexiblepricerounding/rounding_precision';

    /**
     * Show Decimal Zeros Config Path
     */
    const XML_DECIMAL_ZERO = 'smilesolutions_fpr/flexiblepricerounding/show_decimal_zero';

    /**
     * Replace Zero Price Config Path
     */
    const XML_ZERO_PRICE = 'smilesolutions_fpr/flexiblepricerounding/replace_zero_price';

    /**
     * Text of Replace Config Path
     */
    const XML_ZERO_PRICE_TEXT = 'smilesolutions_fpr/flexiblepricerounding/zero_price_text';

    /**
     * Swedish Rounding Fraction Config Path
     */
    const XML_SWEDISH_ROUND_FRACTION = 'smilesolutions_fpr/flexiblepricerounding/swedish_fraction';

    /**
     * Rounding Discount Config Path
     */
    const XML_ROUND_DISCOUNT = 'smilesolutions_fpr/flexiblepricerounding/rounding_discount';

    /**
     * Rounding Discount Config Path
     */
    const XML_ROUND_TAX = 'smilesolutions_fpr/flexiblepricerounding/rounding_tax';

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getConfig(self::XML_ROUND_ENABLED) == 1;
    }

    /**
     * Check Subtract 0.01 Functionality Should be Enabled
     *
     * @return bool
     */
    public function isSubtract()
    {
        return $this->_getConfig(self::XML_ROUND_SUBTRACT) == 1;
    }

    /**
     * Check Decimal Zero Functionality Should be Enabled
     *
     * @return bool
     */
    public function isShowDecimalZero()
    {
        return $this->_getConfig(self::XML_DECIMAL_ZERO) == 1;
    }

    /**
     * Check Replace Zero Price Functionality Should be Enabled
     *
     * @return bool
     */
    public function isReplaceZeroPrice()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE) == 1;
    }

    /**
     * Check Rounding Base Price
     *
     * @return bool
     */
    public function isRoundingBasePrice()
    {
        return $this->_getConfig(self::XML_ROUND_BASE_PRICE) == 1;
    }

    /**
     * Check Rounding Discount
     *
     * @return bool
     */
    public function isRoundingDiscount()
    {
        return $this->_getConfig(self::XML_ROUND_DISCOUNT) == 1;
    }

    /**
     * Check Rounding Tax
     *
     * @return bool
     */
    public function isRoundingTax()
    {
        return $this->_getConfig(self::XML_ROUND_TAX) == 1;
    }

    /**
     * Retrieve Rounding Type
     *
     * @return string
     */
    public function getRoundType()
    {
        return $this->_getConfig(self::XML_ROUND_TYPE);
    }

    /**
     * Retrieve Subtract Amount
     *
     * @return string
     */
    public function getAmount()
    {
        $amount = $this->_getConfig(self::XML_ROUND_AMOUNT);
        return is_numeric($amount)
            ? $amount
            : 0;
    }

    /**
     * Retrieve Precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return (int)$this->_getConfig(self::XML_ROUND_PRECISION);
    }

    /**
     * Retrieve Text of Replace
     *
     * @return string
     */
    public function getZeroPriceText()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE_TEXT);
    }

    /**
     * Retrieve Swedish Round Fraction
     *
     * @return float
     */
    public function getSwedishFraction()
    {
        $fraction = $this->_getConfig(self::XML_SWEDISH_ROUND_FRACTION);
        return ($fraction > 0)
            ? $fraction
            : 0.05;
    }

    /**
     * Retrieve Store Configuration Data
     *
     * @param string $path
     * @return string|null|bool
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig
            ->getValue(
                $path,
                ScopeInterface::SCOPE_STORE
            );
    }
}
