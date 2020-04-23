<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('name', 255);
            $table->enum('currency', ['EU','USD','BS'])->default('BS');
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('rif', 255)->nullable();
            $table->string('nit', 255)->nullable();
            $table->string('business_name', 255)->nullable();
            $table->string('acronym', 255)->nullable();
            $table->dateTime('application_date')->nullable();
            $table->dateTime('register_date')->nullable();
            $table->string('accounting_assistant', 255)->nullable();
            $table->string('phone_number1', 255)->nullable();
            $table->string('phone_number2', 255)->nullable();
            $table->string('phone_number3', 255)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('president', 255)->nullable();
            $table->string('contact_person', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('sector', 255)->nullable();
            $table->string('building', 255)->nullable();
            $table->string('floor', 255)->nullable();
            $table->string('office', 255)->nullable();
            $table->string('parish', 255)->nullable();
            $table->string('municipality', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('rm_number', 255)->nullable();
            $table->string('rm_volume', 255)->nullable();
            $table->string('rm_district', 255)->nullable();
            $table->string('rm_city', 255)->nullable();
            $table->string('rm_register', 255)->nullable();
            $table->string('patent', 255)->nullable();
            $table->string('contractors_registration', 255)->nullable();
            $table->string('company_activity', 255)->nullable();
            $table->float('aliquot')->nullable();
            $table->string('account', 255)->nullable();
            $table->string('id_ubi', 255)->nullable();
            $table->string('percentage', 255)->nullable();
            $table->integer('active')->nullable();
            $table->string('num_credit', 255)->nullable();
            $table->string('num_debit', 255)->nullable();
            $table->string('user_enter', 255)->nullable();
            $table->string('user_modify', 255)->nullable();
            $table->boolean('brute_entry_dec')->nullable();
            $table->float('brute_entry_percentage')->nullable();
            $table->dateTime('contract_init_date')->nullable();
            $table->dateTime('contract_modify_date')->nullable();
            $table->boolean('dec_adjust')->nullable();
            $table->string('client_type', 255)->nullable();
            $table->float('secuence')->nullable();
            $table->string('cd_user', 255)->nullable();
            $table->string('origin', 255)->nullable();
            $table->integer('payer')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
