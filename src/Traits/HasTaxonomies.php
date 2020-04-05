<?php

namespace Scrapify\LaravelTaxonomy\Traits;

use Ankurk91\Eloquent\MorphToOne;

/**
 * Trait HasTaxonomies
 *
 * @package Scrapify\LaravelTaxonomy\Traits
 */
trait HasTaxonomies
{
    use MorphToOne;

    /**
     * @param $related
     * @return \Ankurk91\Eloquent\Relations\MorphToOne
     */
    public function morphToOneTaxonomy($related)
    {
        return $this->morphToOne(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'taxonomy_id'
        )
            ->withPivotValue('taxonomy_type', $related::$singleTableType);
    }

    /**
     * @param $related
     * @return mixed
     */
    public function morphToManyTaxonomies($related)
    {
        return $this->morphToMany(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'taxonomy_id'
        )
            ->withPivotValue('taxonomy_type', $related::$singleTableType);
    }

    /**
     * Get the terms collection.
     *
     * @param null $slug
     * @param null $taxonomy
     * @return mixed
     */
    public function terms($slug = null, $taxonomy = null)
    {
        return $this->loadMissing('taxonomies')->taxonomies->map(function ($taxonomy) {
            return $taxonomy->term;
        });
    }
}
