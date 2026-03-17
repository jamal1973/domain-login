<?php

use LdapRecord\Models\ActiveDirectory\User as LdapUser;

return [
    'register_routes' => (bool) env('DOMAIN_LOGIN_REGISTER_ROUTES', true),

    'middleware' => ['web'],

    'guard' => env('DOMAIN_LOGIN_GUARD', 'web'),
    'provider' => env('DOMAIN_LOGIN_PROVIDER', 'users'),
    'view' => 'domain-login::login',

    'login_path' => env('DOMAIN_LOGIN_PATH', 'login'),
    'logout_path' => env('DOMAIN_LOGOUT_PATH', 'logout'),
    'redirect_to' => env('DOMAIN_LOGIN_REDIRECT_TO', '/dashboard'),

    'username_attribute' => env('DOMAIN_LOGIN_USERNAME_ATTRIBUTE', 'samaccountname'),
    'group_attribute' => env('DOMAIN_LOGIN_GROUP_ATTRIBUTE', 'memberOf'),
    'allowed_groups' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('DOMAIN_LOGIN_ALLOWED_GROUPS', ''))
    ))),

    'messages' => [
        'invalid_credentials' => env('DOMAIN_LOGIN_MESSAGE_INVALID', 'Bledny login lub haslo.'),
        'unauthorized' => env('DOMAIN_LOGIN_MESSAGE_UNAUTHORIZED', 'Brak uprawnien do logowania.'),
    ],

    'branding' => [
        'badge' => env('DOMAIN_LOGIN_BRAND_BADGE', 'Panel wewnetrzny'),
        'description' => env(
            'DOMAIN_LOGIN_BRAND_DESCRIPTION',
            'Wewnetrzny panel dzialu IT przeznaczony dla administratorow do obslugi systemow, zasobow i codziennych zadan operacyjnych.'
        ),
        'footer_suffix' => env('DOMAIN_LOGIN_BRAND_FOOTER', 'srodowisko wewnetrzne'),
        'status_chip' => env('DOMAIN_LOGIN_STATUS_CHIP', 'Dostep chroniony'),
        'form_subtitle' => env('DOMAIN_LOGIN_FORM_SUBTITLE', 'Wprowadz dane dostepowe, aby przejsc dalej.'),
    ],

    'login_points' => [
        [
            'icon' => 'bi-info-circle',
            'title' => 'Informacja',
            'text' => 'Do systemu moga zalogowac sie wylacznie uzytkownicy posiadajacy wymagane uprawnienia.',
        ],
        [
            'icon' => 'bi-person-badge',
            'title' => 'Login domenowy',
            'text' => 'Uzyj loginu przypisanego do Twojego konta domenowego, aby rozpoczac prace w panelu.',
        ],
        [
            'icon' => 'bi-shield-check',
            'title' => 'Weryfikacja dostepu',
            'text' => 'Po poprawnym logowaniu system sprawdzi uprawnienia i otworzy dostep do panelu.',
        ],
    ],

    'user_model' => LdapUser::class,

    'ldap_connection' => env('LDAP_CONNECTION', 'default'),
    'ldap' => [
        'hosts' => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) env('LDAP_HOST', '127.0.0.1'))
        ))),
        'username' => env('LDAP_USERNAME'),
        'password' => env('LDAP_PASSWORD'),
        'port' => (int) env('LDAP_PORT', 389),
        'base_dn' => env('LDAP_BASE_DN'),
        'timeout' => (int) env('LDAP_TIMEOUT', 5),
        'use_ssl' => (bool) env('LDAP_SSL', false),
        'use_tls' => (bool) env('LDAP_TLS', false),
        'use_sasl' => (bool) env('LDAP_SASL', false),
        'logging' => (bool) env('LDAP_LOGGING', false),
    ],
];
