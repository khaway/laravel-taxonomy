<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Traits;

use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
use Scrapify\LaravelTaxonomy\Tests\Support\TestServiceType;
use Scrapify\LaravelTaxonomy\Tests\Support\TestSomeCategory;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

/**
 * Class HasTaxonomiesTest
 *
 * @package Scrapify\LaravelTaxonomy\Tests\Feature\Traits
 */
class HasTaxonomiesTest extends TestCase
{
    public function test_it_morph_to_one_taxonomy()
    {
        $productCategoryName = 'Test product category';
        $productCategory = TestProductCategory::create([
            'name' => $productCategoryName
        ]);

        $productCategory->entities(TestModel::class)->create([
            'name' => 'New model'
        ]);

        $this->assertEquals($productCategory->id, TestModel::whereName('New model')
            ->first()
            ->morphToOneTaxonomy(TestProductCategory::class)
            ->first()->id);
    }

    public function test_it_morph_to_many_taxonomies()
    {
        $secondProductCategoryName = 'Second product category';

        $productCategory = TestProductCategory::create([
            'name' => 'New product category',
            'children' => [
                ['name' => $secondProductCategoryName]
            ]
        ]);

        $secondProductCategory = TestProductCategory::whereName($secondProductCategoryName)->first();

        TestModel::create(['name' => 'Another model'])->products()->sync(
            TestProductCategory::ancestorsAndSelf($secondProductCategory->id)->pluck('id')->toArray()
        );

        $this->assertEquals(2, TestModel::whereName('Another model')
            ->first()
            ->morphToManyTaxonomies(TestProductCategory::class)
            ->count());
    }

    /**
     *
     */
    public function test_it_syncs_morph_to_many_taxonomies_by_taxonomy_type()
    {
        $testModel = TestModel::create(['name' => 'New model']);

        TestProductCategory::create([
            'name' => 'First taxonomy2'
        ]);

        TestProductCategory::create([
            'name' => 'First taxonomy2'
        ]);

        TestSomeCategory::create([
            'name' => 'First taxonomy3'
        ]);

        $testModel->products()->sync([1, 2]);
        $this->assertEquals(2, $testModel->products()->count());
        $testModel->products()->sync(1);
        $this->assertEquals(1, $testModel->products()->count());

        $testModel->some()->sync(3);
        $testModel->products()->sync([1, 2]);

        $this->assertEquals(1, $testModel->some()->count());
        $this->assertEquals(2, $testModel->products()->count());
    }

    /**
     *
     */
    public function test_it_syncs_morph_to_one_taxonomies_by_taxonomy_type()
    {
        $testModel = TestModel::create(['name' => 'New model']);

        TestProductCategory::create(['name' => 'First taxonomy2']);
        TestProductCategory::create(['name' => 'First taxonomy2']);
        TestServiceType::create(['name' => 'Another tax']);

        $testModel->products()->sync([1, 2]);
        $testModel->serviceType()->sync([3, 1]);
        $this->assertEquals(1, $testModel->serviceType()->count());
        $this->assertEquals(2, $testModel->products()->count());
    }
}
