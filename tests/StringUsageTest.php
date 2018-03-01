<?php

class StringUsageTest extends TestCase
{
    protected $lesson;

    public function setUp()
    {
        parent::setUp();

        foreach (['PHP', 'Laravel', 'Testing', 'Redis', 'Postgres', 'Fun Stuff'] as $tag) {
            \TagStub::create([
                'name'  => $tag,
                'slug'  => str_slug($tag),
                'count' => 0
            ]);
        }

        $this->lesson = LessonStub::create([
            'title' => 'A lesson title'
        ]);
    }

    /** @test */
    public function can_tag_lesson()
    {
        $this->lesson->tag(['Laravel', 'PHP']);

        $this->assertCount(2, $this->lesson->tags);

        foreach (['Laravel', 'PHP'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function can_untag_lesson()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'testing']);

        $this->lesson->untag(['testing']);

        $this->assertCount(2, $this->lesson->tags);

        foreach (['Laravel', 'PHP'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function can_untag_all_lesson_tags()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'testing']);

        $this->lesson->untag();

        $this->assertCount(0, $this->lesson->fresh()->tags);
    }

    /** @test */
    public function can_retag_lesson_tags()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'testing']);

        $this->lesson->retag(['Laravel', 'Redis', 'postgres']);

        $this->lesson->load('tags');

        $this->assertCount(3, $this->lesson->tags);

        foreach (['Laravel', 'Redis', 'Postgres'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function non_existing_tags_are_ignored_on_tagging()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'JavaScript']);

        $this->assertCount(2, $this->lesson->tags);

        foreach (['Laravel', 'PHP'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function inconsistant_tag_cases_are_normalized()
    {
        $this->lesson->tag(['Laravel', 'PhP', 'Fun stuff']);

        $this->assertCount(3, $this->lesson->tags);

        foreach (['Laravel', 'PHP', 'Fun Stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }
}
