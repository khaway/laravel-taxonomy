<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Models;

use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestServiceType;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

/**
 * Class TermTest
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Feature\Models
 */
class TermTest extends TestCase
{
    public function test_it_retrieves_related_taxonomies()
    {
        $termName = 'New term';

        TestProductCategory::create([
            'name' => 'Some name...',
            'children' => [
                ['name' => $termName]
            ]
        ]);

        $term = TestServiceType::create([
            'name' => $termName
        ])->term;

        $this->assertEquals(2, $term->taxonomies()->count());
        $this->assertEquals(1, $term->taxonomies(TestServiceType::class)->count());
    }
}
