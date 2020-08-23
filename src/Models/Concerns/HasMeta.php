<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Trait HasMeta
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasMeta
{
    /**
     * @return SchemalessAttributes
     */
    public function getMetaAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'meta');
    }
}
