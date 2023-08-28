<?php
declare(strict_types=1);

namespace Renatoxm\LaravelVonageDlrWebhooks\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LaravelVonageDlrWebhooksModel extends Model
{
    /** @var string|null */
    const UPDATED_AT = null;

    /** @var array */
    protected $casts = [
        'payload' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('laravel-vonage-dlr-webhooks.log.table_name'));
        }

        parent::__construct($attributes);
    }

    public static function createOrNewFromPayload(array $payload): self
    {
        $payload = collect($payload);

        $model = (new static )->forceFill([
            'err_code' => $payload->get('err_code'),
            'message_timestamp' => $payload->get('message_timestamp'),
            'message_id' => $payload->get('message_id'),
            'msisdn' => $payload->get('msisdn'),
            'network_code' => $payload->get('network_code'),
            'price' => $payload->get('price'),
            'scts' => $payload->get('scts'),
            'status' => $payload->get('status'),
            'to' => $payload->get('to')
        ]);

        if (config('laravel-vonage-dlr-webhooks.log.enabled') && !collect(config('laravel-vonage-dlr-webhooks.log.except'))->contains($payload->get('status'))) {
            $model->save();
        }

        return $model;
    }
}
