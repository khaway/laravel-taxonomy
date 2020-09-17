<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Scrapify\LaravelTaxonomy\Models\Scopes\TypeScope;

/**
 * Trait ScopesByType
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait ScopesByType
{
    /**
     * @returns void
     */
    protected static function bootScopesByType(): void
    {
        static::addGlobalScope(new TypeScope);
    }
}
