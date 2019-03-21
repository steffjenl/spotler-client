# spotler-client
[![Build Status](https://travis-ci.org/steffjenl/spotler-client.svg?branch=master)](https://travis-ci.org/steffjenl/spotler-client)

PHP Client for Spotler (spotler.nl) with support for Laravel 5.5 and higher

# Installation

Install the package using composer:

```bash
composer require steffjenl/spotler-client
```

On Laravel versions before 5.5 you also need to add the service provider to `config/app.php` manually:

```php
    Spotler\SpotlerServiceProvider::class,
```

Then add this in `config/services.php`:

```php
        'spotler' => [
            'consumerKey'         => env('SPOTLER_CONSUMERKEY'),
            'consumerSecret'      => env('SPOTLER_CONSUMERSECRET'),
        ],
```

Finally, add the fields `SPOTLER_CONSUMERKEY`, `SPOTLER_CONSUMERSECRET` to your `.env` file with the appropriate credentials.