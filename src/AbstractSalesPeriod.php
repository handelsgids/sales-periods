<?php
/**
 * This file is part of handelsgids/sales-periods.
 *
 * (c) Handelsgids NV
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Handelsgids\SalesPeriods;

use Handelsgids\SalesPeriods\Model\SalesPeriod;

abstract class AbstractSalesPeriod extends SalesPeriod implements SalesPeriodInterface
{
    /** @var int */
    private $year;

    /**
     * @param null|int $year
     * @throws \ReflectionException
     */
    public function __construct($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $this->setYear($year);

        $this->init();

        $reflection = new \ReflectionClass($this);
        $namespace = $reflection->getNamespaceName();
        $region = substr($namespace, strrpos($namespace, '\\') + 1);

        $this->setRegion($region);
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }
}
