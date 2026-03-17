# Instalacja

## Szybki start

### Packagist

```bash
composer require jamal1973/domain-login
```

### GitHub VCS

Dodaj do `composer.json` projektu:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/jamal1973/domain-login.git"
    }
  ]
}
```

Nastepnie:

```bash
composer require jamal1973/domain-login:dev-main
```

## Publikacja configu i widokow

```bash
php artisan vendor:publish --tag=domain-login-config
php artisan vendor:publish --tag=domain-login-views
```

## Konfiguracja `.env`

Skopiuj ustawienia z pliku `.env.example` pakietu do swojego projektu i uzupelnij dane LDAP.
