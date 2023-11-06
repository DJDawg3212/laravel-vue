<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Proceso;
use App\Models\TipoDoc;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentoController extends Controller
{
    public function index()
    {
        $documents = Documento::all();
        $tipoDoc = TipoDoc::all();
        $proceso = Proceso::all();

        return Inertia::render('Documents/Index', [
            'documents' => $documents,
            'tipoDoc' => $tipoDoc,
            'proceso' => $proceso,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'doc_codigo' => ['required', 'unique:doc_documentos.doc_codigo'],
            'doc_nombre' => ['required'],
            'doc_contenido' => ['required'],
            'pro_proceso_id' => ['required'],
            'tip_tipo_doc_id' => ['required'],
        ]);

        Documento::create([
            'doc_codigo' => $request->doc_codigo,
            'doc_nombre' => $request->doc_nombre,
            'doc_contenido' => $request->doc_contenido,
            'pro_proceso_id' => $request->pro_proceso_id,
            'tip_tipo_doc_id' => $request->tip_tipo_doc_id,
        ]);

        return redirect('documents');
    }

    public function show(Documento $documento)
    {
        //
    }

    public function edit(Documento $documento)
    {
        //
    }

    public function update(Request $request, Documento $documento)
    {
        $this->validate($request, [
            'doc_codigo' => ['required', 'unique:doc_documentos.doc_codigo'],
            'doc_nombre' => ['required'],
            'doc_contenido' => ['required'],
            'pro_proceso_id' => ['required'],
            'tip_tipo_doc_id' => ['required'],
        ]);

        $documento->fill([
            'doc_codigo' => $request->doc_codigo,
            'doc_nombre' => $request->doc_nombre,
            'doc_contenido' => $request->doc_contenido,
            'pro_proceso_id' => $request->pro_proceso_id,
            'tip_tipo_doc_id' => $request->tip_tipo_doc_id,
        ]);
        $documento->save();

        return redirect('documents');
    }

    public function destroy(Documento $documento)
    {
        $documento->delete();

        return redirect('documents');
    }
}
