# LaravelVonageDlrWebhooks

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

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
