<?php

namespace Database\Seeders;

use App\Models\TipoDoc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoDoc::create([
            'tip_nombre' => 'Insctructivo',
            'tip_prefijo' => 'INS',
        ]);
        TipoDoc::create([
            'tip_nombre' => 'Manual',
            'tip_prefijo' => 'MNL',
        ]);
        TipoDoc::create([
            'tip_nombre' => 'Politica',
            'tip_prefijo' => 'POL',
        ]);
        TipoDoc::create([
            'tip_nombre' => 'Informe',
            'tip_prefijo' => 'INF',
        ]);
        TipoDoc::create([
            'tip_nombre' => 'Contrato',
            'tip_prefijo' => 'CON',
        ]);
    }
}
