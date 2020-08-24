<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Models\Taxonomies\Taxonomy;
use Scrapify\LaravelTaxonomy\InteractsWithTaxonomies;

class TestModel extends Model
{
    use InteractsWithTaxonomies;

    protected $table = 'test_models';
    protected $guarded = [];
    protected $fillable = ['name', 'taxonomy_id'];
    public $timestamps = false;

    /**
     *
     */
    public function products()
    {
        return $this->morphToManyTaxonomies(TestProductCategory::class);
    }

    public function some()
    {
        return $this->morphToManyTaxonomies(TestSomeCategory::class);
    }

    public function serviceType()
    {
        return $this->morphToOneTaxonomy(TestServiceType::class);
    }

    public function taxonomies()
    {
        return $this->morphToManyTaxonomies(Taxonomy::class);
    }
}
