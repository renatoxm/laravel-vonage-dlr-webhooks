<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Renatoxm\LaravelVonageDlrWebhooks\Events\LaravelVonageDlrWebhooksCalled;
use Renatoxm\LaravelVonageDlrWebhooks\Tests\TestCase;

class PLaravelVonageDlrWebhooksEventMappingTest extends TestCase
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
            'to' => '5521993415455'
        ], $attributes);
    }

    /** @test */
    public function when_an_event_is_configured_to_be_mapped_to_a_dedicated_class_we_will_fire_that_event()
    {
        config(['laravel-vonage-dlr-webhooks.events' => ['some_status' => MappedFakeEvent::class]]);

        $response = $this->postJson('/api/webhooks/vonage/dlr', $this->validPayload([
            'status' => 'some_status',
        ]));

        Event::assertDispatched(MappedFakeEvent::class, function ($event) {
            if (!$event->webhook instanceof LaravelVonageDlrWebhooksCalled) {
                return false;
            }

            return true;
        });
    }
}

class MappedFakeEvent
{
    public $webhook;

    public function __construct(LaravelVonageDlrWebhooksCalled $webhook)
    {
        $this->webhook = $webhook;
    }
}
