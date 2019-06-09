# Laravel Affili.net

[![Build Status](https://img.shields.io/travis/artisanry/Affilinet/master.svg?style=flat-square)](https://travis-ci.org/artisanry/Affilinet)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/artisanry/affilinet.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/artisanry/Affilinet.svg?style=flat-square)](https://github.com/artisanry/Affilinet/releases)
[![License](https://img.shields.io/packagist/l/artisanry/Affilinet.svg?style=flat-square)](https://packagist.org/packages/artisanry/Affilinet)

> A [Affilinet](https://affilinet.com) bridge for Laravel.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
$ composer require artisanry/affilinet
```

## Configuration

Laravel Affilinet requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Artisanry\Affilinet\AffilinetServiceProvider"
```

This will create a `config/affilinet.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

#### Default Connection Name

This option `default` is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `main`.

#### Affilinet Connections

This option `connections` is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like.

## Usage

#### AffilinetManager

This is the class of most interest. It is bound to the ioc container as `affilinet` and can be accessed using the `Facades\Affilinet` facade. This class implements the ManagerInterface by extending AbstractManager. The interface and abstract class are both part of [Graham Campbell's](https://github.com/GrahamCampbell) [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at that repository. Note that the connection class returned will always be an instance of `Affilinet\Affilinet`.

#### Facades\Affilinet

This facade will dynamically pass static method calls to the `affilinet` object in the ioc container which by default is the `AffilinetManager` class.

#### AffilinetServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

### Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
// You can alias this in config/app.php.
use Artisanry\Affilinet\Facades\Affilinet;

Affilinet::service('Inbox')->searchVoucherCodes([]);
// We're done here - how easy was that, it just works!
```

The Affilinet manager will behave like it is a `Affilinet\Affilinet`. If you want to call specific connections, you can do that with the connection method:

```php
use Artisanry\Affilinet\Facades\Affilinet;

// Writing this…
Affilinet::connection('main')->service('Inbox')->searchVoucherCodes($params);

// …is identical to writing this
Affilinet::service('Inbox')->searchVoucherCodes($params);

// and is also identical to writing this.
Affilinet::connection()->service('Inbox')->searchVoucherCodes($params);

// This is because the main connection is configured to be the default.
Affilinet::getDefaultConnection(); // This will return main.

// We can change the default connection.
Affilinet::setDefaultConnection('alternative'); // The default is now alternative.
```

If you prefer to use dependency injection over facades like me, then you can inject the manager:

```php
use Artisanry\Affilinet\AffilinetManager;

class Foo
{
    protected $affilinet;

    public function __construct(AffilinetManager $affilinet)
    {
        $this->affilinet = $affilinet;
    }

    public function bar($params)
    {
        $this->affilinet->service('Inbox')->searchVoucherCodes($params);
    }
}

App::make('Foo')->bar($params);
```

## Documentation

There are other classes in this package that are not documented here. This is because the package is a Laravel wrapper of [the official Affilinet package](https://github.com/affilinet/affilinet-php).

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@basecode.sh. All security vulnerabilities will be promptly addressed.

## Credits

This project exists thanks to all the people who [contribute](../../contributors).

## License

Mozilla Public License Version 2.0 ([MPL-2.0](./LICENSE)).
