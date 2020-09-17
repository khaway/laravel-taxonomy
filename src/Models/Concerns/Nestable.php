<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Kalnoy\Nestedset\NodeTrait;

/**
 * Trait Nestable
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait Nestable
{
    use NodeTrait;

    /**
     * @param null $table
     * @return mixed
     */
    public function newScopedQuery($table = null)
    {
        $baseModel = config('taxonomy.base_model', __CLASS__);

        return $this->applyNestedSetScope($baseModel::query(), $table);
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children($related = null)
    {
        return $this->hasMany($related ?? static::class, $this->getParentIdName());
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent($related = null)
    {
        return $this->belongsTo($related ?? static::class, $this->getParentIdName());
    }
}
