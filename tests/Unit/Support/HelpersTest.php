<?php

namespace Scrapify\LaravelTaxonomy\Tests\Unit\Support;

use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Support\Helpers;

/**
 * Class HelpersTest
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Unit\Support
 */
class HelpersTest extends TestCase
{
    /**
     * @returns void
     */
    public function test_it_returns_first_not_null_value(): void
    {
        $value = 'Hello World';
        self::assertEquals($value, Helpers::firstNotNull([null, null, $value]));
        self::assertEquals($value, Helpers::firstNotNull(null, null, $value));

        $value = null;
        self::assertEquals($value, Helpers::firstNotNull([null, null, $value]));
    }
}
