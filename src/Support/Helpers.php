<?php

namespace Scrapify\LaravelTaxonomy\Support;

use Illuminate\Support\Arr;

/**
 * Class Helpers
 *
 * @package Scrapify\LaravelTaxonomy\Support
 */
class Helpers
{
    /**
     * @return mixed
     */
    public static function firstNotNull()
    {
        $values = func_get_args();
        $firstValue = Arr::first($values);

        if (is_array($firstValue)) {
            $values = $firstValue;
        }

        return Arr::first($values, static function ($value) {
            return $value !== null;
        });
    }
}
