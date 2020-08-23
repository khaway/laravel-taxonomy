<?php

namespace Scrapify\LaravelTaxonomy\Models\Concerns;

/**
 * Trait HasTermFillableAttributes
 *
 * @package Scrapify\LaravelTaxonomy\Models\Concerns
 */
trait HasTermFillableAttributes
{
    /**
     * @var array
     */
    protected $termFillable = ['name', 'slug'];

    /**
     * @return void
     */
    public function initializeHasTermFillableAttributes(): void
    {
    	$this->addTermFillableAttributes();
    }

    /**
     * Boot the metable trait on the model.
     *
     * @return HasTermFillableAttributes
     */
    private function addTermFillableAttributes(): self
    {
        $this->fillable(array_merge(
            $this->getFillable(),
            $this->getTermFillable()
        ));

        return $this;
    }

    /**
     * @return array
     */
    public function getTermFillable(): array
    {
        return $this->termFillable;
    }

    /**
     * @param array $termFillable
     * @return $this
     */
    public function termFillable(array $termFillable): self
    {
        $this->termFillable = $termFillable;

        return $this;
    }
}
