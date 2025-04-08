<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\QRCode;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QRCodeTest extends TestCase
{
    use RefreshDatabase;

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

        // First QR code generation
        $firstResponse = $this->getJson('/api/qr');
        $firstQrCodeToken = $firstResponse->json('token');

        // Second QR code generation attempt
        $secondResponse = $this->getJson('/api/qr');
        $secondResponse->assertStatus(200)
            ->assertJson(['token' => $firstQrCodeToken]);

        // Ensure that the response does not contain an error message
        $this->assertArrayNotHasKey('message', $secondResponse->json());
    }

    /** @test */
    public function unauthenticated_user_cannot_generate_qr_code()
    {
        // Try to generate QR code without authentication
        $response = $this->getJson('/api/qr');

        // Assert that unauthenticated users cannot access the endpoint
        $response->assertStatus(401);
    }

    /** @test */
    public function unauthenticated_user_cannot_validate_qr_code()
    {
        $user = User::factory()->create();
        $qrCode = QRCode::generateForUser($user);

        $response = $this->postJson('/api/validate-qr-code', [
            'token' => $qrCode->token,
        ]);

        $response->assertStatus(401);
    }
}
