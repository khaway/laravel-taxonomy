<?php

namespace Scrapify\LaravelTaxonomy\Models;

class Tag extends Taxonomy
{
    protected $attributes = [
        'taxonomy' => 'post_tag'
    ];
}
