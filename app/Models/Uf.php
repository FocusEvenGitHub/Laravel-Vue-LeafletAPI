<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'uf'];

    // Relacionamento com Rodovia
    public function rodovias()
    {
        return $this->hasMany(Rodovia::class);
    }
}
