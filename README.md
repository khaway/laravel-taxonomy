## Laravel taxonomy package

```php
<?php

use Scrapify\LaravelTaxonomy\Models\NestedTaxonomy;
use Scrapify\LaravelTaxonomy\Traits\HasTaxonomies;

class ProductCategory extends NestedTaxonomy
{
    protected $attributes = [
        'taxonomy' => 'product_category'
    ];   
}

class Product
{
    use HasTaxonomies;

    public function categories()
    {
        return $this->morphToManyTaxonomies(ProductCategory::class);
    }
}

$product = Product::create([...])->syncWithManyTaxonomies()
```
