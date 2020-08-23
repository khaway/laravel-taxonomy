<?php

namespace Scrapify\LaravelTaxonomy\Models\Taxonomies;

/**
 * Class Tag
 *
 * @package Scrapify\LaravelTaxonomy\Models\Taxonomies
 */
class Tag extends Taxonomy
{
    /**
     * @var array
     */
    protected $attributes = [
        'taxonomy' => 'tag'
    ];
}
