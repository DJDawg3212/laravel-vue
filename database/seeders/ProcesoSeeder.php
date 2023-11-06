<?php

namespace Database\Seeders;

use App\Models\Proceso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proceso::create([
            'pro_nombre' => 'Ingenieria',
            'pro_prefijo' => 'ING',
        ]);
        Proceso::create([
            'pro_nombre' => 'Contabilidad',
            'pro_prefijo' => 'CBL',
        ]);
        Proceso::create([
            'pro_nombre' => 'Inventario',
            'pro_prefijo' => 'INV',
        ]);
        Proceso::create([
            'pro_nombre' => 'Produccion',
            'pro_prefijo' => 'PRD',
        ]);
        Proceso::create([
            'pro_nombre' => 'Ventas',
            'pro_prefijo' => 'VTS',
        ]);
    }
}
