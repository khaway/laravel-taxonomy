<?php

namespace Scrapify\LaravelTaxonomy\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Scrapify\LaravelTaxonomy\Providers\TaxonomyServiceProvider;
use Scrapify\LaravelTaxonomy\Tests\Support\TestServiceType;
use Scrapify\LaravelTaxonomy\Tests\Support\TestSomeCategory;
use Scrapify\LaravelTaxonomy\Tests\Support\TestProductCategory;
use Spatie\SchemalessAttributes\SchemalessAttributesServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->app['config']->set('taxonomy.sti.type_field', 'type');
        $this->app['config']->set('taxonomy.types', [
            TestProductCategory::class,
            TestSomeCategory::class,
            TestServiceType::class
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SchemalessAttributesServiceProvider::class,
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

        include_once __DIR__ . '/../database/migrations/create_taxonomy_tables.php';

        (new \CreateTaxonomyTables())->up();
    }
}
