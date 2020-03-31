<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature\Traits;

use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
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
}
