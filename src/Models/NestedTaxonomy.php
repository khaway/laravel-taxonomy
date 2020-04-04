<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Kalnoy\Nestedset\NodeTrait;
use Scrapify\LaravelTaxonomy\Taxonomy as TaxonomyConfig;
use Scrapify\LaravelTaxonomy\Models\Observers\NestedTaxonomyObserver;

/**
 * Class NestedTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class NestedTaxonomy extends Taxonomy
{
    use NodeTrait;

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(NestedTaxonomyObserver::class);
    }

    /**
     * @param null $table
     * @return mixed
     */
    public function newScopedQuery($table = null)
    {
        $baseModel = TaxonomyConfig::$baseModel;

        return $this->applyNestedSetScope($baseModel::query(), $table);
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children($related = null)
    {
        return $this->hasMany(
            $related ?? static::class,
            $this->getParentIdName()
        );
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent($related = null)
    {
        return $this->belongsTo(
            $related ?? static::class, $this->getParentIdName()
        );
    }
}
