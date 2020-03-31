<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature;

use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

class HasTaxonomiesTest extends TestCase
{
    public function test_some()
    {
        $this->testModel->products()->create([
            'name' => 'sure'
        ]);

        TestProductCategory::first()->entities(TestModel::class)->get();
    }
}
