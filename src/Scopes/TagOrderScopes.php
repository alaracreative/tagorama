<?php

namespace Alaracreative\Tagorama\Scopes;

trait TagOrderScopes
{
    public function scopePopular($query)
    {
        $query->orderBy('count', 'desc');
    }

    public function scopeUnpopular($query)
    {
        $query->orderBy('count', 'asc');
    }
}
