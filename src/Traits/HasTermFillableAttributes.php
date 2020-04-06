<?php

namespace Scrapify\LaravelTaxonomy\Traits;

trait HasTermFillableAttributes
{
    /**
     * {@inheritdoc}
     */
    protected $termFillable = ['name', 'slug'];

    /**
     * Boot the metable trait on the model.
     *
     * @return void
     */
    public function initializeHasTermFillableAttributes()
    {
    	$this->addTermFillableAttributes();
    }

    /**
     * Boot the metable trait on the model.
     *
     * @return void
     */
    private function addTermFillableAttributes()
    {
        $this->fillable(array_merge(
            $this->getFillable(), $this->getTermFillable()
        ));

        return $this;
    }

    /**
     * Boot the metable trait on the model.
     *
     * @return array
     */
    public function getTermFillable()
    {
        return $this->termFillable;
    }

    /**
     * Boot the metable trait on the model.
     *
     * @return void
     */
    public function termFillable(array $termFillable)
    {
        $this->termFillable = $termFillable;

        return $this;
    }
}
