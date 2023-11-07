<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Proceso;
use App\Models\TipoDoc;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentoController extends Controller
{
    public function viewIndex()
    {
        $documents = Documento::with('tipo_doc', 'proceso')->get();
        $tipoDoc = TipoDoc::all();
        $proceso = Proceso::all();

        $lastDocumentId = Documento::max('id');

        return Inertia::render('Documents/Index', [
            'documents' => $documents,
            'tipoDocs' => $tipoDoc,
            'procesos' => $proceso,
            'lastDocumentId' => $lastDocumentId,
        ]);
    }

    public function storeDocument(Request $request)
    {
        $this->validate($request, [
            'codigo' => ['required', 'unique:documentos,codigo'],
            'nombre' => ['required'],
            'contenido' => ['required'],
            'proceso_id' => ['required'],
            'tipo_doc_id' => ['required'],
        ]);

        $documento = Documento::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'contenido' => $request->contenido,
            'proceso_id' => $request->proceso_id,
            'tipo_doc_id' => $request->tipo_doc_id,
        ]);

        $documento->save();

        return redirect('documentsView');
    }

    public function updateDocument(Request $request, $id)
    {
        $documento = Documento::find($id);

        $this->validate($request, [
            'id' => ['required'],
            'codigo' => ['required'],
            'nombre' => ['required'],
            'contenido' => ['required'],
            'proceso_id' => ['required'],
            'tipo_doc_id' => ['required'],
        ]);

        $documento->fill([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'contenido' => $request->contenido,
            'proceso_id' => $request->proceso_id,
            'tipo_doc_id' => $request->tipo_doc_id,
        ]);
        $documento->save();

        return redirect('documentsView');
    }

    public function destroyDocument($id)
    {
        $documento = Documento::find($id);
        $documento->delete();

        return redirect('documentsView');
    }
}
