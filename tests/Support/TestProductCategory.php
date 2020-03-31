<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

/**
 * Class TestProductTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Support
 */
class TestProductCategory extends NestedTaxonomy
{
    /**
     * @var array
     */
    public $attributes = [
        'taxonomy' => 'product_category'
    ];
}
