<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;

/**
 * Trait HasTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasTaxonomy
{
    /**
     * Relationship taxonomy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
}
