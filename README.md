[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/handelsgids/sales-periods/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/handelsgids/sales-periods/?branch=master)

# Sales periods

## Introduction

PHP library for retrieving regional sales periods.

## Installation

    composer require handelsgids/sales-periods

## Example

### Get national sales periods for Belgium

```php
<?php

require 'vendor/autoload.php';

use Handelsgids\SalesPeriods\SalesPeriods;

$belgianSalesPeriods = new SalesPeriods('Belgium', 2018);
$salesPeriods = $belgianSalesPeriods->getSalesPeriods();

foreach ($salesPeriods as $salesPeriod) {
    $output = sprintf(
        '%s running from %s untill %s.',
        $salesPeriod->getName(),
        $salesPeriod->getStartDate(),
        $salesPeriod->getEndDate()
    );
    echo $output . PHP_EOL;
}
```

The above example will output:
```
Summer sales running from 2018-06-30 untill 2018-07-31.
Winter sales running from 2018-01-03 untill 2018-01-31.
```

### Check if a date is in a sales period

```php
$date = new \DateTime('2018-06-19');
$result = $belgianSalesPeriods->inSalesPeriod($date);
```

## Adding more regions

Feel free to add more sales period regulations for your region via a pull request.

### How to create a set of new sales periods for a region or country

Checkout the files for the default region in `/src/Region/Belgium/` or follow these steps:

1. Create a folder for the region you want to add sales periods for in `/src/Region/`

2. For each sales period in the region create a class extending `AbstractSalesPeriod`

3. Create the `init` function and set a name, start date, end date and source to the region regulations

## Running tests

```composer test```

## License

Handelsgids sales periods is open-sourced software licensed under the [MIT license](LICENSE).