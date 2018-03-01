<?php

use Illuminate\Database\Eloquent\Model;
use Alaracreative\Tagorama\Scopes\TagUsedScopes;
use Alaracreative\Tagorama\Scopes\TagOrderScopes;

class TagStub extends Model
{
    use TagUsedScopes,
        TagOrderScopes;

    protected $connection = 'testbench';

    public $table = 'tags';

    public $timestamps = false;
}
