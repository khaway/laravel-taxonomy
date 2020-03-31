<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Models\Observers\TermObserver;
use Scrapify\LaravelTaxonomy\Traits\HasBaseTaxonomyRelations;

/**
 * Class Term
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class Term extends Model
{
    use HasBaseTaxonomyRelations;

    /**
     * @var string
     */
    protected $table = 'terms';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'term_group'];

    /**
     * Term constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(
            config('taxonomy.tables.terms', $this->table ?? 'terms')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(TermObserver::class);
    }

    /**
     * Set the term's slug.
     *
     * @param  string  $value
     * @return void
     */
    // public function setSlugAttribute($value)
    // {
    //     $this->attributes['slug'] = Str::slug($value);
    // }

    /**
     * Taxonomy relation helper.
     *
     * @param string $modelClass
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function taxonomyRelation($modelClass)
    {
        return $this->hasMany($modelClass, $this->getKeyName());
    }
}
