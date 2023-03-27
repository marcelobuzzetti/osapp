<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->dropColumn('garantia');
        });

        Schema::table('empresas', function($table) {
            $table->string('garantia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordens', function (Blueprint $table) {
            $table->string('garantia')->nullable();
        });

        Schema::table('empresas', function($table) {
            $table->dropColumn('garantia');
        });
    }
};
