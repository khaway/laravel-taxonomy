<?php

namespace Scrapify\LaravelTaxonomy\Models;

use LogicException;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Kalnoy\Nestedset\AncestorsRelation;
use Kalnoy\Nestedset\DescendantsRelation;
use Scrapify\LaravelTaxonomy\Models\Observers\NestedTaxonomyObserver;

/**
 * Class NestedTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models
 */
class NestedTaxonomy extends Taxonomy
{
    use NodeTrait;

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(NestedTaxonomyObserver::class);
    }

    /**
     * @param null $table
     * @return mixed
     */
    public function newScopedQuery($table = null)
    {
        return $this->applyNestedSetScope(NestedTaxonomy::query(), $table);
    }

    /**
     * @param NestedTaxonomy $parent
     * @return NestedTaxonomy
     */
    public function appendToNode(NestedTaxonomy $parent)
    {
        return $this->appendOrPrependTo($parent);
    }

    /**
     * @param NestedTaxonomy $parent
     * @param bool $prepend
     * @return NestedTaxonomy
     */
    public function appendOrPrependTo(NestedTaxonomy $parent, $prepend = false)
    {
        $this->assertNodeExists($parent)
            ->assertNotDescendant($parent)
            ->assertSameScope($parent);

        $this->setParent($parent)->dirtyBounds();

        return $this->setNodeAction('appendOrPrepend', $parent, $prepend);
    }

    /**
     * @param NestedTaxonomy $node
     * @return $this
     */
    protected function assertNodeExists(NestedTaxonomy $node)
    {
        if ( ! $node->getLft() || ! $node->getRgt()) {
            throw new LogicException('Node must exists.');
        }

        return $this;
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children($related = null)
    {
        return $this->hasMany(
            $related ?? static::class,
            $this->getParentIdName()
        );
    }

    /**
     * @param null $related
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent($related = null)
    {
        return $this->belongsTo(
            $related ?? static::class, $this->getParentIdName()
        );
    }

    /**
     * @param null $table
     * @return mixed
     */
    public function newNestedSetQuery($table = null)
    {
        $builder = $this->usesSoftDelete()
            ? $this->withTrashed()
            : NestedTaxonomy::query();

        return $this->applyNestedSetScope($builder, $table);
    }

    /**
     * Get query for descendants of the node.
     *
     * @return DescendantsRelation
     */
    public function descendants()
    {
        return new DescendantsRelation(
            new QueryBuilder(
                $this->newBaseQueryBuilder()
            ), $this
        );
    }

    /**
     * Get query ancestors of the node.
     *
     * @return  AncestorsRelation
     */
    public function ancestors()
    {
        return new AncestorsRelation(new QueryBuilder(
            $this->newBaseQueryBuilder()
        ), $this);
    }
}
