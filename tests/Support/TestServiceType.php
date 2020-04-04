<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

/**
 * Class TestServiceType
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Support
 */
class TestServiceType extends TestNestedTaxonomy
{
    public static $singleTableType = 'service_type';

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
