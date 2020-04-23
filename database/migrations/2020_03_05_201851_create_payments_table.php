<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('dosa_number', 255)->nullable();
            $table->string('invoice_number', 255)->nullable();
            $table->date('dosa_date')->nullable();
            $table->string('number')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('reference', 255);
            $table->text('description');
            $table->enum('status', array('PENDING', 'APPROVED', 'CANCELLED', 'REJECTED','REVISED1','REVISED2'))->default('PENDING');
            $table->enum('currency', array('BS', 'USD'))->default('USD');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('plane_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
