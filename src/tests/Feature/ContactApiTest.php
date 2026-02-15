<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_contact_via_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/contacts', [
                'name' => 'John Doe',
                'phone' => '123456789'
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'John Doe',
                'phone' => '123456789',
                'user_id' => $user->id
            ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'phone' => '123456789',
            'user_id' => $user->id
        ]);
    }

    public function test_cannot_create_contact_without_auth()
    {
        $response = $this->postJson('/api/contacts', [
            'name' => 'John Doe',
            'phone' => '123456789'
        ]);

        $response->assertStatus(401);
    }
}
