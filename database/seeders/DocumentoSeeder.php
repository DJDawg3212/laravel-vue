<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\Proceso;
use App\Models\TipoDoc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procesos = Proceso::all()->shuffle();
        $tipos = TipoDoc::all()->shuffle();
        $i = 1;

        foreach ($procesos as $proceso) {
            foreach ($tipos as $tipo) {

                $documento = Documento::factory()->state([
                    'proceso_id' => $proceso->id,
                    'tipo_doc_id' => $tipo->id,
                ])->create();
                $documento->codigo = $proceso->pro_prefijo . "-" . $tipo->tip_prefijo . "-" . $documento->id;
                $documento->save();

                $i++;
                if ($i > 4) {
                    return;
                }
            }
        }
    }
}
