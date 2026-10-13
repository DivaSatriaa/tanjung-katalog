<?php

namespace Tests\Feature;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_include_mobile_menu_and_mark_current_section(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.umkms.index'))
            ->assertOk()
            ->assertSee('id="mobile-menu-button"', false)
            ->assertSee('id="mobile-menu"', false)
            ->assertSee('aria-current="page"', false);
    }

    public function test_admin_umkm_table_shows_category_and_status_in_mobile_summary(): void
    {
        Umkm::factory()->create(['name' => 'Sari Laut', 'status' => 'draft']);

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.umkms.index'))
            ->assertOk()
            ->assertSee('Sari Laut')
            ->assertSee('md:hidden', false)
            ->assertSee('Draft');
    }
}
