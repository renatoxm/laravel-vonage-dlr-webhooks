# LaravelVonageDlrWebhooks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Handle [Vonage](https://developer.vonage.com/en/messaging/sms/guides/delivery-receipts) DLR (delivery receipt) SMS webhooks in Laravel php framework. Take a look at [contributing.md](contributing.md) to see a to do list.

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

## Usage

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

This package is highly inspired by:

- [laravel-vonage-dlr-hooks](https://github.com/ankurk91/laravel-vonage-dlr-hooks)
- [laravel-stripe-webhooks](https://github.com/spatie/laravel-stripe-webhooks)

## License

MIT. Please see the [license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/renatoxm/laravel-vonage-dlr-webhooks.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/renatoxm/laravel-vonage-dlr-webhooks.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/renatoxm/laravel-vonage-dlr-webhooks/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield
[link-packagist]: https://packagist.org/packages/renatoxm/laravel-vonage-dlr-webhooks
[link-downloads]: https://packagist.org/packages/renatoxm/laravel-vonage-dlr-webhooks
[link-travis]: https://travis-ci.org/renatoxm/laravel-vonage-dlr-webhooks
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/renatoxm
[link-contributors]: ../../contributors
