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
            $table->dropColumn('observacao');
            $table->string('acessorios')->nullable();
        });

        Schema::table('empresas', function($table) {
            $table->string('observacao')->nullable();
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
            $table->string('observacao')->nullable();
            $table->dropColumn('acessorios');
        });

        Schema::table('empresas', function($table) {
            $table->dropColumn('observacao');
        });
    }
};
