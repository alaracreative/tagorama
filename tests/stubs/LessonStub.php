<?php

use Alaracreative\Tagorama\Tagorama;
use Illuminate\Database\Eloquent\Model;

class LessonStub extends Model
{
    use Tagorama;

    protected $connection = 'testbench';

    public $table = 'lessons';
}
