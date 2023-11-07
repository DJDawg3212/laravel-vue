<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'tip_nombre',
        'tip_prefijo',
    ];

    public function documents()
    {
        return $this->hasMany(Documento::class);
    }
}
