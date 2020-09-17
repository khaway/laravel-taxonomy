<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

/**
 * Trait HasEntities
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasEntities
{
    /**
     * @param $related
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entities($related)
    {
        return $this->morphedByMany(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            'taxonomy_id'
        )->withPivotValue('taxonomy_type', static::$singleTableType);
    }

    /**
     * @param $related
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function entity($related)
    {
        return $this->morphOne(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships')
        )->withPivotValue('taxonomy_type', static::$singleTableType);
    }
}
