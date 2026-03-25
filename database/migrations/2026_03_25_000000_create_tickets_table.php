<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salesforce_id')->nullable()->default(null);
            $table->integer('customer_id');
            $table->string('type', 24);
            $table->string('subject', 256);
            $table->text('content');
            $table->string('status', 20);
            $table->dateTime('last_salesforce_sync')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
