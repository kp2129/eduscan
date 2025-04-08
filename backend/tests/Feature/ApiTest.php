<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\QRCode;
use App\Models\ScannedQRCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'Test Device',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);
    }

    

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(204);
        $this->assertCount(0, $user->tokens);
    }

    /** @test */
    public function user_can_generate_qr_code()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/qr');

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /** @test */
    public function user_can_validate_qr_code()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $qrCode = QRCode::generateForUser($user);

        $response = $this->postJson('/api/validate-qr-code', [
            'token' => $qrCode->token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'qr_code' => $qrCode->toArray()]);
    }

    /** @test */
    public function user_cannot_generate_qr_code_twice_a_day()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $firstResponse = $this->getJson('/api/qr');

        $firstQrCodeToken = $firstResponse->json('token');

        $secondResponse = $this->getJson('/api/qr');

        $secondResponse->assertStatus(200)
            ->assertJson(['token' => $firstQrCodeToken]);

        $this->assertArrayNotHasKey('message', $secondResponse->json());
    }



    /** @test */
    public function validating_invalid_qr_code()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/validate-qr-code', [
            'token' => 'invalid_token',
        ]);

        $response->assertStatus(400)
            ->assertJson(['success' => false, 'message' => 'Invalid or expired QR code']);
    }
}
