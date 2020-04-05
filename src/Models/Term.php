<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Traits\HasMeta;
use Scrapify\LaravelTaxonomy\Models\Observers\TermObserver;

/**
 * Class Term
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class Term extends Model
{
    use HasMeta;

    /**
     * @var string
     */
    protected $table = 'terms';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * @var array
     */
    protected $casts = ['meta' => 'array'];

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
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxonomies($related = null)
    {
        return $this->hasMany($related ?? Taxonomy::class);
    }
}
