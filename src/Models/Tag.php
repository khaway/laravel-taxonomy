<?php

namespace Scrapify\LaravelTaxonomy\Models;

/**
 * Class Tag
 *
 * @package Scrapify\LaravelTaxonomy\Models
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
