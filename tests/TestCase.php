<?php

namespace Scrapify\LaravelTaxonomy\Tests;

use Scrapify\LaravelTaxonomy\Taxonomy;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Scrapify\LaravelTaxonomy\TaxonomyServiceProvider;
use Scrapify\LaravelTaxonomy\Tests\Support\TestServiceType;
use Scrapify\LaravelTaxonomy\Tests\Support\TestSomeCategory;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        Taxonomy::$sub = [
            TestProductCategory::class,
            TestSomeCategory::class,
            TestServiceType::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TaxonomyServiceProvider::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['db']->connection()->getSchemaBuilder()->create('test_models', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('taxonomy_id')->nullable();
            $table->softDeletes();
        });

        include_once __DIR__.'/../migrations/create_taxonomy_tables.php';

        (new \CreateTaxonomyTables())->up();
    }
}
