<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager;

class CreateBaseDomainIndex extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        Manager::schema()->table('users', function (Blueprint $table) {
            $table->index('baseDomain');
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        Manager::schema()->table('users', function (Blueprint $table) {
            $table->dropIndex(['baseDomain']);
        });
    }
}
