<?php

namespace App\Http\Controllers;

use App\Models\TipoDoc;
use Illuminate\Http\Request;

class TipoDocController extends Controller
{
    public function storeTypeDoc(Request $request)
    {
        $this->validate($request, [
            'tip_prefijo' => ['required'],
            'tip_nombre' => ['required'],
        ]);

        $tipo_doc = TipoDoc::create([
            'tip_prefijo' => $request->tip_prefijo,
            'tip_nombre' => $request->tip_nombre,
        ]);

        $tipo_doc->save();

        return redirect('configView');
    }

    public function updateTypeDoc(Request $request, $id)
    {
        $tipo_doc = TipoDoc::find($id);

        $this->validate($request, [
            'tip_prefijo' => ['required'],
            'tip_nombre' => ['required'],
        ]);

        $tipo_doc->fill([
            'tip_prefijo' => $request->tip_prefijo,
            'tip_nombre' => $request->tip_nombre,
        ]);

        $tipo_doc->save();

        return redirect('configView');
    }

    public function destroyTypeDoc($id)
    {
        $tipo_doc = TipoDoc::find($id);
        $tipo_doc->delete();

        if ($tipo_doc->documents()->count() > 0) {
            return redirect('configView')->with('error', 'No puedes eliminar este tipo porque tiene documentos relacionados.');
        }

        return redirect('configView');
    }
}
