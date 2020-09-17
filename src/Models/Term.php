<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Scrapify\LaravelTaxonomy\Models\{Concerns\HasMeta,
    Observers\TermObserver,
    Concerns\HasTaxonomies,
    Scopes\TermScope};

/**
 * Class Term
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class Term extends Model
{
    use HasMeta, HasTaxonomies, HasTranslations;

    /**
     * @var string[]
     */
    public $translatable = ['name'];

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

        static::addGlobalScope(new TermScope);
        static::observe(TermObserver::class);
    }

    /**
     * Set the term's slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = Str::slug($value);
    }
}
