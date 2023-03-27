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
            $table->longText('acessorios')->nullable()->change();
            $table->longText('defeito_alegado')->nullable()->change();
            $table->longText('laudo_tecnico')->nullable()->change();
        });

        Schema::table('empresas', function($table) {
            $table->longText('observacao')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
