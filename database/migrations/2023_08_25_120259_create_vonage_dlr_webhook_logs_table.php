<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVonageDlrWebhookLogsTable extends Migration
{
    /** @var string */
    protected $table_name;

    public function __construct()
    {
        $this->table_name = config('laravel-vonage-dlr-webhooks.log.table_name', config('laravel-vonage-dlr-webhooks.log.table'));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('err_code');
            $table->dateTime('message_timestamp');
            $table->string('message_id');
            $table->string('msisdn');
            $table->string('network_code');
            $table->decimal('price', 18, 8);
            $table->string('scts');
            $table->string('status');
            $table->string('to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table_name);
    }
}
