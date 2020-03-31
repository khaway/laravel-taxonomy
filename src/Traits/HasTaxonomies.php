<?php

namespace Scrapify\LaravelTaxonomy\Traits;

use Ankurk91\Eloquent\MorphToOne;
use Scrapify\LaravelTaxonomy\Models\TermRelationship;

trait HasTaxonomies
{
    use HasBaseTaxonomyRelations, MorphToOne;

    /**
     * Boot the metable trait on the model.
     *
     * @return void
     */
    public static function bootHasTaxonomies(): void
    {
        //
    }

    /**
     * @param $modelClass
     * @return \Ankurk91\Eloquent\Relations\MorphToOne
     */
    protected function taxonomyMorphToOne($modelClass)
    {
        return $this->morphToOne(
            $modelClass,
            'object',
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'term_taxonomy_id'
        );
    }

    /**
     * @param $modelClass
     * @return
     */
    protected function taxonomyMorphToMany($modelClass)
    {
        return $this->morphToMany(
            $modelClass,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'taxonomy_id'
        );
    }


    /**
     * Object taxonomy relation helper.
     *
     * @param string $modelClass
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function taxonomyRelation($modelClass)
    {
        return $this->morphToMany(
            $modelClass,
            'object',
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            null,
            'term_taxonomy_id'
        );

        // return $this->belongsToMany(
        //     $modelClass,
        //     config('taxonomy.tables.term_relationships', 'term_relationships'),
        //     'object_id',
        //     'term_taxonomy_id'
        // )->using(TermRelationship::class);
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
