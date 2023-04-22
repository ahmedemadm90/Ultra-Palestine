<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->foreignId('package_id')->constrained();
            $table->string('package_location');
            $table->string('shipping_state');
            $table->string('notes')->nullable();
            $table->string('details');
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
        Schema::dropIfExists('package_logs');
    }
}
