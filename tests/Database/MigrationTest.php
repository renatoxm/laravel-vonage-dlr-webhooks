<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Tests\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Renatoxm\LaravelVonageDlrWebhooks\Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_runs_the_migrations()
    {
        $columns = Schema::getColumnListing('vonage_dlr_webhook_logs');

        $this->assertEquals([
            'id',
            'err_code',
            'message_timestamp',
            'message_id',
            'msisdn',
            'network_code',
            'price',
            'scts',
            'status',
            'to',
            'created_at',
            'updated_at',
        ], $columns);
    }
}
