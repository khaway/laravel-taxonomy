<?php

namespace Scrapify\LaravelTaxonomy\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class TaxonomyScope
 *
 * @package Scrapify\LaravelTaxonomy\Models\Scopes
 */
class TaxonomyScope extends Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WhereType', 'WhereSlug', 'WhereName'];

    /**
     * Add the taxonomy extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWhereType(Builder $builder): void
    {
        $builder->macro('whereType', static function (Builder $builder, $taxonomy, $slug = null) {
            $builder->where('type', $taxonomy);

            if ($slug) {
                $builder->slug($slug);
            }

            return $builder;
        });
    }

    /**
     * Add the slug extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWhereSlug(Builder $builder): void
    {
        $builder->macro('whereSlug', static function (Builder $builder, $slug) {
            if (! is_array($slug)) {
                $slug = func_get_args();
                $slug = array_splice($slug, 1);
            }

            return $builder->whereHas('term', static function ($query) use ($slug) {
                $query->whereIn('slug', $slug);
            });
        });
    }

    /**
     * Add the slug extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWhereName(Builder $builder): void
    {
        $builder->macro('whereName', static function (Builder $builder, $name, $lang = 'en') {
            if (! is_array($name)) {
                $name = func_get_args();
                $name = array_splice($name, 1);
            }

            return $builder->whereHas('term', static function ($query) use ($name, $lang) {
                $query->whereIn("name->{$lang}", $name);
            });
        });
    }
}
