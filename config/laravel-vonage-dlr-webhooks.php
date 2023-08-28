<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Vonage can post webhooks to.
    | Change this path to anything you like.
    |
    */
    'path' => '/api/webhooks/vonage/dlr',

    /*
    |--------------------------------------------------------------------------
    | Event Mapping
    |--------------------------------------------------------------------------
    |
    | This option allows you to map Vonage webhook
    | events status to your own object-based events.
    | Supported event statuses: "accepted", "delivered", "buffered", "expired", "failed",
    | "rejected", "unknown"
    |
    */
    'events' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Options
    |--------------------------------------------------------------------------
    |
    | Logging events to the database is enabled by default. You may set this
    | to false if you don't want to log the Vonage events to the database.
    |
    | You may specify one or more event status to be excluded from being
    | logged to the database. You can place them under the except key.
    |
    */
    'log' => [
        'enabled' => env('VONAGE_WEBHOOK_DLR_LOG_ENABLED', true),
        'model' => \Renatoxm\LaravelVonageDlrWebhooks\Model\LaravelVonageDlrWebhooksModel::class,
        'table_name' => 'vonage_dlr_webhook_logs',
        'except' => [
            //
        ],
    ],

];
