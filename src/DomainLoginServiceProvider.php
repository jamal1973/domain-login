<?php

namespace Jamal1973\DomainLogin;

use Illuminate\Support\ServiceProvider;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class DomainLoginServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/domain-login.php', 'domain-login');

        $this->configureLdapConnection();
        $this->configureAuthentication();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'domain-login');

        if (config('domain-login.register_routes', true)) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        $this->publishes([
            __DIR__ . '/../config/domain-login.php' => config_path('domain-login.php'),
        ], 'domain-login-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/domain-login'),
        ], 'domain-login-views');
    }

    protected function configureLdapConnection(): void
    {
        $connection = config('domain-login.ldap_connection', 'default');
        $ldapConfig = config('domain-login.ldap', []);

        config([
            'ldap.default' => $connection,
            'ldap.connections' => array_merge(config('ldap.connections', []), [
                $connection => [
                    'hosts' => $ldapConfig['hosts'] ?? ['127.0.0.1'],
                    'username' => $ldapConfig['username'] ?? null,
                    'password' => $ldapConfig['password'] ?? null,
                    'port' => $ldapConfig['port'] ?? 389,
                    'base_dn' => $ldapConfig['base_dn'] ?? null,
                    'timeout' => $ldapConfig['timeout'] ?? 5,
                    'use_ssl' => $ldapConfig['use_ssl'] ?? false,
                    'use_tls' => $ldapConfig['use_tls'] ?? false,
                    'use_sasl' => $ldapConfig['use_sasl'] ?? false,
                    'sasl_options' => [],
                ],
            ]),
            'ldap.logging' => $ldapConfig['logging'] ?? false,
            'ldap.cache.enabled' => false,
        ]);
    }

    protected function configureAuthentication(): void
    {
        $guard = config('domain-login.guard', 'web');
        $provider = config('domain-login.provider', 'users');
        $userModel = config('domain-login.user_model', LdapUser::class);

        $providers = config('auth.providers', []);
        $guards = config('auth.guards', []);

        $providers[$provider] = [
            'driver' => 'ldap',
            'model' => $userModel,
        ];

        $guards[$guard] = [
            'driver' => 'session',
            'provider' => $provider,
        ];

        config([
            'auth.providers' => $providers,
            'auth.guards' => $guards,
            'auth.defaults.guard' => $guard,
        ]);
    }
}
