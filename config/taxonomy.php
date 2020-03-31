<?php

use Cromulent\Taxonomy\Models\Taxonomy;
use Cromulent\Taxonomy\Models\NestedTaxonomy;

return [

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
        'default' => Taxonomy::class,
        'nested' => NestedTaxonomy::class,
    ],


    /**
     * Morph name.
     */

    'morph_name' => 'entity'

];
