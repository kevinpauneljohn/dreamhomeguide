<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class LoginController extends Controller
{
    protected function getLocationFromIp(string $ip): ?array
    {
        $response = Http::get("https://ipinfo.io/{$ip}/json");

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        return [
            'city'     => $data['city'] ?? null,
            'region'   => $data['region'] ?? null,
            'country'  => $data['country'] ?? null,
            'lat'      => isset($data['loc']) ? explode(',', $data['loc'])[0] : null,
            'lng'      => isset($data['loc']) ? explode(',', $data['loc'])[1] : null,
            'timezone' => $data['timezone'] ?? null,
            'isp'      => $data['org'] ?? null,
        ];
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            activity('login')
                ->causedBy($user)
                ->performedOn($user)
                ->withProperties([
                    'ip'        => $request->ip(),
                    'user_agent'=> $request->userAgent(),
                    'device'    => $this->detectDevice($request),
                    'browser'   => $this->detectBrowser($request),
                    'os'        => $this->detectOS($request),
                    'location'  => $this->getLocationFromIp($request->ip()),
                    'referer'   => $request->headers->get('referer'),
                    'route'     => optional($request->route())->getName(),
                    'url'       => $request->fullUrl(),
                    'method'    => $request->method(),
                ])
                ->event('login')
                ->log('Logged in via API');

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ])->cookie(
                'auth_token', $token, 10080, '/', null, true, true, false, 'Lax'
            );
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }

    protected function detectDevice(Request $request): string
    {
        return str_contains($request->userAgent(), 'Mobile') ? 'Mobile' : 'Desktop';
    }

    protected function detectBrowser(Request $request): string
    {
        $ua = $request->userAgent();

        return match (true) {
            str_contains($ua, 'Chrome') => 'Chrome',
            str_contains($ua, 'Firefox') => 'Firefox',
            str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome') => 'Safari',
            str_contains($ua, 'Edge') => 'Edge',
            default => 'Unknown',
        };
    }

    protected function detectOS(Request $request): string
    {
        $ua = $request->userAgent();

        return match (true) {
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'Mac OS') => 'macOS',
            str_contains($ua, 'Linux') => 'Linux',
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') => 'iOS',
            default => 'Unknown',
        };
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        activity('logout')
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'device'     => $this->detectDevice($request),
                'browser'    => $this->detectBrowser($request),
                'os'         => $this->detectOS($request),
                'location'   => $this->getLocationFromIp($request->ip()),
                'route'      => optional($request->route())->getName(),
                'url'        => $request->fullUrl(),
                'method'     => $request->method(),
            ])
            ->event('logout')
            ->log('Logged out via API');

        /** @var \App\Models\User $user */
//        $user->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ])->withoutCookie('auth_token');
    }
}
