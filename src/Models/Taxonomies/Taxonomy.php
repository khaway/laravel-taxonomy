<?php

namespace Scrapify\LaravelTaxonomy\Models\Taxonomies;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasMeta;
use Scrapify\LaravelTaxonomy\Models\Scopes\TaxonomyScope;
use Scrapify\LaravelTaxonomy\Models\Observers\TaxonomyObserver;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasTermFillableAttributes;

/**
 * Class Taxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models\Taxonomies
 */
class Taxonomy extends Model
{
    use HasMeta,
        HasTermFillableAttributes,
        SingleTableInheritanceTrait;

    /**
     * @var string
     */
    public static $singleTableTypeField;

    /**
     * @var array
     */
    public static $singleTableSubclasses;

    /**
     * @var string
     */
    protected $table = 'term_taxonomy';

    /**
     * @var array
     */
    protected $fillable = [
        'term_id', 'type', 'description', 'parent_id', 'meta'
    ];

    /**
     * @var array
     */
    protected $casts = ['meta' => 'array'];

    /**
     * Taxonomy constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        static::$singleTableTypeField = config('taxonomy.sti.type_field');
        static::$singleTableSubclasses = config('taxonomy.types');

        parent::__construct($attributes);

        $this->setTable(
            config('taxonomy.tables.term_taxonomy', $this->table ?? 'term_taxonomy')
        );
    }

    /**
     * @return string
     */
    public static function taxonomyType()
    {
        $class = static::class;

        return defined("{$class}::TAXONOMY_TYPE")
            ? static::TAXONOMY_TYPE
            : Str::snake(class_basename($class));
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

        if (isset($this->term_id) && ! $this->relationLoaded('term')) {
            $this->loadMissing('term');

            if ($termValue = optional($this->term)->{$key}) {
                return $termValue;
            }
        }

        return null;
    }

    /**
     * @return void
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
        )->withPivotValue('taxonomy_type', static::$singleTableType);
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
        )->withPivotValue('taxonomy_type', static::$singleTableType);
    }
}
