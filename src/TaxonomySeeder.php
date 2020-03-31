<?php

namespace Scrapify\LaravelTaxonomy;

use RuntimeException;
use Illuminate\Database\Seeder;

/**
 * Class TaxonomySeeder
 *
 * @package Scrapify\LaravelTaxonomy
 */
class TaxonomySeeder extends Seeder
{
    /**
     * Taxonomy model class.
     *
     * @var string
     */
    protected $taxonomyModel;

    /**
     * Determine if you need a root directory.
     *
     * @var bool
     */
    protected $withRootTaxonomy = false;

    /**
     * Run taxonomies seed.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function run()
    {
        $taxonomies = $this->taxonomies();

        if ($this->withRootTaxonomy) {
            $this->taxonomyModel::create($taxonomies);
        } else {
            // @todo check for first element (is_array)
            foreach ($taxonomies as $taxonomy) {
                $this->taxonomyModel::create($taxonomy);
            }
        }
    }

    /**
     * Get taxonomies to seed.
     *
     * @return array
     * @throws \RuntimeException
     */
    public function taxonomies()
    {
        throw new RuntimeException('Override '.__FUNCTION__.' method.');
    }

    /**
     * Get taxonomy model class.
     *
     * @return string
     */
    public function getTaxonomyModel(): string
    {
        return $this->taxonomyModel;
    }

    /**
     * Set taxomony model class.
     *
     * @param $modelClass
     * @return $this
     */
    public function setTaxonomyModel($modelClass): self
    {
        $this->taxonomyModel = $modelClass;

        return $this;
    }

    /**
     * Set with root taxonomy.
     *
     * @param bool $with
     * @return $this
     */
    public function setWithRootTaxonomy(bool $with): self
    {
        $this->withRootTaxonomy = $with;

        return $this;
    }
}
