<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'contenido',
        'proceso_id',
        'tipo_doc_id'
    ];

    public function tipo_doc()
    {
        return $this->belongsTo(TipoDoc::class);
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }

}
