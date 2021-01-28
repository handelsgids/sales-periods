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

class WinterSales extends AbstractSalesPeriod
{
    public function init(): void
    {
        $this->setName('Winter sales');
        $this->setName('Wintersolden', 'nl');
        $this->setName('Soldes d\'hiver', 'fr');

        $startDate = new Carbon($this->getYear() . '-01-03');
        if ($startDate->dayOfWeekIso === 7) {
            $startDate = $startDate->subDay();
        }
        if ($this->getYear() === 2021) {
            $startDate = new Carbon('2021-01-04');
        }
        $this->setStartDate($startDate);

        $endDate = new Carbon($this->getYear() . '-01-31');
        if ($this->getYear() === 2021) {
            $endDate = new Carbon('2021-02-14');
        }
        $this->setEndDate($endDate);

        $this->setSalesRegulationsUrl(
            'https://economie.fgov.be/nl/themas/verkoop/vormen-van-verkoop/solden-koopjes'
        );
    }
}
