<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogUrlTest extends TestCase
{
    use RefreshDatabase;

    private BlogPost $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = BlogPost::create([
            'category' => 'News',
            'title' => 'The Material Behind Kirin',
            'slug' => 'kirin-spc-flooring',
            'short_description' => 'Short',
            'image_path' => 'x.png',
            'content' => ['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Body']]]]],
        ]);
    }

    public function test_post_opens_on_its_slug_with_no_id_and_is_linked_that_way(): void
    {
        $this->get('/blog/kirin-spc-flooring')->assertOk()->assertSee('The Material Behind Kirin');
        $this->get('/blog')->assertSee('/blog/kirin-spc-flooring"', false);
    }

    public function test_old_id_links_redirect_permanently(): void
    {
        foreach (["kirin-spc-flooring-{$this->post->id}", "the-material-behind-kirin-{$this->post->id}"] as $old) {
            $this->get("/blog/{$old}")->assertStatus(301)->assertRedirect('/blog/kirin-spc-flooring');
        }
    }

    public function test_changing_a_slug_keeps_the_old_url_working(): void
    {
        $this->post->update(['slug' => 'new-name']);

        $this->get('/blog/new-name')->assertOk();
        $this->get('/blog/kirin-spc-flooring')->assertStatus(301)->assertRedirect('/blog/new-name');

        $this->post->update(['slug' => 'kirin-spc-flooring']);

        $this->get('/blog/kirin-spc-flooring')->assertOk();
        $this->get('/blog/new-name')->assertStatus(301)->assertRedirect('/blog/kirin-spc-flooring');
    }

    public function test_slug_ending_in_a_number_is_not_mistaken_for_an_id(): void
    {
        $this->post->update(['slug' => 'flooring-trends-2026']);

        $this->get('/blog/flooring-trends-2026')->assertOk();
    }

    public function test_unknown_urls_are_404(): void
    {
        $this->get('/blog/nothing-here')->assertNotFound();
    }
}
