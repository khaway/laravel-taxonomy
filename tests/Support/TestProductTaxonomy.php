<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

class TestProductTaxonomy extends NestedTaxonomy
{
    public $attributes = [
        'taxonomy' => 'product'
    ];
}
