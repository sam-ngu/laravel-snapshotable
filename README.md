# Take a snapshot of a Laravel model. Record model information at a given time.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/acadea/laravel-snapshotable.svg?style=flat-square)](https://packagist.org/packages/acadea/laravel-snapshotable)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/acadea/laravel-snapshotable/run-tests?label=tests)](https://github.com/acadea/laravel-snapshotable/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/acadea/laravel-snapshotable/Check%20&%20fix%20styling?label=code%20style)](https://github.com/acadea/laravel-snapshotable/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/acadea/laravel-snapshotable.svg?style=flat-square)](https://packagist.org/packages/acadea/laravel-snapshotable)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us



## Installation

You can install the package via composer:

```bash
composer require acadea/laravel-snapshotable
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Acadea\Snapshot\SnapshotServiceProvider" --tag="laravel-snapshotable-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Acadea\Snapshot\SnapshotServiceProvider" --tag="laravel-snapshotable-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

Apply the Snapshotable trait to any model.

```php

class Post extends \Illuminate\Database\Eloquent\Model {

    use Acadea\Snapshot\Traits\Snapshotable;
    // ...
}

```

Then we can take a snapshot by:

```php

/** @var \Acadea\Snapshot\Tests\Models\Post $post */
$snapshot = $post->takeSnapshot();


```


### Create a Custom Snapshot Model

Feel free to extend the Snapshot base model if you need any further customisation. However, you will need to create new migration files.

```php

class TransactionSnapshot extends \Acadea\Snapshot\Models\Snapshot {
  // ...
}

```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [sam-ngu](https://github.com/sam-ngu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
