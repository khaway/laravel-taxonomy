<?php

namespace Scrapify\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * Class TermRelationship
 *
 * @todo configure pivot model
 * @package Cromulent\Taxonomy\Models
 */
class TermRelationship extends Pivot
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'term_relationships';

    /**
     * {@inheritdoc}
     */
	protected $primaryKey = ['entity_id', 'taxonomy_id'];

    /**
     * {@inheritdoc}
     */
    // protected $fillable = ['object_id', 'term_taxonomy_id', 'term_order'];

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
}
