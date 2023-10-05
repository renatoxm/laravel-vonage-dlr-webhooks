# LaravelVonageDlrWebhooks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

Handle [Vonage](https://developer.vonage.com/en/messaging/sms/guides/delivery-receipts) DLR (delivery receipt) SMS webhooks in Laravel php framework. Take a look at [contributing.md](contributing.md) to see a to do list.

When you make a successful request to the SMS API, it returns an array of message objects, one for each message. Ideally these will have a status of 0, indicating success. But this does not mean that your message has reached your recipients. It only means that your message has been successfully queued for sending.

Vonage's adaptive routing then identifies the best carrier for your message. When the selected carrier has delivered the message, it returns a delivery receipt (DLR).

To receive DLRs in your application, you must provide a webhook for Vonage to send them to. Alternatively, you could use the Reports API to periodically download your records, including per-message delivery status.

## Installation

Via Composer

```bash
composer require renatoxm/laravel-vonage-dlr-webhooks
```

Publish the config file with:

```bash
php artisan vendor:publish --provider="Renatoxm\LaravelVonageDlrWebhooks\LaravelVonageDlrWebhooksServiceProvider"
```

This package will log all incoming webhooks to the database by default.  
Run the migrations to create a `vonage_dlr_webhook_logs` table in the database:

```bash
php artisan migrate
```

## Setup DLR (delivery receipt) webhooks from Vonage

Create your account at [Nexmo](nexmo.com) and access the [dashboard API settings](https://dashboard.nexmo.com/settings).

Under SMS settings, choose SMS API, set the webhook format to `POST-JSON`, and configure Delivery receipts (DLR) webhooks URL like this:

`https://<you-domain.com>/api/webhooks/vonage/dlr`

`/api/webhooks/vonage/dlr` is the package's default endpoint.

> You may change the `/api/webhooks/vonage/dlr` endpoint to anything you like.  
> You can do this by changing the `path` key in the `config/laravel-vonage-dlr-webhooks.php` file.

## Events

Whenever a webhook call comes in, this package will fire a `LaravelVonageDlrWebhooksCalled` event.  
You may register an event listener in the `EventServiceProvider`:

```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    LaravelVonageDlrWebhooksCalled::class => [
        YourListener::class,
    ],
];
```

Example of a listener:

```php
<?php

namespace App\Listeners;

use Renatoxm\LaravelVonageDlrWebhooks\Events\LaravelVonageDlrWebhooksCalled;

class YourListener
{
    /**
     * Handle the event.
     *
     * @param  \Renatoxm\LaravelVonageDlrWebhooks\Events\LaravelVonageDlrWebhooksCalled  $event
     * @return void
     */
    public function handle(LaravelVonageDlrWebhooksCalled $event)
    {
        // Do your work here.
        // $event->err_code
        // $event->message_id
        // $event->msisdn
        // ...
    }
}

```

### Advanced configuration

You may optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Renatoxm\LaravelVonageDlrWebhooks\LaravelVonageDlrWebhooksServiceProvider" --tag="config"
```

Within the configuration file you may change the table name being used
or the Eloquent model being used to save log records to the database.

> If you want to use your own model to save the logs to the database you should extend
> the `Renatoxm\LaravelVonageDlrWebhooks\Model\LaravelVonageDlrWebhooksModel` class.

You can also exclude one or more event types from being logged to the database.  
Place the events you want to exclude under the `except` key:

```php
'log' => [
    ...
    'except' => [
        'open',
        ...
    ],
],
```

All webhook requests will be logged in the `vonage_dlr_webhook_logs` table.

## Change log

Please see the [changelog](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
composer test
```

## Contributing

Please see [contributing.md](CONTRIBUTING.md) for details and a todolist.

## Security

If you discover any security issue, please email `renatoxm[at]gmail[dot]com` instead of using the issue tracker.

## Useful Links

- [SMS Overview on Vonage](https://developer.vonage.com/en/messaging/sms/overview)
- [Enable Message Signing on Vonage](https://developer.vonage.com/en/blog/using-message-signatures-to-ensure-secure-incoming-webhooks-dr#enable-message-signing)
- [Delivery receipts](https://developer.vonage.com/en/messaging/sms/guides/delivery-receipts?source=messaging)

## Acknowledgment

This package is inspired by:

- [laravel-postmark-webhooks](https://github.com/renatoxm/laravel-postmark-webhooks)

forked from <https://github.com/mvdnbrk/laravel-postmark-webhooks>

## Credits

- [Renato Nabinger][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/renatoxm/laravel-vonage-dlr-webhooks.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/actions/workflow/status/renatoxm/laravel-vonage-dlr-webhooks/tests.yml?branch=main
[ico-style-ci]: https://styleci.io/repos/682953332/shield?branch=main
[ico-downloads]: https://img.shields.io/packagist/dt/renatoxm/laravel-vonage-dlr-webhooks.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/renatoxm/laravel-vonage-dlr-webhooks
[link-tests]: https://github.com/renatoxm/laravel-vonage-dlr-webhooks/actions/workflows/tests.yml
[link-style-ci]: https://styleci.io/repos/682953332
[link-downloads]: https://packagist.org/packages/renatoxm/laravel-vonage-dlr-webhooks
[link-author]: https://github.com/renatoxm
[link-contributors]: ../../contributors
