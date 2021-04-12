<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payer_id')->constrained('users')->onDelete('RESTRICT');
            $table->foreignId('operation_id')->constrained()->onDelete('RESTRICT');
            $table->string('authorization_code')->unique();
            $table->unsignedBigInteger('payee_id');
            $table->string('payee_type');
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
