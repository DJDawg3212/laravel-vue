<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pro_nombre',
        'pro_prefijo',
    ];

    public function documents()
    {
        return $this->hasMany(DocDocumento::class);
    }

}
