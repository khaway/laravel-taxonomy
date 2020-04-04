<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

/**
 * Class TestSomeCategory
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Support
 */
class TestSomeCategory extends NestedTaxonomy
{
    /**
     * @var array
     */
    public $attributes = [
        'taxonomy' => 'some_category'
    ];
}
