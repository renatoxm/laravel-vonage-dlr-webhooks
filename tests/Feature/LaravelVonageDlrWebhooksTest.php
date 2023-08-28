<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Renatoxm\LaravelVonageDlrWebhooks\Events\LaravelVonageDlrWebhooksCalled;
use Renatoxm\LaravelVonageDlrWebhooks\Model\LaravelVonageDlrWebhooksModel;
use Renatoxm\LaravelVonageDlrWebhooks\Tests\TestCase;

class LaravelVonageDlrWebhooksTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    protected function validPayload($attributes = [])
    {
        return array_merge([
            'err-code' => 0,
            'message-timestamp' => '2023-08-25 16:54:36',
            'messageId' => 'd679f9e5-6f1e-494b-91f1-22c7d131aaad',
            'msisdn' => '5521993415455',
            'network-code' => '72402',
            'price' => '0,04870000',
            'scts' => '2308251154',
            'status' => 'delivered',
            'to' => '5521993415455',
        ], $attributes);
    }

    /** @test */
    public function it_can_handle_a_valid_request()
    {
        $payload = [
            'err-code' => 0,
            'message-timestamp' => '2023-08-25 16:54:36',
            'messageId' => 'd679f9e5-6f1e-494b-91f1-22c7d131aaad',
            'msisdn' => '5521993415455',
            'network-code' => '72402',
            'price' => '0,04870000',
            'scts' => '2308251154',
            'status' => 'delivered',
            'to' => '5521993415455',
        ];

        $response = $this->postJson('/api/webhooks/vonage/dlr', $payload);

        $response->assertStatus(204);

        $this->assertCount(1, LaravelVonageDlrWebhooksModel::all());

        tap(LaravelVonageDlrWebhooksModel::first(), function ($log) {
            $this->assertEquals('0', $log->err_code);
            $this->assertEquals('2023-08-25 16:54:36', $log->message_timestamp);
            $this->assertEquals('d679f9e5-6f1e-494b-91f1-22c7d131aaad', $log->message_id);
            $this->assertEquals('5521993415455', $log->msisdn);
            $this->assertEquals('72402', $log->network_code);
            $this->assertEquals('0,04870000', $log->price);
            $this->assertEquals('2308251154', $log->scts);
            $this->assertEquals('delivered', $log->status);
            $this->assertEquals('5521993415455', $log->to);
        });

        Event::assertDispatched(LaravelVonageDlrWebhooksCalled::class, function ($event) {
            return $event->message_id === 'd679f9e5-6f1e-494b-91f1-22c7d131aaad'
                && $event->status === 'delivered'
                && $event->to === '5521993415455';
        });

        Event::assertDispatched('webhook.vonage: delivered', function ($event, $eventPayload) {
            if (! $eventPayload instanceof LaravelVonageDlrWebhooksCalled) {
                return false;
            }

            return $eventPayload->message_id === 'd679f9e5-6f1e-494b-91f1-22c7d131aaad'
                && $eventPayload->status === 'delivered'
                && $eventPayload->to === '5521993415455';
        });
    }

    /** @test */
    public function it_does_not_log_to_the_database_if_this_is_configured_to_be_disabled()
    {
        config(['laravel-vonage-dlr-webhooks.log.enabled' => false]);

        $response = $this->postJson('/api/webhooks/vonage/dlr', $this->validPayload());

        $response->assertStatus(204);
        $this->assertCount(0, LaravelVonageDlrWebhooksModel::all());
    }

    /** @test */
    public function it_does_not_log_to_the_database_if_the_record_type_is_configured_to_be_excepted()
    {
        config(['laravel-vonage-dlr-webhooks.log.except' => ['expired']]);

        $response = $this->postJson('/api/webhooks/vonage/dlr', $this->validPayload([
            'status' => 'expired',
        ]));

        $response->assertStatus(204);
        $this->assertCount(0, LaravelVonageDlrWebhooksModel::all());
    }
}
