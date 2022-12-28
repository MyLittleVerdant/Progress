<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager;

class CreateUserTable extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Manager::schema()->create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('accountId')->primary();
            $table->text('accessToken');
            $table->text('refreshToken');
            $table->unsignedInteger('expires');
            $table->string('baseDomain');
            $table->string('unisenderToken')->nullable();
            $table->unsignedInteger('unisenderList')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Manager::schema()->dropIfExists('users');
    }
}
