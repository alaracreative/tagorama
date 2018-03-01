<?php

namespace Alaracreative\Tagorama\Models;

use Illuminate\Database\Eloquent\Model;
use Alaracreative\Tagorama\Scopes\TagUsedScopes;
use Alaracreative\Tagorama\Scopes\TagOrderScopes;

class Tag extends Model
{
    use TagUsedScopes,
        TagOrderScopes;

    public $timestamps = false;

    protected $fillable = ['name', 'slug'];
}
