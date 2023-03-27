<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peca extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'valor',
        'ordem_id'
    ];

    protected $table = 'pecas';

    public function ordem()
    {
        return $this->belongsTo(Os::class);
    }
}
