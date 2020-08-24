<?php

namespace Scrapify\LaravelTaxonomy\Providers;

use Illuminate\Support\ServiceProvider;
use Scrapify\LaravelTaxonomy\Database\Seeds\TaxonomySeeder;
use Scrapify\LaravelTaxonomy\Console\TaxonomySeederMakeCommand;

/**
 * Class TaxonomyServiceProvider
 *
 * @package Scrapify\LaravelTaxonomy\Providers
 */
class TaxonomyServiceProvider extends ServiceProvider
{
	/**
     * Boot the application events.
     *
     * @return void
     */
	public function boot(): void
	{
        $this->registerPublishing();
	}

    /**
     *
     */
	public function register(): void
    {
        class_exists(TaxonomySeeder::class);
        $this->registerConfig();
        $this->registerCommands();
    }

    /**
     *
     */
	public function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrationsPublishing();
            $this->registerConfigPublishing();
        }
    }

    /**
     *
     */
	public function registerMigrationsPublishing(): void
    {
        if (! class_exists('CreateTaxonomyTables')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_taxonomy_tables.php'
                    => database_path('migrations/'.date('Y_m_d_His').'_create_taxonomy_tables.php'),
            ], 'taxonomy-migrations');
        }
    }

    /**
     *
     */
    public function registerConfigPublishing(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/taxonomy.php' => config_path('taxonomy.php'),
        ], 'taxonomy-config');
    }

    /**
     * Setup the configuration.
     *
     * @return void
     */
	public function registerConfig(): void
	{
		$this->mergeConfigFrom(
            __DIR__ . '/../../config/taxonomy.php', 'taxonomy'
		);
	}

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TaxonomySeederMakeCommand::class
            ]);
        }
    }
}
