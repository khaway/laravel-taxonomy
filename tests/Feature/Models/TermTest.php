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
                ['name' => 'New term']
            ]
        ]);

        TestServiceType::create([
            'name' => $termName
        ]);

        $this->assertEquals(2, Term::whereName($termName)->first()->taxonomies()->count());
        $this->assertEquals(1, Term::whereName($termName)->first()->taxonomies(TestServiceType::class)->count());
    }
}
