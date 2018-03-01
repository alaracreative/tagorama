<?php


class CountTest extends TestCase
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
    public function tag_count_is_incremented_when_tagged()
    {
        $tag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 0
        ]);

        $this->lesson->tag($tag);

        $this->assertEquals(1, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_is_decremented_when_untagged()
    {
        $tag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 1
        ]);

        $this->lesson->tag($tag);
        $this->lesson->untag($tag);

        $this->assertEquals(1, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_is_incremented_when_retagged()
    {
        $tag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 0
        ]);

        $this->lesson->retag($tag);

        $this->assertEquals(1, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_is_decremented_when_retagged()
    {
        $tag = \TagStub::create([
                'name'  => 'Laravel',
                'slug'  => 'laravel',
                'count' => 0
            ]);

        $this->lesson->tag($tag);

        $retag = \TagStub::create([
                'name'  => 'PHP',
                'slug'  => 'php',
                'count' => 0
            ]);

        $this->lesson->retag($retag);

        $this->assertEquals(0, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_cannot_dip_below_zero()
    {
        $tag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 0
        ]);

        $this->lesson->untag($tag);

        $this->assertEquals(0, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_does_not_increment_if_already_tagged()
    {
        $tag = \TagStub::create([
            'name'  => 'Laravel',
            'slug'  => 'laravel',
            'count' => 0
        ]);

        $this->lesson->tag(['laravel']);
        $this->lesson->retag(['laravel']);
        $this->lesson->tag(['laravel']);

        $this->assertEquals(1, $tag->fresh()->count);
    }

    /** @test */
    public function tag_count_where_gte()
    {
        foreach (['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun Stuff'] as $tag) {
            \TagStub::create([
                'name'  => $tag,
                'slug'  => str_slug($tag),
                'count' => 0
            ]);
        }

        $laravelTag = \TagStub::where('slug', 'laravel')->first();
        $laravelTag->count = 4;
        $laravelTag->save();

        $phpTag = \TagStub::where('slug', 'php')->first();
        $phpTag->count = 5;
        $phpTag->save();

        $tags = \TagStub::usedGte(4);

        $this->assertEquals(2, $tags->count());
    }

    /** @test */
    public function tag_count_where_gt()
    {
        foreach (['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun Stuff'] as $tag) {
            \TagStub::create([
                'name'  => $tag,
                'slug'  => str_slug($tag),
                'count' => 0
            ]);
        }

        $laravelTag = \TagStub::where('slug', 'laravel')->first();
        $laravelTag->count = 4;
        $laravelTag->save();

        $phpTag = \TagStub::where('slug', 'php')->first();
        $phpTag->count = 5;
        $phpTag->save();

        $tags = \TagStub::usedGt(4);

        $this->assertEquals(1, $tags->count());
    }

    /** @test */
    public function tag_count_where_lte()
    {
        foreach (['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun Stuff'] as $tag) {
            \TagStub::create([
                'name'  => $tag,
                'slug'  => str_slug($tag),
                'count' => 0
            ]);
        }

        $laravelTag = \TagStub::where('slug', 'laravel')->first();
        $laravelTag->count = 4;
        $laravelTag->save();

        $phpTag = \TagStub::where('slug', 'php')->first();
        $phpTag->count = 5;
        $phpTag->save();

        $tags = \TagStub::usedLte(4);

        $this->assertEquals(5, $tags->count());
    }

    /** @test */
    public function tag_count_where_lt()
    {
        foreach (['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun Stuff'] as $tag) {
            \TagStub::create([
                'name'  => $tag,
                'slug'  => str_slug($tag),
                'count' => 0
            ]);
        }

        $laravelTag = \TagStub::where('slug', 'laravel')->first();
        $laravelTag->count = 4;
        $laravelTag->save();

        $phpTag = \TagStub::where('slug', 'php')->first();
        $phpTag->count = 5;
        $phpTag->save();

        $tags = \TagStub::usedLt(4);

        $this->assertEquals(4, $tags->count());
    }
}
