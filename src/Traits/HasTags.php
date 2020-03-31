<?php

namespace Scrapify\LaravelTaxonomy\Traits;

use Scrapify\LaravelTaxonomy\Models\Tag;

trait HasTags
{
    public function tags($tags)
    {
        $className = static::getTagClassName();

        $tags = collect($className::findOrCreate($tags));

        $this->tagsRelation()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }

    public function tag($tags)
    {
//        $this->tags()->syncWithoutDetaching()
    }


    /**
     * Entity tags.
     *
     * @return mixed
     */
    public function tagsRelation()
    {
        return $this->taxonomyRelation(Tag::class);
    }


    public function untag() {}
    public function retag() {}
    public function detag() {}
}
