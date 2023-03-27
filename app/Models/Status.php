<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao'
    ];

    protected $table = 'status';

    public function os()
    {
        return $this->hasMany(Os::class, 'status_id', 'id');
    }

}
