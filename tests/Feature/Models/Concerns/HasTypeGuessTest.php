<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Models\Concerns;

use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

/**
 * Class HasTypeGuessTest
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Feature\Models\Concerns
 */
class HasTypeGuessTest extends TestCase
{
    /**
     * @returns void
     */
    public function test_it_returns_types_in_right_priority(): void
    {
        // $taxonomy = TestProductCategory::create([
        //     'name' => 'Test name...'
        // ]);
        //
        // $this->assertEquals('product_category', $taxonomy->type);
        //
        // $taxonomy->term()->delete();
        //
        // $this->assertEquals('product_category', $taxonomy->type);
    }
}
