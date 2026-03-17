# jamal1973/domain-login

Gotowy pakiet Laravel do logowania domenowego / LDAP z:

- ekranem logowania
- kontrolerem auth
- automatyczna konfiguracja LDAP i auth
- sprawdzaniem grup AD / LDAP
- brandingiem opartym o `APP_NAME`

## Wymagania

- PHP 8.1+
- Laravel 10 lub 11
- LDAP / Active Directory obslugiwane przez `directorytree/ldaprecord-laravel`

## Instalacja

### Opcja 1. Packagist

Po dodaniu pakietu do Packagist:

```bash
composer require jamal1973/domain-login
```

### Opcja 2. GitHub VCS

Jesli pakiet nie jest jeszcze na Packagist, dodaj repozytorium do `composer.json` projektu:

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

## Po instalacji

Opcjonalnie opublikuj config i widoki:

```bash
php artisan vendor:publish --tag=domain-login-config
php artisan vendor:publish --tag=domain-login-views
```

Skopiuj zmienne z pliku `.env.example` do `.env` projektu i uzupelnij je swoimi danymi.

## Minimalne zmienne `.env`

```env
APP_NAME="AdminPanel"

LDAP_CONNECTION=default
LDAP_HOST=dc01.twojadomena.local,dc02.twojadomena.local
LDAP_PORT=389
LDAP_BASE_DN="DC=twojadomena,DC=local"
LDAP_USERNAME="CN=ldap-bind,OU=Service,DC=twojadomena,DC=local"
LDAP_PASSWORD="tajnehaslo"
LDAP_TIMEOUT=5
LDAP_SSL=false
LDAP_TLS=false
LDAP_SASL=false
LDAP_LOGGING=false

DOMAIN_LOGIN_ALLOWED_GROUPS="CN=G IT ADMINS,OU=Groups,DC=twojadomena,DC=local"
DOMAIN_LOGIN_REDIRECT_TO=/dashboard
DOMAIN_LOGIN_PATH=login
DOMAIN_LOGOUT_PATH=logout
```

## Jak dziala autoryzacja

Pakiet:

- loguje uzytkownika po atrybucie `samaccountname`
- pobiera grupy z atrybutu `memberOf`
- porownuje je z `DOMAIN_LOGIN_ALLOWED_GROUPS`

Jesli `DOMAIN_LOGIN_ALLOWED_GROUPS` jest puste, logowanie jest dozwolone dla kazdego poprawnie uwierzytelnionego uzytkownika LDAP.

## Konfiguracja niestandardowa

Mozesz zmienic przez `.env` lub opublikowany `config/domain-login.php`:

- `DOMAIN_LOGIN_REGISTER_ROUTES`
- `DOMAIN_LOGIN_PATH`
- `DOMAIN_LOGOUT_PATH`
- `DOMAIN_LOGIN_REDIRECT_TO`
- `DOMAIN_LOGIN_USERNAME_ATTRIBUTE`
- `DOMAIN_LOGIN_GROUP_ATTRIBUTE`
- `DOMAIN_LOGIN_BRAND_BADGE`
- `DOMAIN_LOGIN_BRAND_DESCRIPTION`
- `DOMAIN_LOGIN_BRAND_FOOTER`
- `DOMAIN_LOGIN_STATUS_CHIP`
- `DOMAIN_LOGIN_FORM_SUBTITLE`

## Uwagi wdrozeniowe

- pakiet zaklada standardowy guard sesyjny Laravel
- domyslnie rejestruje trasy `login`, `login.post`, `logout`
- jesli masz juz wlasne trasy auth, ustaw `DOMAIN_LOGIN_REGISTER_ROUTES=false` i podepnij kontroler recznie
- branding widoku bierze nazwe z `APP_NAME`
