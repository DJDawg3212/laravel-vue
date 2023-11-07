<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    public function storeProcess(Request $request)
    {
        $this->validate($request, [
            'pro_prefijo' => ['required'],
            'pro_nombre' => ['required'],
        ]);

        $proceso = Proceso::create([
            'pro_prefijo' => $request->pro_prefijo,
            'pro_nombre' => $request->pro_nombre,
        ]);

        $proceso->save();

        return redirect('configView');
    }

    public function updateProcess(Request $request, $id)
    {
        $proceso = Proceso::find($id);

        $this->validate($request, [
            'pro_prefijo' => ['required'],
            'pro_nombre' => ['required'],
        ]);

        $proceso->fill([
            'pro_prefijo' => $request->pro_prefijo,
            'pro_nombre' => $request->pro_nombre,
        ]);

        $proceso->save();

        return redirect('configView');
    }

    public function destroyProcess($id)
    {
        $proceso = Proceso::find($id);

        if ($proceso->documents()->count() > 0) {
            return response()->json(['message' => 'No se puede eliminar el proceso debido a documentos relacionados.'], 422);
        }

        $proceso->delete();

        return redirect('configView');
    }
}
