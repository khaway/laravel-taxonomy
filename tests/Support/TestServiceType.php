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

    /**
     *
     */
    public function productCategory()
    {
        return $this->children(TestProductCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function someCategory()
    {
        return $this->parent(TestSomeCategory::class);
    }
}
