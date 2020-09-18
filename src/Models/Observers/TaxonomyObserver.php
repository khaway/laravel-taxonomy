<?php

namespace Scrapify\LaravelTaxonomy\Models\Observers;

use Illuminate\Support\Arr;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Scrapify\LaravelTaxonomy\Models\{
    Term,
    Taxonomies\Taxonomy
};

/**
 * Class TaxonomyObserver
 *
 * @package Scrapify\LaravelTaxonomy\Models\Observers
 */
class TaxonomyObserver
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected Application $app;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected Repository $config;

    /**
     * TaxonomyObserver constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Application $app, Repository $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

	/**
     * Listen to the Taxonomy creating event.
     *
     * @param  Taxonomy  $taxonomy
     * @return void
     */
	public function creating(Taxonomy $taxonomy): void
    {
        $termAttributes = array_filter($taxonomy->getTermFillableAttributes());
        $currentLocale = $this->app->getLocale();
        $termName = Arr::get($termAttributes, 'name');

        if (is_array($termName)) {
            $termName = Arr::get($termAttributes, "name.{$currentLocale}");
        }

	    // If name attribute is set, try to
        // create or find and associate a term with taxonomy.
	    if ($termName) {
            $term = Term::query()
                ->whereName($termName, $currentLocale)
                ->firstOr(static function () use ($termAttributes) {
                    return Term::create($termAttributes);
                });

            $taxonomy->term()->associate($term);
        }

        // Be sure that unnecessary attributes
        // will not be passed to query.
	    foreach (array_keys($termAttributes) as $key) {
	        unset($taxonomy->{$key});
        }
	}
}
