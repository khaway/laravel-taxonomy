<?php

namespace Scrapify\LaravelTaxonomy;

use Ankurk91\Eloquent\MorphToOne;
use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Models\TermRelationship;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;
use Ankurk91\Eloquent\Relations\MorphToOne as MorphToOneRelation;

/**
 * Trait InteractsWithTaxonomies
 *
 * @package Scrapify\LaravelTaxonomy
 */
trait InteractsWithTaxonomies
{
    use MorphToOne;

    /**
     * @param $related
     * @param string|null $table
     * @return \Ankurk91\Eloquent\Relations\MorphToOne
     */
    public function morphToOneTaxonomy($related, ?string $table = null): MorphToOneRelation
    {
        return $this->morphToOne(
            $related,
            config('taxonomy.morph_name'),
            $table ?: config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'taxonomy_id'
        )
            ->withPivot('meta')
            ->withPivotValue('taxonomy_type', $related::$singleTableType)
            ->withTimestamps()
            ->using(TermRelationship::class);
    }

    /**
     * @param $related
     * @param string|null $table
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphToManyTaxonomies($related, ?string $table = null): MorphToMany
    {
        return $this->morphToMany(
            $related,
            config('taxonomy.morph_name'),
            $table ?: config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'taxonomy_id'
        )
            ->withPivot('meta')
            ->withPivotValue('taxonomy_type', $related::$singleTableType)
            ->withTimestamps()
            ->using(TermRelationship::class);
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
        return $this->loadMissing('taxonomies')
                    ->taxonomies
                    ->map(static function (Taxonomy $taxonomy): Term {
                        return $taxonomy->term;
                    });
    }
}
