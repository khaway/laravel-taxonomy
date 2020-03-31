<?php

namespace Scrapify\LaravelTaxonomy\Traits;

use Cromulent\Taxonomy\Models\{Taxonomy, NestedTaxonomy};

trait HasBaseTaxonomyRelations
{
    /**
     * Term nested taxonomies.
     *
     * @param mixed $nested
     * @return mixed
     */
    public function taxonomies($nested = true)
    {
        if (is_string($nested)) {
            return $this->taxonomyRelation(
                config('taxonomy.types.'.$nested, $nested)
            );
        }

        return $this->taxonomyRelation(
            $nested ? NestedTaxonomy::class : Taxonomy::class
        );
    }

    /**
     * Term taxonomies.
     *
     * @return mixed
     */
    public function defaultTaxonomies()
    {
        return $this->taxonomies(false);
    }
}
