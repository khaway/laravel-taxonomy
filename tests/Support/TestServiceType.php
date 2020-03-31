<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

/**
 * Class TestServiceType
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Support
 */
class TestServiceType extends NestedTaxonomy
{
    /**
     * @var array
     */
    public $attributes = [
        'taxonomy' => 'service_type'
    ];
}
