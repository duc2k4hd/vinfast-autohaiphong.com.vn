<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ClientContactAndLeadSearchTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialAdminUserSeeder::class);
        $this->admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
    }

    public function test_contact_page_displays_contact_page_schema_and_map(): void
    {
        $response = $this->get(route('client.contact.index'));

        $response->assertStatus(200);
        $response->assertSee('ContactPage');
        $response->assertSee('VinFast Minh Đạo Hải Phòng');
        $response->assertSee('VỊ TRÍ SHOWROOM VINFAST MINH ĐẠO HẢI PHÒNG');
        $response->assertSee('maps.google.com');
    }

    public function test_admin_can_search_leads_by_name_or_phone(): void
    {
        DB::table('leads')->insert([
            'name' => 'Hoàng Văn Thử Nghiệm',
            'phone' => '0977665544',
            'email' => 'hoang@vinfast.vn',
            'product_id' => null,
            'message' => 'Cần tư vấn mua xe VF 7',
            'type' => 'consultation',
            'status' => 'new',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.leads.index', ['search' => 'Hoàng Văn Thử Nghiệm']));
        $response->assertStatus(200);
        $response->assertSee('Hoàng Văn Thử Nghiệm');

        $responsePhone = $this->actingAs($this->admin)->get(route('admin.leads.index', ['search' => '0977665544']));
        $responsePhone->assertStatus(200);
        $responsePhone->assertSee('Hoàng Văn Thử Nghiệm');
    }

    public function test_admin_can_update_lead_status_and_delete_lead(): void
    {
        $id = DB::table('leads')->insertGetId([
            'name' => 'Khách Hàng Spam Test',
            'phone' => '0911223344',
            'email' => 'spam@test.vn',
            'product_id' => null,
            'message' => 'Spam message',
            'type' => 'consultation',
            'status' => 'new',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $updateResponse = $this->actingAs($this->admin)->patch(route('admin.leads.update_status', $id), [
            'status' => 'contacted',
        ]);
        $updateResponse->assertSessionHas('success');
        $this->assertDatabaseHas('leads', ['id' => $id, 'status' => 'contacted']);

        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.leads.destroy', $id));
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('leads', ['id' => $id]);
    }
}
