<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class UserResourceTest extends TestCase
{
    use RefreshDatabase; // Use RefreshDatabase to reset the database for each test

    /** @test */
    public function it_displays_home_page()
    {
        $this->actingAs(User::factory()->create());

        // Assert that the home page can be accessed
        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }
}
