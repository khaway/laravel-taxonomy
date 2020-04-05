<?php

namespace Scrapify\LaravelTaxonomy\Traits;

use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Trait HasMeta
 *
 * @package Scrapify\LaravelTaxonomy\Traits
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
