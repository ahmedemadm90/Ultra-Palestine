<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->string('tm_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('area_id')->constrained();
            $table->foreignId('village_id')->constrained();
            $table->string('street')->nullable();
            $table->string('budget')->nullable();
            $table->foreignId('role_id')->constrained('roles','id');
            $table->foreignId('office_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('delivery_cost_discount')->default(0);
            $table->integer('delivery_persentage')->nullable();
            $table->integer('returns_cost')->default(50);
            $table->integer('active')->default(1);
            $table->string('fb_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
