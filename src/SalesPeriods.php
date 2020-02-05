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

use Carbon\Carbon;
use DateTime;
use Exception;
use Handelsgids\SalesPeriods\Exception\NoPeriodsFoundForRegionException;
use Handelsgids\SalesPeriods\Model\SalesPeriod;
use ReflectionException;

class SalesPeriods
{
    /** @var string */
    private $region;

    /** @var int */
    private $year;

    /**
     * @param string $region
     * @param int $year
     */
    public function __construct($region = null, $year = null)
    {
        if ($region === null) {
            $region = Regions::DEFAULT_REGION;
        }

        if ($year === null) {
            $year = (int) date('Y');
        }

        $this->region = $region;
        $this->year = $year;
    }

    /**
     * @param DateTime $date
     * @param bool $returnPeriodMeta
     * @return bool|SalesPeriod
     * @throws NoPeriodsFoundForRegionException
     * @throws ReflectionException
     */
    public function inSalesPeriod(DateTime $date, $returnPeriodMeta = null)
    {
        $carbon = Carbon::instance($date);

        if ($returnPeriodMeta === null) {
            $returnPeriodMeta = false;
        }

        /** @var SalesPeriod[] $periods */
        $periods = $this->getSalesPeriods();

        foreach ($periods as $period) {
            if ($carbon->between($period->getStartDate(), $period->getEndDate())) {
                if ($returnPeriodMeta) {
                    return $period;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @return SalesPeriod[]
     * @throws NoPeriodsFoundForRegionException
     */
    public function getSalesPeriods()
    {
        $namespace = sprintf('Handelsgids\\SalesPeriods\\Region\\%s\\', $this->region);
        $path = sprintf(__DIR__ . '/Region/%s/', $this->region);

        $periods = [];

        try {
            $periodFiles = scandir($path, SCANDIR_SORT_ASCENDING);

            if ($periodFiles !== false) {
                $periodClasses = array_diff($periodFiles, array('.', '..'));
                $periodClasses = array_map(function ($value) {
                    return str_replace('.php', '', $value);
                }, $periodClasses);

                foreach ($periodClasses as $periodClass) {
                    $class = $namespace . $periodClass;
                    $periods[] = new $class($this->year);
                }
            }
        } catch (Exception $e) {
            throw new NoPeriodsFoundForRegionException(
                'No sales periods found for set region. Make sure the region you set actually exists. ' . PHP_EOL .
                'Available regions are: ' . implode(', ', Regions::all())
            );
        }

        return $periods;
    }
}
