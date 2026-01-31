<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

    public function login(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
    {
        if(auth()->check())
        {
            return redirect()->route('dashboard');
        }
        return view('dashboard.auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // ✅ REMEMBER ME FLAG
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            activity('login')
                ->causedBy(Auth::user())
                ->performedOn(Auth::user())
                ->withProperties([
                    'ip'        => $request->ip(),
                    'user_agent'=> $request->userAgent(),
                    'device'    => $this->detectDevice($request),
                    'browser'   => $this->detectBrowser($request),
                    'os'        => $this->detectOS($request),
                    'location' => $this->getLocationFromIp($request->ip()),
                    'referer'   => $request->headers->get('referer'),
                    'route'     => optional($request->route())->getName(),
                    'url'       => $request->fullUrl(),
                    'method'    => $request->method(),
                    'session_id'=> session()->getId(),

                ])
                ->event('login')
                ->log('Logged in');

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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


    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user(); // capture first

        activity('logout')
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
                'device'     => $this->detectDevice($request),
                'browser'    => $this->detectBrowser($request),
                'os'         => $this->detectOS($request),
                'location' => $this->getLocationFromIp($request->ip()),
                'route'      => optional($request->route())->getName(),
                'url'        => $request->fullUrl(),
                'method'     => $request->method(),
                'session_id' => session()->getId(),
            ])
            ->event('logout')
            ->log('Logged out');
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
