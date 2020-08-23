<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Models;

use Scrapify\LaravelTaxonomy\{Models\Taxonomies\Taxonomy,
    Models\Term,
    Tests\TestCase,
    Tests\Support\TestModel,
    Tests\Support\TestServiceType,
    Tests\Support\TestSomeCategory,
    Tests\Support\TestProductCategory};
use Illuminate\Support\Str;

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
            'name' => 'Test entity',
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

    public function test_it_can_have_children_taxonomies_with_different_taxonomy_type()
    {
        $serviceType = TestServiceType::create([
            'name' => 'inherited'
        ]);

        $serviceType->children(TestProductCategory::class)->create(['name' => 123]);
        $serviceType->children(TestProductCategory::class)->create(['name' => 1234]);

        $this->assertEquals(2, $serviceType->children(TestProductCategory::class)->count());
        $this->assertEquals(0, $serviceType->children(TestSomeCategory::class)->count());
    }

    public function test_it_can_have_parent_taxonomies_with_different_taxonomy_type()
    {
        $parentServiceType = TestProductCategory::create([
            'name' => 'parent'
        ]);

        TestSomeCategory::create([
           'name' => 'Random'
        ]);

        $serviceType = TestProductCategory::create([
            'name' => 'Random'
        ], $parentServiceType);

        $this->assertEquals(1, $serviceType->parent(TestProductCategory::class)->count());
        $this->assertEquals(0, $serviceType->parent(TestSomeCategory::class)->count());
    }
}
