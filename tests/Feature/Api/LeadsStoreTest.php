<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Leads;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class LeadsStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create the permission and roles if they don't exist
        Permission::findOrCreate('add lead');
        Role::findOrCreate('super admin');
        Role::findOrCreate('manager');
    }

    public function test_it_denies_access_to_unauthenticated_users()
    {
        $response = $this->postJson('/api/leads', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'source' => 'Direct',
            'status' => 'New',
            'user_id' => 'some-uuid',
        ]);

        $response->assertStatus(401);
    }

    public function test_it_denies_access_to_authenticated_users_without_permission()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/leads', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'source' => 'Direct',
            'status' => 'New',
            'user_id' => $user->id,
        ]);

        // StoreLeadsRequest::authorize() returns false, which results in a 403 Forbidden
        $response->assertStatus(403);
    }

    public function test_it_allows_authenticated_users_with_permission_to_store_a_lead()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('add lead');
        Sanctum::actingAs($user);

        $agent = User::factory()->create();

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'source' => 'Website',
            'status' => 'New',
            'user_id' => $agent->id,
            'birthday' => '1990-01-01',
            'lead_type' => 'buyer',
        ];

        $response = $this->postJson('/api/leads', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Lead created successfully.',
            ]);

        $this->assertDatabaseHas('leads', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'user_id' => $agent->id,
        ]);
    }

    public function test_it_returns_validation_errors_for_missing_required_fields()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('add lead');
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/leads', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'source', 'status', 'user_id']);
    }
}
