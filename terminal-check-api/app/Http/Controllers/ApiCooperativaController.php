<?php
namespace App\Http\Controllers;

use App\Models\Cooperativa;
use Illuminate\Http\Request;

class ApiCooperativaController extends Controller
{
    public function getCooperativas()
    {
        $cooperativas = Cooperativa::with('ventas.persona')->get();
        return response()->json($cooperativas);
    }

    public function getCooperativa($id)
    {
        $cooperativa = Cooperativa::with('ventas.persona')->findOrFail($id);
        return response()->json($cooperativa);
    }

    public function enviarRevisiones(Request $request, $id)
    {
        $cooperativa = Cooperativa::findOrFail($id);
        $revisiones = $request->input('revisiones', []);
        $observaciones = $request->input('observaciones', '');
        return response()->json(['success' => true, 'message' => 'Revisión enviada a notificación.']);
    }
}