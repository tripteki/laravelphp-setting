<h1 align="center">Setting</h1>

This package provides is an implementation of setting in repository pattern for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require tripteki/laravelphp-setting
```

How to use it :

- Put `Tripteki\Setting\Providers\SettingServiceProvider` to service provider configuration list.

- Put `Tripteki\Setting\Traits\SettingTrait` to auth's provider model.

- Migrate.

```
$ php artisan migrate
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

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
