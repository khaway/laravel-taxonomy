<?php

namespace Scrapify\LaravelTaxonomy\Models\Observers;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

/**
 * Class NestedTaxonomyObserver
 *
 * @package Scrapify\LaravelTaxonomy\Models\Observers
 */
class NestedTaxonomyObserver
{
    /**
     * Listen to the Term creating event.
     *
     * @param NestedTaxonomy $taxonomy
     * @return void
     */
    public function creating(NestedTaxonomy $taxonomy)
    {
        //
    }
}
