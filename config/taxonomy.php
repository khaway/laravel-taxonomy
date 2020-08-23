<?php

use Scrapify\LaravelTaxonomy\Models\Term;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Tag;
use Scrapify\LaravelTaxonomy\Models\TermRelationship;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;
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
        Term::class => 'terms',
        Taxonomy::class => 'term_taxonomy',
        TermRelationship::class => 'term_relationships'
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
