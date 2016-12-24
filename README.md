# VK Notifications Channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/vk.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/vk/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/vk)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/vk.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vk)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/vk/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vk/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/vk.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vk)

This package makes it easy to send notifications using [VK API](https://vk.com/dev/messages.send) with Laravel 5.3.

## Contents

- [Installation](#installation)
	- [Setting up the Vk service](#setting-up-the-Vk-service)
- [Usage](#usage)
	- [Available methods](#available-message-methods)
- [Changelog](#changelog)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

``` bash
composer require laravel-notification-channels/vk
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Vk\VkServiceProvider::class,
],
```

### Setting up the Vk service

Follow the [Standalone application](https://vk.com/dev/standalone) guide in order to create a VK Standalone application, and get Client ID and Client Secret.
Next, follow the [Client Application Authorization](https://vk.com/dev/auth_mobile) guide in order to get VK Token.

Next we need to add this token to our Laravel configurations. Create a new VK section inside `config/services.php` and place the page token there:

```php
// config/services.php
...
'vk-api' => [
    'token' => env('VK_TOKEN', 'YOUR TOKEN HERE')
],
...
```

## Usage

Send a basic text message to a user
``` php
use NotificationChannels\Vk\VkChannel;
use NotificationChannels\Vk\VkMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [VkChannel::class];
    }

    public function toVk($notifiable)
    {
        return VkMessage::create()
            ->to(USER_ID)
            ->content('Test message here');
    }
}
```

### Available methods

- `to($userId)`: (int) Recipient's User ID.
- `content('')`: (string) Notification message.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email yaroslav.molchan@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Yaroslav Molchan](https://github.com/YaroslavMolchan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
