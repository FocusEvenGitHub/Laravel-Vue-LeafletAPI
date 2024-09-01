<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rodovia extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'uf_id', 'rodovia'];

    // Relacionamento com Uf
    public function uf()
    {
        return $this->belongsTo(Uf::class);
    }
}
