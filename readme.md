# Laravel Deliverable Plugin

| name             | datatype     | example               |
|------------------|--------------|-----------------------|
| id               | INT          | `1`                   |
| deliverable_id   | INT          | `34`                  |
| deliverable_type | VARCHAR(256) | `App\File`            |
| user_id          | INT          | `25`                  |
| priority         | TINYINT      | `2`                   |
| created_at       | DATETIME     | `2015-07-20 09:19:41` |
| delivered_at     | DATETIME     | `2015-07-20 09:19:41` |

## Composer Install

```json
"repositories": [
	  {
		"type": "vcs",
		"url": "ssh://git@git.isdev.de:9022/ironshark/laravel-deliverable.git"
	  }
	],
```

```json
"require": {
	  "laravel/framework": "5.1.*",
      ...
	  "ironshark/laravel-deliverable": "dev-master"
	},
```

```bash
php artisan vendor:publish --provider="IronShark\Deliverable\DeliverableServiceProvider"
php artisan migrate
```

# Setup your models

```php
class Article extends \Illuminate\Database\Eloquent\Model {
    use IronShark\Deliverable\DeliverableTrait;
}
```

# Sample Usage

```php
    // add here some examples
```