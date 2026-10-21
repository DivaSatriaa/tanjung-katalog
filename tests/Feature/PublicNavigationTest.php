<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_mobile_menu_and_bottom_navigation(): void
    {
        foreach (['home', 'product.index', 'umkm.index', 'peta.index'] as $routeName) {
            $this->get(route($routeName))
                ->assertOk()
                ->assertSee('id="mobile-menu-button"', false)
                ->assertSee('aria-label="Navigasi bawah"', false);
        }
    }

    public function test_bottom_navigation_marks_current_section_as_active(): void
    {
        $this->get(route('product.index'))
            ->assertOk()
            ->assertSee('aria-current="page"', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('aria-current="page"', false);
    }

    public function test_public_pages_and_admin_login_show_kelurahan_emblem(): void
    {
        foreach ([route('home'), route('umkm.index'), route('admin.login')] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('images/lambang-kota-semarang.png', false)
                ->assertSee('alt="Lambang Kota Semarang"', false);
        }
    }
}
