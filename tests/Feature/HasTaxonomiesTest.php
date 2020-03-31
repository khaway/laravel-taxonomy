<?php

namespace Scrapify\LaravelTaxonomy\Tests\Feature;

use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Tests\TestCase;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductTaxonomy;

class HasTaxonomiesTest extends TestCase
{
    public function test_some()
    {
        $this->testModel->products()->create([
            'name' => 'sure'
        ]);

        TestProductTaxonomy::first()->entities(TestModel::class)->get();
    }
}
