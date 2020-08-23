<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class Model extends BaseModel
{
    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable($this->table ?: config('taxonomy.tables.'.static::class));
    }
}
