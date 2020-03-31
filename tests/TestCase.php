<?php

namespace Scrapify\LaravelTaxonomy\Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Scrapify\LaravelTaxonomy\Tests\Support\TestModel;
use Scrapify\LaravelTaxonomy\TaxonomyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->testModel = TestModel::find(1);
        $this->secondTestModel = TestModel::find(2);
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

        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
        });

        TestModel::create(['name' => 'test']);
        TestModel::create(['name' => 'test2']);

        include_once __DIR__.'/../migrations/create_taxonomy_tables.php';
        (new \CreateTaxonomyTables())->up();
    }
}
