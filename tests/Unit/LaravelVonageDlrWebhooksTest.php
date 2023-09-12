<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Renatoxm\LaravelVonageDlrWebhooks\Model\LaravelVonageDlrWebhooksModel;
use Renatoxm\LaravelVonageDlrWebhooks\Tests\TestCase;

class LaravelVonageDlrWebhooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_correct_table_name()
    {
        config(['laravel-vonage-dlr-webhooks.log.table_name' => 'test_table_name']);

        $this->assertEquals('test_table_name', (new LaravelVonageDlrWebhooksModel())->getTable());

        $this->assertEquals('dummy_table', (new DummyLaravelVonageDlrWebhooksModel())->getTable());
    }

    /** @test */
    public function it_can_create_a_vonage_webhook()
    {
        $payload = [
            'delivered' => 'delivered',
            'FirstOpen' => true,
        ];

        LaravelVonageDlrWebhooksModel::forceCreate([
            'err_code' => 0,
            'message_timestamp' => '2023-08-25 16:54:36',
            'message_id' => 'd679f9e5-6f1e-494b-91f1-22c7d131aaad',
            'msisdn' => '5521993415455',
            'network_code' => '72402',
            'price' => '0,04870000',
            'scts' => '2308251154',
            'status' => 'delivered',
            'to' => '5521993415455',
        ]);

        $this->assertCount(1, LaravelVonageDlrWebhooksModel::all());

        tap(LaravelVonageDlrWebhooksModel::first(), function ($webhook) {
            $this->assertEquals('d679f9e5-6f1e-494b-91f1-22c7d131aaad', $webhook->message_id);
            $this->assertEquals('delivered', $webhook->status);
        });
    }

    /** @test */
    public function it_can_create_a_vonage_webhook_from_payload()
    {
        $payload = [
            'err_code' => 0,
            'message_timestamp' => '2023-08-25 16:54:36',
            'message_id' => 'd679f9e5-6f1e-494b-91f1-22c7d131aaad',
            'msisdn' => '5521993415455',
            'network_code' => '72402',
            'price' => '0,04870000',
            'scts' => '2308251154',
            'status' => 'delivered',
            'to' => '5521993415455',
        ];

        LaravelVonageDlrWebhooksModel::createOrNewFromPayload($payload);

        $this->assertCount(1, LaravelVonageDlrWebhooksModel::all());
        tap(LaravelVonageDlrWebhooksModel::first(), function ($webhook) {
            $this->assertEquals('d679f9e5-6f1e-494b-91f1-22c7d131aaad', $webhook->message_id);
            $this->assertEquals('delivered', $webhook->status);
            $this->assertEquals('5521993415455', $webhook->to);
        });
    }

    /** @test */
    public function it_returns_a_new_vonage_webhook_instance_when_logging_to_database_is_disabled()
    {
        config(['laravel-vonage-dlr-webhooks.log.enabled' => false]);

        $payload = [
            'err_code' => 0,
            'message_timestamp' => '2023-08-25 16:54:36',
            'message_id' => 'd679f9e5-6f1e-494b-91f1-22c7d131aaad',
            'msisdn' => '5521993415455',
            'network_code' => '72402',
            'price' => '0,04870000',
            'scts' => '2308251154',
            'status' => 'delivered',
            'to' => '5521993415455',
        ];

        $webhook = LaravelVonageDlrWebhooksModel::createOrNewFromPayload($payload);

        dump($webhook);

        $this->assertCount(0, LaravelVonageDlrWebhooksModel::all());

        $this->assertEquals('d679f9e5-6f1e-494b-91f1-22c7d131aaad', $webhook->message_id);
        $this->assertEquals('delivered', $webhook->status);
        $this->assertEquals('5521993415455', $webhook->to);
    }
}

class DummyLaravelVonageDlrWebhooksModel extends LaravelVonageDlrWebhooksModel
{
    protected $table = 'dummy_table';
}