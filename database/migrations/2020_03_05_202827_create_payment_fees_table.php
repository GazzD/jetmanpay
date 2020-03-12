<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_fees', function (Blueprint $table) {
            $table->id();
            $table->string('old_code', 255)->nullable();
            $table->string('concept', 255);
            $table->decimal('amount', 10, 2);
            $table->decimal('conversion_fee', 10, 2)->nullable();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_fees');
    }
}
