## Laravel Taxonomy.

Inspired by power of WordPress taxonomies, for Laravel Artisans.

```php
<?php

use Scrapify\LaravelTaxonomy\Models\Taxonomies\NestedTaxonomy;
use Scrapify\LaravelTaxonomy\InteractsWithTaxonomies;

class ProductCategory extends NestedTaxonomy
{
    public static $singleTableType = 'product_category';
}

class Product
{
    use InteractsWithTaxonomies;

    public function categories()
    {
        return $this->morphToManyTaxonomies(ProductCategory::class);
    }
}

$productCategory = ProductCategory::create(['Notebooks']);

Product::create(['name' => 'Apple MacBook'])
    ->categories()
    ->sync($productCategory->id);
```
