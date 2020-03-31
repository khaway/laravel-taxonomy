<?php

namespace Scrapify\LaravelTaxonomy\Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Scrapify\LaravelTaxonomy\Traits\HasTaxonomies;

class TestModel extends Model
{
    use HasTaxonomies;

    protected $table = 'test_models';
    protected $guarded = [];
    protected $fillable = ['name'];
    public $timestamps = false;

    /**
     *
     */
    public function products()
    {
        return $this->morphToManyTaxonomies(TestProductCategory::class);
    }
}
