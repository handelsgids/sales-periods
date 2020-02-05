<?php
/**
 * This file is part of handelsgids/sales-periods.
 *
 * (c) Handelsgids NV
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Handelsgids\SalesPeriods\Model;

use Carbon\Carbon;

class SalesPeriod
{
    /** @var string[] */
    private $name;

    /** @var Carbon */
    private $startDate;

    /** @var Carbon */
    private $endDate;

    /** @var string */
    private $salesRegulationsUrl;

    /** @var string */
    private $region;

    /**
     * @param string $locale
     * @return string
     */
    public function getName($locale = null)
    {
        if ($locale === null) {
            $locale = 'en';
        }

        return $this->name[$locale];
    }

    /**
     * @param string $name
     * @param string $locale
     */
    public function setName($name, $locale = null): void
    {
        if ($locale === null) {
            $locale = 'en';
        }

        $this->name[$locale] = $name;
    }

    /**
     * @return Carbon
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param Carbon $startDate
     */
    protected function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return Carbon
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param Carbon $endDate
     */
    protected function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getSalesRegulationsUrl()
    {
        return $this->salesRegulationsUrl;
    }

    /**
     * @param string $salesRegulationsUrl
     */
    public function setSalesRegulationsUrl($salesRegulationsUrl): void
    {
        $this->salesRegulationsUrl = $salesRegulationsUrl;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region): void
    {
        $this->region = $region;
    }
}
