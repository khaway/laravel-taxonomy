<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

use Illuminate\Support\Str;
use Scrapify\LaravelTaxonomy\Support\Helpers;

/**
 * Trait HasTypeGuess
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasTypeGuess
{
    /**
     * @param $value
     * @return string
     */
    public function getTypeAttribute($value): string
    {
        return $this->guessType($value);
    }

    /**
     * @param null $type
     * @return string
     */
    public function guessType($type = null): string
    {
        $class = static::class;
        $values = [
            $type,
            defined("{$class}::TAXONOMY_TYPE") ? static::TAXONOMY_TYPE : null,
            Str::snake(class_basename($class))
        ];

        return Helpers::firstNotNull($values);
    }
}
