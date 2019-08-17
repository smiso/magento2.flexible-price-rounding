# Magento 2: Flexible Price Rounding
Rounding prices in Magento 2

The extension can be used for rounding prices:
* 5-cent rounding for ex. for Switzerland or Sweden
* Rounding of prices for nicer presentation
* Rounding of discounts

## Requirements
Magento 2

## Installation

### Using Composer
    composer require smiso/flexible-price-rounding
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy
	
### Manual Installation
Copy the files to `app/code/SmileSolutions/FlexiblePriceRounding`

	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy

## Configuration
Go to `Stores -> Configuration -> smile solutions -> Flexible Price Rounding`

## Known Issues
Prices stored excl. Tax and displayed incl. Tax are not rounded.

## Credits
This Extension is a fork of faonni/module-price (https://github.com/karliuka/m2.Price). Thanks to Karliuka Vitalii who shared his code under OSL 3.0.