<?php

namespace Jamal1973\DomainLogin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DomainLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view(config('domain-login.view', 'domain-login::login'));
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $guard = config('domain-login.guard', 'web');
        $usernameAttribute = config('domain-login.username_attribute', 'samaccountname');

        $attempt = [
            $usernameAttribute => $credentials['username'],
            'password' => $credentials['password'],
        ];

        if (!Auth::guard($guard)->attempt($attempt)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', config('domain-login.messages.invalid_credentials'));
        }

        $user = Auth::guard($guard)->user();

        if (!$this->userIsAuthorized($user)) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', config('domain-login.messages.unauthorized'));
        }

        $request->session()->regenerate();

        return redirect()->intended(config('domain-login.redirect_to', '/dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard(config('domain-login.guard', 'web'))->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function userIsAuthorized($user): bool
    {
        $allowedGroups = (array) config('domain-login.allowed_groups', []);

        if ($allowedGroups === []) {
            return true;
        }

        $groupAttribute = config('domain-login.group_attribute', 'memberOf');
        $userGroups = $this->normalizeGroups($user?->getAttribute($groupAttribute));

        foreach ($userGroups as $group) {
            foreach ($allowedGroups as $allowedGroup) {
                if ($allowedGroup !== '' && stripos((string) $group, $allowedGroup) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function normalizeGroups(mixed $groups): array
    {
        if (is_array($groups)) {
            return array_values(array_filter($groups));
        }

        if ($groups === null || $groups === '') {
            return [];
        }

        return [$groups];
    }
}
