<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Scrapify\LaravelTaxonomy\Models\Term;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait HasTerm
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasTerm
{
    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function term($related = null): BelongsTo
    {
        return $this->belongsTo($related ?? Term::class, 'term_id')->withDefault();
    }
}
