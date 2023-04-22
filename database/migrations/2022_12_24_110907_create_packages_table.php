<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('to_name');
            $table->string('to_phone');
            $table->string('alter_phone')->nullable();
            $table->string('package_type');
            $table->string('package_location');
            $table->string('area_id');
            $table->string('village_id');
            $table->string('street');
            $table->integer('total_cost');
            $table->integer('delivery_cost');
            $table->date('delivery_date')->nullable();
            $table->integer('plus_cost')->nullable();
            $table->string('description');
            $table->string('note')->nullable();
            $table->string('shipping_state');
            $table->string('invoice_state')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('qr_code2')->nullable();
            $table->string('is_back_to_owner')->nullable();
            $table->string('back_by_driver')->nullable();
            $table->string('back_date')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices', 'id');
            $table->foreignId('driver_id')->nullable()->constrained('users', 'id');
            $table->string('driver_note')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
