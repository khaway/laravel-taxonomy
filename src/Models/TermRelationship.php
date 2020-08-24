<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;

/**
 * Class TermRelationship
 *
 * @package Cromulent\Taxonomy\Models
 */
class TermRelationship extends MorphPivot implements Sortable
{
    use SortableTrait;

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
	// protected $primaryKey = ['entity_id', 'taxonomy_id'];

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['order'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(
            config('taxonomy.tables.term_relationships', $this->table ?? 'term_relationships')
        );
    }

    /**
     * Relationship taxonomy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildSortQuery(): Builder
    {
        return static::query()->where('taxonomy_type', $this->taxonomy_type);
    }
}
