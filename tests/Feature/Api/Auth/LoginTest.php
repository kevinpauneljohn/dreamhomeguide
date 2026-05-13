<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_receive_http_only_cookie()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertCookie('auth_token');

        // Check if cookie is httpOnly
        $cookie = $response->getCookie('auth_token', false); // false to not decrypt
        $this->assertTrue($cookie->isHttpOnly());

        // Check expiration in minutes (10080)
        $expectedExpire = time() + (10080 * 60);
        $this->assertLessThanOrEqual($expectedExpire + 10, $cookie->getExpiresTime());
        $this->assertGreaterThanOrEqual($expectedExpire - 10, $cookie->getExpiresTime());
    }

    public function test_user_can_logout_and_cookie_is_cleared()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertCookieExpired('auth_token');
    }
}
