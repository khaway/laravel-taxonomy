<?php

namespace Scrapify\LaravelTaxonomy\Models\Taxonomies;

use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Models\Model;
use Spatie\EloquentSortable\SortableTrait;
use Scrapify\LaravelTaxonomy\Support\Helpers;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasMeta;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasTerm;
use Scrapify\LaravelTaxonomy\Models\Scopes\TaxonomyScope;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasEntities;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasTypeGuess;
use Scrapify\LaravelTaxonomy\Models\Concerns\ScopesByType;
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
        HasTerm,
        HasEntities,
        HasTypeGuess,
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
    protected $fillable = ['term_id', 'type', 'description', 'parent_id', 'meta'];

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
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new TaxonomyScope);
        static::observe(TaxonomyObserver::class);
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


        if (in_array($key, $this->getTermFillable())) {
            if (isset($this->term_id) && ! $this->relationLoaded('term')) {
                $this->loadMissing('term');
            }

            if (isset($this->term)) {
                return $this->term->{$key};
            }
        }

        return null;
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
}
