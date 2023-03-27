<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao'
    ];

    protected $table = 'marcas';

    public function os()
    {
        return $this->hasMany(Os::class,'marca_id', 'id');
    }
}
