<?php

namespace Alaracreative\Tagorama\Scopes;

trait TaggableScopes
{
    public function scopeWithAnyTag($query, array $tags)
    {
        // convert this to accept strings, collections, or arrays
        return $query->hasTags($tags);
    }

    public function scopeWithAllTags($query, array $tags)
    {
        foreach ($tags as $tag) {
            $query->hasTags([$tag]);
        }

        return $query;
    }

    public function scopeHasTags($query, array $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            return $query->whereIn('slug', $tags);
        });
    }
}
