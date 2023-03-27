<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'nome_empresa' => 'Help Reparos e Utilidades LTDA',
            'nome' => 'Help Reparos',
            'email' => 'helpreparos.utilidades@gmail.com',
            'telefone' => '(27) 3098-2080',
            'endereco' => 'Av. São Paulo, 574 - Santo Antônio, Cariacica, ES, Brasil',
            'facebook' => 'https://pt-br.facebook.com/helpreparos.utilidade/',
            'whatsapp' => '(27) 3098-2080',
        ]);
    }
}
