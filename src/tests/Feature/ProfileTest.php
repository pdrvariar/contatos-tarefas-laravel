<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_profile_information_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Novo Nome',
            'email' => 'novo@email.com',
        ]);

        $response->assertRedirect('/profile');
        $this->assertEquals('Novo Nome', $user->fresh()->name);
        $this->assertEquals('novo@email.com', $user->fresh()->email);
    }

    public function test_password_can_be_updated()
    {
        $user = User::factory()->create([
            'password' => \Illuminate\Support\Facades\Hash::make('senha-antiga'),
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => 'senha-antiga',
            'new_password' => 'nova-senha123',
            'new_password_confirmation' => 'nova-senha123',
        ]);

        $response->assertRedirect('/profile');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('nova-senha123', $user->fresh()->password));
    }

    public function test_password_update_requires_correct_current_password()
    {
        $user = User::factory()->create([
            'password' => \Illuminate\Support\Facades\Hash::make('senha-correta'),
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => 'senha-errada',
            'new_password' => 'nova-senha123',
            'new_password_confirmation' => 'nova-senha123',
        ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertFalse(\Illuminate\Support\Facades\Hash::check('nova-senha123', $user->fresh()->password));
    }
}
