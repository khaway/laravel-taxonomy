<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Kalnoy\Nestedset\NodeTrait;
use Scrapify\LaravelTaxonomy\Models\Observers\NestedTaxonomyObserver;
use Scrapify\LaravelTaxonomy\Query\NestedQueryBuilder as QueryBuilder;

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

    /**
     * Create new eloquent query builder, using nested set.
     *
     * @return QueryBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }
}
