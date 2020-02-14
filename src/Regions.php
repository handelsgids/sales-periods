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

/**
 * Class to list all available salles period regions.
 */
final class Regions
{
    const DEFAULT_REGION = 'Belgium';

    /**
     * @return string[]
     */
    public static function all()
    {
        $regionPathPattern = __DIR__ . '/Region/*';
        $availableRegions = glob($regionPathPattern, GLOB_ONLYDIR);

        $output = [];
        if ($availableRegions !== false) {
            $output = array_map(function($regionPath) {
                return substr($regionPath, strrpos($regionPath, DIRECTORY_SEPARATOR) + 1);
            }, $availableRegions);
        }

        return $output;
    }
}
