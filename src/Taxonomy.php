<?php

namespace Scrapify\LaravelTaxonomy;

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;

/**
 * Class Taxonomy
 *
 * @package Scrapify\LaravelTaxonomy
 */
class Taxonomy
{
    /**
     * @var string
     */
    public static $baseModel = NestedTaxonomy::class;

    /**
     * @var array
     */
    public static $sub = [];

    /**
     * @var string
     */
    public static $typeField = 'taxonomy';

    /**
     * @var string
     */
    public static $defaultType = 'taxonomy';
}
