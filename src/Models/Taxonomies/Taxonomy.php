<?php

namespace Scrapify\LaravelTaxonomy\Models\Taxonomies;

use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Scrapify\LaravelTaxonomy\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Scrapify\LaravelTaxonomy\Models\Model;
use Spatie\EloquentSortable\SortableTrait;
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
class Taxonomy extends Model implements Sortable
{
    use HasMeta,
        SortableTrait,
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
     * @var array|string[]
     */
    public array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true
    ];

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
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->where([
            'type' => $this->type,
            'parent_id' => $this->parent_id
        ]);
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
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function term($related = null)
    {
        return $this->belongsTo($related ?? Term::class, 'term_id');
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
