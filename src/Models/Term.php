<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Support\Str;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasMeta;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;
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
    protected $fillable = ['name', 'slug', 'meta'];

    /**
     * @var array
     */
    protected $casts = ['meta' => 'array'];

    /**
     * @return void
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
