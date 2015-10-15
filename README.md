# OxenTI Address API plugin for CakePHP 3

This plugin contains a package with API methods for managing Addresses on a CakePHP 3 application.

## Requirements

* CakePHP 3.0+

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require oxenti/address
```

## Configuration

In your app's `config/bootstrap.php` add:

```php
// In config/bootstrap.php
Plugin::load('Address');
```

or using cake's console:

```sh
./bin/cake plugin load Address
```

In your app's 'config/app.php' add this to your Datasources array:

```php
	'oxenti_address' => [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'ỳour_db_host',
        'username' => 'username',
        'password' => 'password',
        'database' => 'databse_name',
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'log' => false,
        'quoteIdentifiers' => false,
    ],
    'test_oxenti_address' => [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'ỳour_db_host',
        'username' => 'username',
        'password' => 'password',
        'database' => 'databse_name',
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'log' => false,
        'quoteIdentifiers' => false,
    ],
```

### Configuration files
Move the 'address.php' config file from the plugin's config folder to your app's config folder.

On your app's 'bootstrap.php' add the address configuration file:
```php
    ...
    try {
	    Configure::config('default', new PhpConfig());
	    Configure::load('app', 'default', false);
	} catch (\Exception $e) {
	    die($e->getMessage() . "\n");
	}

	Configure::load('address', 'default');
    ...
```

## Using extrenal Associations
If you want to associate the Address table with other tables on your application, use the address.php configuration file setting the 'relations' entry to your needs.

