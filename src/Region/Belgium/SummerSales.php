<?php
/**
 * This file is part of handelsgids/sales-periods.
 *
 * (c) Handelsgids NV
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Handelsgids\SalesPeriods\Region\Belgium;

use Carbon\Carbon;
use Handelsgids\SalesPeriods\AbstractSalesPeriod;

class SummerSales extends AbstractSalesPeriod
{
    public function init()
    {
        $this->setName('Summer sales');
        $this->setName('Zomersolden', 'nl');
        $this->setName('Soldes d\'été', 'fr');

        $startDate = new Carbon($this->getYear() . '-07-01');
        if ($startDate->dayOfWeekIso === 7) {
            $startDate = $startDate->subDay();
        }
        $this->setStartDate($startDate);

        $endDate = new Carbon($this->getYear() . '-07-31');
        $this->setEndDate($endDate);

        $this->setSalesRegulationsUrl(
            'https://economie.fgov.be/nl/themas/verkoop/vormen-van-verkoop/solden-koopjes'
        );
    }
}
