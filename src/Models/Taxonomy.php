<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Models\Scopes\TaxonomyScope;
use Scrapify\LaravelTaxonomy\Traits\HasTermFillableAttributes;
use Scrapify\LaravelTaxonomy\Models\Observers\TaxonomyObserver;

/**
 * Class Taxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class Taxonomy extends Model
{
    use HasTermFillableAttributes;

    /**
     * @var string
     */
    protected $table = 'term_taxonomy';

    /**
     * @var array
     */
    protected $fillable = ['term_id', 'taxonomy', 'description'];

    /**
     * @var array
     */
    protected $with = ['term'];

    /**
     * Taxonomy constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(
            config('taxonomy.tables.term_taxonomy', $this->table ?? 'term_taxonomy')
        );
    }

    /**
    * Magic method to return the meta data like the post original fields.
    *
    * @param string $key
    * @return string
    */
    public function __get($key)
    {
        if (($value = parent::__get($key)) !== null) {
            return $value;
        }

        if (isset($this->term) && $this->relationLoaded('term')) {
            return  $this->term->{$key};
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TaxonomyScope);
        static::observe(TaxonomyObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    /**
     * @param $related
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entities($related)
    {
        return $this->morphedByMany(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships'),
            'taxonomy_id'
        );
    }

    /**
     * @param $related
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function entity($related)
    {
        return $this->morphOne(
            $related,
            config('taxonomy.morph_name'),
            config('taxonomy.tables.term_relationships', 'term_relationships')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function newQuery()
    {
        $builder = parent::newQuery();

        if ($taxonomy = $this->getAttribute('taxonomy')) {
            $builder->whereTaxonomy($taxonomy);
        }

        return $builder;
    }
}
