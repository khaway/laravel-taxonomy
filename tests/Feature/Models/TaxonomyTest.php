<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Models;

use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
use Scrapify\LaravelTaxonomy\Tests\Support\TestServiceType;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

/**
 * Class TaxonomyTest
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Feature\Models
 */
class TaxonomyTest extends TestCase
{
    public function test_it_creates_and_associates_a_term_on_creating_events()
    {
        $name = 'Test name...';

        TestProductCategory::create([
            'name' => 'Test name...'
        ]);

        $this->assertNotNull(Term::whereName($name)->first());
    }

    public function test_it_can_retrieve_all_related_entities()
    {
        $newTaxonomy = TestProductCategory::create([
            'name' => 'Test name...'
        ]);

        $newTaxonomy->entities(TestModel::class)->create([
            'name' => 'Test entity'
        ]);

        TestModel::create(['name' => 'Random name...']);

        $this->assertEquals(1, $newTaxonomy->entities(TestModel::class)->count());
    }

    public function test_it_can_retrieve_single_related_entity()
    {
        $newTaxonomy = TestProductCategory::create([
            'name' => 'Test name...'
        ]);

        $entity = $newTaxonomy->entities(TestModel::class)->create([
            'name' => 'Test entity'
        ]);

        $this->assertEquals($entity->id, $newTaxonomy->entities(TestModel::class)->first()->id);
    }

    public function test_it_scopes_by_taxonomy_name_if_it_is_set()
    {
        $productCategoryName = 'Test product category...';

        TestProductCategory::create([
            'name' => $productCategoryName
        ]);

        $serviceTypeName = 'Test service type';

        TestServiceType::create([
            'name' => $serviceTypeName
        ]);

        $this->assertEquals($productCategoryName, TestProductCategory::first()->name);
        $this->assertEquals($serviceTypeName, TestServiceType::first()->name);
    }
}
