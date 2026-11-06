<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // The site footer reads its details from this file.
        Storage::fake('local');
        Storage::put('home-content.json', json_encode([
            'footer_title' => 'Kirin', 'footer_description' => 'Floors', 'footer_phone' => '+94 77 738 5059',
            'footer_email' => 'kirinfloors@sais.lk', 'footer_address' => 'Colombo',
        ]));
    }

    public function test_unknown_url_shows_the_branded_404_page(): void
    {
        $this->get('/no-such-page')
            ->assertNotFound()
            ->assertSee('Page Not Found')
            ->assertSee("We couldn't find that page", false)
            ->assertSee('<meta name="robots" content="noindex">', false)
            ->assertSee('GTM-5TR2NRB5')
            ->assertSee('kirinfloors@sais.lk');
    }

    public function test_cart_count_is_still_right_on_the_404_page(): void
    {
        $this->withSession(['cart' => [1 => ['quantity' => 2], 2 => ['quantity' => 1]]])
            ->get('/some/old/link')
            ->assertNotFound()
            ->assertSeeInOrder(['id="cart-count"', '3'], false);
    }

    public function test_missing_products_and_posts_use_the_same_page(): void
    {
        foreach (['/product/99999', '/blog/no-such-post', '/press-release/99999'] as $url) {
            $this->get($url)->assertNotFound()->assertSee('Page Not Found');
        }
    }
}
