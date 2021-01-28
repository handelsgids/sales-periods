<?php

namespace Handelsgids\SalesPeriods\Test;

use Carbon\Carbon;
use Handelsgids\SalesPeriods\AbstractSalesPeriod;
use Handelsgids\SalesPeriods\Exception\NoPeriodsFoundForRegionException;
use Handelsgids\SalesPeriods\Region\Belgium\SummerSales;
use Handelsgids\SalesPeriods\Region\Belgium\WinterSales;
use Handelsgids\SalesPeriods\Regions;
use Handelsgids\SalesPeriods\SalesPeriods;
use PHPUnit\Framework\TestCase;

class SalesPeriodsTest extends TestCase
{
    /** @var SalesPeriods */
    private $belgianSalesPeriods;

    protected function setUp(): void
    {
        $this->belgianSalesPeriods = new SalesPeriods(
            Regions::DEFAULT_REGION,
            2018
        );
    }

    public function testNumberOfBelgianSalesPeriods(): void
    {
        /** @var AbstractSalesPeriod[] $periods */
        $periods = $this->belgianSalesPeriods->getSalesPeriods();

        $this->assertCount(2, $periods);
    }

    public function testSalesPeriodStartsOnJanuaryThirth(): void
    {
        $belgianWinterSales = new WinterSales(2018);

        $this->assertEquals(new Carbon('2018-01-03'), $belgianWinterSales->getStartDate());
    }

    public function testSalesPeriodStartsOnJanuarySecondIfJanuaryThirthFallsOnASunday(): void
    {
        $belgianWinterSales = new WinterSales(2016);

        $this->assertEquals(new Carbon('2016-01-02'), $belgianWinterSales->getStartDate());
    }

    public function testSalesPeriodStartsOnJulyFirst(): void
    {
        $belgianSummerSales = new SummerSales(2017);

        $this->assertEquals(new Carbon('2017-07-01'), $belgianSummerSales->getStartDate());
    }

    public function testSalesPeriodStartsOnJuneThirtiethIfFirstOfJulyFallsOnASunday(): void
    {
        $belgianSummerSales = new SummerSales(2018);

        $this->assertEquals(new Carbon('2018-06-30'), $belgianSummerSales->getStartDate());
    }

    public function testNonExistingRegion(): void
    {
        $this->expectException(NoPeriodsFoundForRegionException::class);

        $dutchSalesPeriods = new SalesPeriods('Netherlands');
        $dutchSalesPeriods->getSalesPeriods();
    }

    public function testInSalesPeriod(): void
    {
        $inSalesPeriod = $this->belgianSalesPeriods->inSalesPeriod(new \DateTime('2018-06-30'));

        $this->assertTrue($inSalesPeriod);
    }

    public function testNotInSalesPeriod(): void
    {
        $inSalesPeriod = $this->belgianSalesPeriods->inSalesPeriod(new \DateTime('2018-08-01'));

        $this->assertFalse($inSalesPeriod);
    }

    public function testSalesPeriodIsInBelgium(): void
    {
        $belgianSummerSales = new SummerSales();

        $this->assertEquals('Belgium', $belgianSummerSales->getRegion());
    }

    public function testCovidExceptionsBelgium(): void
    {
        $belgianWinterSales = new WinterSales(2021);

        $this->assertEquals(new Carbon('2021-01-04'), $belgianWinterSales->getStartDate());
        $this->assertEquals(new Carbon('2021-02-14'), $belgianWinterSales->getEndDate());
    }
}
