<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EloquentSortable\SortableTrait;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasMeta;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Scrapify\LaravelTaxonomy\Models\Concerns\HasTaxonomy;

/**
 * Class TermRelationship
 *
 * @package Cromulent\Taxonomy\Models
 */
class TermRelationship extends MorphPivot implements Sortable
{
    use SortableTrait, HasTaxonomy, HasMeta;

    /**
     * @var string
     */
    protected $table = 'term_relationships';

    /**
     * @var array|string[]
     */
    public array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['meta', 'order'];

    /**
     * TermRelationship constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(
            config('taxonomy.tables.'.__CLASS__, $this->table ?? 'term_relationships')
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->where('taxonomy_type', $this->taxonomy_type);
    }
}
