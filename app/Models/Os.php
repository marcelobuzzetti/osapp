<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Os extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'tipo_aparelho',
        'marca_id',
        'modelo',
        'estado_aparelho',
        'defeito_alegado',
        'acessorios',
        'laudo_tecnico',
        'valor_servico',
        'entregue_para',
        'status_id',
        'is_orcado',

    ];

    protected $table = 'ordens';

    protected $with = ['cliente', 'marca', 'status', 'pecas'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function pecas()
    {
        return $this->hasMany(Peca::class, 'ordem_id', 'id');
    }

    public static function osUpdate($request){
        DB::table('ordens')
        ->where('id', $request['id'])
        ->update([
            'cliente_id' => $request['cliente_id'],
            'tipo_aparelho' => $request['tipo_aparelho'],
            'marca_id' => $request['marca_id'],
            'status_id' => $request['status_id'],
            'modelo' => $request['modelo'],
            'estado_aparelho' => $request['estado_aparelho'],
            'defeito_alegado' => $request['defeito_alegado'],
            'valor_servico' => $request['valor_servico'],
            'observacao' => $request['observacao'],
            'valor_servico' => $request['valor_servico']
        ]);
    }

    public static function currencyToDecimal($currency)
    {
        return str_replace(",",".",str_replace(".","",$currency));
    }

    public static function decimalToCurrency($currency)
    {
        return str_replace(".",",",$currency);
    }
}
