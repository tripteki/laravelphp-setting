<h1 align="center">Setting</h1>

This package provides implementation of setting in repository pattern for Lumen and Laravel besides REST API starterpack of admin management with no intervention to codebase and keep clean.

Getting Started
---

Installation :

```
$ composer require tripteki/laravelphp-setting
```

How to use it :

- Put `Tripteki\Setting\Providers\SettingServiceProvider` to service provider configuration list.

- Put `Tripteki\Setting\Providers\SettingServiceProvider::ignoreMigrations()` into `register` provider, then publish migrations file into your project's directory with running (optionally) :

```
php artisan vendor:publish --tag=tripteki-laravelphp-setting-migrations
```

- Migrate.

```
$ php artisan migrate
```

- Publish tests file into your project's directory with running (optionally) :

```
php artisan vendor:publish --tag=tripteki-laravelphp-setting-tests
```

- Sample :

```php
use Tripteki\Setting\Contracts\Repository\Admin\ISettingRepository as ISettingAdminRepository;
use Tripteki\Setting\Contracts\Repository\ISettingRepository;

$settingAdminRepository = app(ISettingAdminRepository::class);

// $settingAdminRepository->create([ "key" => "key", "value" => "...", ]); //
// $settingAdminRepository->delete("key"); //
// $settingAdminRepository->update("key", [ "value" => "...", ]); //
// $settingAdminRepository->get("key"); //
// $settingAdminRepository->all(); //

$repository = app(ISettingRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->setup("key", "value"); //
// $repository->setdown("key"); //
// $repository->all(); //
```

- Generate swagger files into your project's directory with putting this into your annotation configuration (optionally) :

```
base_path("app/Http/Controllers/Setting")
```

```
base_path("app/Http/Controllers/Admin/Setting")
```

Usage
---

`php artisan adminer:install:setting`

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
