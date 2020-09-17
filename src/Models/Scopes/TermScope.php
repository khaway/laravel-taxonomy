<?php

namespace Scrapify\LaravelTaxonomy\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class TermScope
 *
 * @package Scrapify\LaravelTaxonomy\Models\Scopes
 */
class TermScope extends Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WhereName'];

    /**
     * Add the slug extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWhereName(Builder $builder): void
    {
        $builder->macro('whereName', static function (Builder $builder, $name, $lang = 'en') {
            return $builder->where("name->{$lang}", $name);
        });
    }
}
