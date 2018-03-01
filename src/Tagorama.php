<?php

namespace Alaracreative\Tagorama;

use Illuminate\Support\Collection;
use Alaracreative\Tagorama\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Alaracreative\Tagorama\Scopes\TaggableScopes;

trait Tagorama
{
    use TaggableScopes;

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tag($tags)
    {
        $this->addTags($this->getWorkableTags($tags));
    }

    public function untag($tags = null)
    {
        if ($tags === null) {
            $this->removeAllTags();
            return;
        }

        $this->removeTags($this->getWorkableTags($tags));
    }

    public function retag($tags)
    {
        $this->removeAllTags(); // ignore existing tags...

        $this->tag($tags);
    }

    private function addTags(Collection $tags)
    {
        $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        foreach (array_get($sync, 'attached') as $attachedId) {
            $tags->where('id', $attachedId)->first()->increment('count');
        }
    }

    private function removeTags(Collection $tags)
    {
        $this->tags()->detach($tags);

        $countedTags = $tags->where('count', '>', 0);

        $countedTags->each(function ($tag) {
            $tag->decrement('count');
        });
    }

    private function removeAllTags()
    {
        $this->removeTags($this->tags);
    }

    private function getWorkableTags($tags)
    {
        if (is_array($tags)) {
            return $this->getTagModels($tags);
        }

        if ($tags instanceof Model) {
            return $this->getTagModels([$tags->slug]);
        }

        return $this->filterTagsCollection($tags);
    }

    private function filterTagsCollection(Collection $tags)
    {
        return $tags->filter(function ($tag) {
            return $tag instanceof Model;
        });
    }

    private function getTagModels(array $tags)
    {
        return Tag::whereIn('slug', $this->normalizeTagNames($tags))->get();
    }

    private function normalizeTagNames(array $tags)
    {
        return array_map(function ($tag) {
            return str_slug($tag);
        }, $tags);
    }
}
