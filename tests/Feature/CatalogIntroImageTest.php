<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CatalogIntroImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_displays_the_public_intro_image(): void
    {
        DB::table('settings')->insert(['key' => 'catalog_intro_image', 'value' => 'clients/assets/images/catalog.jpg', 'group' => 'general', 'is_public' => true]);

        $this->get(route('client.catalog.index'))
            ->assertOk()
            ->assertSee('class="catalog-intro__banner', false)
            ->assertSee('storage/clients/assets/images/catalog.jpg');
    }

    public function test_catalog_omits_the_intro_image_when_not_configured(): void
    {
        $this->get(route('client.catalog.index'))
            ->assertOk()
            ->assertDontSee('class="catalog-intro__banner', false);
    }

    public function test_admin_can_save_and_clear_the_intro_image(): void
    {
        $this->seed(InitialAdminUserSeeder::class);
        $admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->firstOrFail();

        $this->actingAs($admin)->get(route('admin.settings.index'))->assertOk()->assertSee('catalog_intro_image');
        $this->actingAs($admin)->put(route('admin.settings.update'), ['catalog_intro_image' => 'clients/assets/images/catalog.jpg'])->assertRedirect();
        $this->assertDatabaseHas('settings', ['key' => 'catalog_intro_image', 'value' => 'clients/assets/images/catalog.jpg', 'is_public' => true]);
        $this->actingAs($admin)->put(route('admin.settings.update'), ['catalog_intro_image' => ''])->assertRedirect();
        $this->assertDatabaseHas('settings', ['key' => 'catalog_intro_image', 'value' => '']);
    }
}
