<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosa_items', function (Blueprint $table) {
            $table->id();
            $table->string('concept', 255);
            $table->decimal('amount', 12, 2);
            $table->integer('tax_fee')->nullable();
            $table->integer('step_number')->nullable();
            $table->string('payment_type')->nullable();
            $table->text('calculation_values')->nullable();
            $table->dateTime('arrival_date')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->foreignId('dosa_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('dosa_items');
    }
}
