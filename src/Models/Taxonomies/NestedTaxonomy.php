<?php

namespace Scrapify\LaravelTaxonomy\Models\Taxonomies;

use Scrapify\LaravelTaxonomy\Models\Concerns\Nestable;

/**
 * Class NestedTaxonomy
 *
 * @package Scrapify\LaravelTaxonomy\Models\Taxonomies
 */
class NestedTaxonomy extends Taxonomy
{
    use Nestable;
}
