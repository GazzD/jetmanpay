<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosas', function (Blueprint $table) {
            $table->id();
            $table->string('airplane')->nullable();
            $table->string('billing_code')->nullable();
            $table->string('closure_code')->nullable();
            $table->string('aperture_code')->nullable();
            $table->string('status_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('flight_type_id')->nullable();
            $table->date('aperture_date')->nullable();
            $table->string('aircraft_movement_id')->nullable();
            $table->integer('ton_max_weight')->nullable();
            $table->decimal('taxable_base_amount', 10, 2)->default(0);
            $table->decimal('exempt_vat_amount', 10, 2)->default(0);
            $table->decimal('total_dosa_amount', 10, 2)->default(0);
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('arrival_time')->nullable();
            $table->string('departure_flight_number')->nullable();
            $table->string('arrival_flight_number')->nullable();
            $table->string('terminal_code')->nullable();
            $table->string('flight_type')->nullable();
            
            // Client info
            $table->string('client_code')->nullable();
            $table->string('client_name')->nullable();
            
            // Extra data
            $table->string('url')->nullable();
            $table->enum('status', array('PENDING', 'APPROVED','REJECTED'))->default('PENDING');
            
            // Foreign keys
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('cascade');
            
            // Timestamps
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
        Schema::dropIfExists('dosas');
    }
}
