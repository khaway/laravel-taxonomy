<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Kalnoy\Nestedset\NodeTrait;
use Scrapify\LaravelTaxonomy\Models\Observers\NestedTaxonomyObserver;

/**
 * Class NestedTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class NestedTaxonomy extends Taxonomy
{
    use NodeTrait;

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(NestedTaxonomyObserver::class);
    }
}
