<?php

use Scrapify\LaravelTaxonomy\Models\Taxonomies\Tag;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\NestedTaxonomy;

return [

    /**
     * Base model.
     */

    'base_model' => NestedTaxonomy::class,

    /**
     * Taxonomy tables.
     */

    'tables' => [
        'terms' => 'terms',
        'term_taxonomy' => 'term_taxonomy',
        'term_relationships' => 'term_relationships'
    ],

    /**
     * Taxonomies types.
     */

    'types' => [
        Tag::class
    ],


    /**
     * Morph name.
     */

    'morph_name' => 'entity',

    /**
     * Single table inheritance.
     */

    'sti' => [
        'type_field' => 'type'
    ]

];
