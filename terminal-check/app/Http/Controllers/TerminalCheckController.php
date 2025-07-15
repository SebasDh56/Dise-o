<?php

namespace App\Http\Controllers;

use App\Models\Cooperativa;
use Illuminate\Http\Request;
use App\Jobs\SendRevisionConfirmation;


class TerminalCheckController extends Controller
{

    public function enviarCorreo(Request $request)
{
    $cooperativa = Cooperativa::findOrFail($request->cooperativa_id);
    $revisiones = $request->revisiones ?? [];
    $toEmail = 'boletoscore@gmail.com';

    SendRevisionConfirmation::dispatch($cooperativa, $revisiones, $toEmail);

    return response()->json(['success' => true, 'message' => 'Correo enviado correctamente.']);
}
    public function index(Request $request)
    {
        $cooperativas = Cooperativa::all(); // Lista de todas las cooperativas
        $cooperativaId = $request->input('cooperativa_id', $cooperativas->first()->id ?? 1); // Valor por defecto
        $cooperativa = Cooperativa::with(['ventas.persona'])->findOrFail($cooperativaId);

        $boletosVendidos = $cooperativa->ventas->sum('cantidad_boletos');
        $capacidadTotal = $cooperativa->cantidad_pasajeros; // Capacidad total de la cooperativa
        $pasajeros = $cooperativa->ventas->map(function ($venta) {
            return (object) [
                'persona' => $venta->persona,
                'boletos_totales' => $venta->cantidad_boletos, // Boletos de esta venta
            ];
        })->groupBy(function ($item) {
            return $item->persona->id;
        })->map(function ($group) {
            return (object) [
                'persona' => $group->first()->persona,
                'boletos_totales' => $group->sum('boletos_totales'),
            ];
        })->values();

        return view('terminal-check.index', compact('cooperativa', 'boletosVendidos', 'pasajeros', 'cooperativas', 'capacidadTotal'));
    }

    
}