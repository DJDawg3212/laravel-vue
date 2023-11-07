<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\TipoDoc;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfigController extends Controller
{
    public function viewIndex()
    {
        $tipoDocs = TipoDoc::all();
        $procesos = Proceso::all();

        return Inertia::render('Config/Index', [
            'tipoDocs' => $tipoDocs,
            'procesos' => $procesos,
        ]);
    }
}
