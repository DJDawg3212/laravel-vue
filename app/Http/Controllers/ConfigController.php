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
        $tipoDoc = TipoDoc::all();
        $proceso = Proceso::all();

        return Inertia::render('Config/Index', [
            'tipoDoc' => $tipoDoc,
            'proceso' => $proceso,
        ]);
    }

    public function storeTypeDoc(Request $request)
    {
        $this->validate($request, [
            'tip_nombre' => ['required'],
            'tip_prefijo' => ['required'],
        ]);

        TipoDoc::create([
            'tip_nombre' => $request->tip_nombre,
            'tip_prefijo' => $request->tip_prefijo,
        ]);

        return redirect('config');
    }

    public function storeProcess(Request $request)
    {
        $this->validate($request, [
            'pro_nombre' => ['required'],
            'pro_prefijo' => ['required'],
        ]);

        Proceso::create([
            'pro_nombre' => $request->pro_nombre,
            'pro_prefijo' => $request->pro_prefijo,
        ]);

        return redirect('config');
    }
}
