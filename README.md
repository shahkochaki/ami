# Ami

Easy control via [asterisk](http://www.asterisk.org/) manager interface (AMI).

Installation and configuration
----------------

You must create your own [Ami User](https://www.asteriskguru.com/tutorials/manager_conf.html) before installation

Also check that port 5038 (default-changeable) is available.

Make sure that the extension socket is active.

To install as a [composer](https://getcomposer.org/) package to be used with Laravel 5 and above, simply run:


```sh
composer require "shahkochaki/ami" or composer require "shahkochaki/ami:dev-master"
```

Once it's installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
'providers' => [
  \shahkochaki\Ami\Providers\AmiServiceProvider::class,
]
```

Then publish assets with `php artisan vendor:publish`. This will add the file `config/ami.php`.

Usage
----------------
**Connection options**

You are can specify connection parameters for each command.

| Option     | Description                  |
| ---------  | ---------------------------- |
| --host     | Asterisk AMI server host     |
| --port     | Asterisk AMI server port     |
| --username | Asterisk AMI server username |
| --secret   | Asterisk AMI server secret   |
| --range    | Default number range, for example 100,300   |

**Listen ami events**

```sh
php artisan ami:listen
```

```php
Artisan::call('ami:listen');
```
If would you like to see event log in the console use *monitor* option
```sh
php artisan ami:listen --monitor
```

**Send ami action**

```sh
php artisan ami:action <action> --arguments=<key>:<value> --arguments=<key>:<value> ...
```

```php
Artisan::call('ami:action', [
    'action'      => <action>,
    '--arguments' => [
        <key> => <value>
        ...
    ]
]);
```

**Send sms messages using chan dongle**

```sh
php artisan ami:dongle:sms <phone> <message> <device?>
```

```php
Artisan::call('ami:dongle:sms', [
    'phone'   => <phone>,
    'message' => <message>,
    'device'  => <device?>,
]);
```
For sending long messages use *pdu* mode.
```sh
php artisan ami:dongle:sms <phone> <message> <device?> --pdu
```

```php
Artisan::call('ami:dongle:sms', [
    'phone'   => <phone>,
    'message' => <message>,
    'device'  => <device?>,
    '--pdu'   => true,
]);
```

Argument device is not required.

**Send ussd commands using chan dongle**

```sh
php artisan ami:dongle:ussd <device> <ussd>
```

```php
Artisan::call('ami:dongle:ussd', [
    'device' => <device>,
    'ussd'   => <ussd>,
]);
```
**Send ami commands**

This command started cli interface for ami. Command attribute is optional.
```sh
php artisan ami:cli [command]
```
Close cli interface after sending command.
```sh
php artisan ami:cli [command] --autoclose
```

```php
Artisan::call('ami:cli', [
    'command'     => [command],
    '--autoclose' => true,
]);
```

**Without Laravel**

```sh
php ./vendor/bin/ami ami:listen --host=127.0.0.1 --port=5038 --username=username --secret=secret --monitor
```