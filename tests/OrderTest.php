<?php

class OrderTest extends TestCase
{
    protected $lesson;

    public function setUp()
    {
        parent::setUp();

        $this->lesson = LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

    /** @test */
    public function popularity_contest()
    {
        $laravelTag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 2
        ]);

        $phpTag = \TagStub::create([
            'name'  => 'PHP',
            'slug'  => 'php',
            'count' => 3
        ]);

        $testingTag = \TagStub::create([
            'name'  => 'Testing',
            'slug'  => 'testing',
            'count' => 0
        ]);

        $redisTag = \TagStub::create([
            'name'  => 'Redis',
            'slug'  => 'redis',
            'count' => 1
        ]);

        $tags = \TagStub::popular()->get();

        $this->assertEquals(
            $tags->pluck('id'),
            $tags->sortByDesc('count')->pluck('id')
        );
    }

    /** @test */
    public function unpopular_tags()
    {
        $laravelTag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 2
        ]);

        $phpTag = \TagStub::create([
            'name'  => 'PHP',
            'slug'  => 'php',
            'count' => 3
        ]);

        $testingTag = \TagStub::create([
            'name'  => 'Testing',
            'slug'  => 'testing',
            'count' => 0
        ]);

        $redisTag = \TagStub::create([
            'name'  => 'Redis',
            'slug'  => 'redis',
            'count' => 1
        ]);

        $tags = \TagStub::unpopular()->get();

        $this->assertEquals(
            $tags->pluck('id'),
            $tags->sortBy('count')->pluck('id')
        );
    }
}
