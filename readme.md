Laravel Deliverable Plugin
==========================

[![License](https://img.shields.io/github/license/ironsharkde/laravel-deliverable.svg)](https://packagist.org/packages/ironshark/laravel-deliverable)
[![Downloads](https://img.shields.io/packagist/dt/ironshark/laravel-deliverable.svg)](https://packagist.org/packages/ironshark/laravel-deliverable)
[![Version-stable](https://img.shields.io/packagist/v/ironshark/laravel-deliverable.svg)](https://packagist.org/packages/ironshark/laravel-deliverable)

Trait for Laravel Eloquent models to allow easy implementation of a "deliverable" feature.
Can be used for reading lists or shipments.

## Composer Install

```sh
composer require ironshark/laravel-deliverable
```

```bash
php artisan vendor:publish --provider="IronShark\Deliverable\DeliverableServiceProvider"
php artisan migrate
```

## Setup your models

```php
class Article extends \Illuminate\Database\Eloquent\Model {
    use IronShark\Deliverable\DeliverableTrait;
}
```

## Sample Usage

```php
$file = File::create(['name' => 'filename']);
$admin = \App\User::where('name', 'admin')->first();
    
$file->deliver(\App\User::all()); // deliver file to all users
$file->deliver(1, 5); // deliver files to user with id `1`, priority = `5`

$file->setDelivered(); // mark file as deliverd to logged in user
$file->setDelivered(true, $admin); // mark file as deliverd to admin user

$file->isDelivered(); // check whether current item was delivered to current user (`true`|`false`)
$file->isDelivered($admin); // check whether current item was delivered to admin

$file->cancelDelivery(); // remove delivery tasks for current user
$file->cancelDelivery($admin); // remove delivery tasks for admin
$file->cancelDelivery([1,5,9,8]); // remove delivery tasks for specified user ids
```

## DataBase sturcture

| name             | datatype       | example               |
|------------------|----------------|-----------------------|
| id               | `INT`          | `1`                   |
| deliverable_id   | `INT`          | `34`                  |
| deliverable_type | `VARCHAR(256)` | `App\File`            |
| user_id          | `INT`          | `25`                  |
| priority         | `TINYINT`      | `2`                   |
| created_at       | `DATETIME`     | `2015-07-20 09:19:41` |
| delivered_at     | `DATETIME`     | `2015-07-20 09:19:41` |
