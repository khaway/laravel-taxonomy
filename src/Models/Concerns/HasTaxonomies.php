<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;

/**
 * Trait HasTaxonomies
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasTaxonomies
{
    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxonomies($related = null): HasMany
    {
        return $this->hasMany($related ?? Taxonomy::class);
    }
}
