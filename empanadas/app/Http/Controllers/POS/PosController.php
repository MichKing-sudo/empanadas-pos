<?php
namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $productos = Producto::where('disponible', 1)->get();
        $clientes = Cliente::orderBy('nombre')->get();
        return view('pos.index', compact('productos', 'clientes'));
    }

    public function buscarCliente(Request $request)
    {
        $cliente = Cliente::where('numero_documento', $request->numero_documento)->first();
        if ($cliente) {
            return response()->json(['encontrado' => true, 'cliente' => $cliente]);
        }
        return response()->json(['encontrado' => false]);
    }

    public function crearCliente(Request $request)
    {
        $cliente = Cliente::create($request->all());
        return response()->json(['success' => true, 'cliente' => $cliente]);
    }

    public function registrarVenta(Request $request)
    {
        $esMostrador = $request->es_mostrador == '1';
        $total = 0;
        $items = json_decode($request->items, true);

        foreach ($items as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $venta = Venta::create([
            'cliente_id'   => $esMostrador ? null : $request->cliente_id,
            'es_mostrador' => $esMostrador,
            'total'        => $total,
        ]);

        foreach ($items as $item) {
            VentaDetalle::create([
                'venta_id'        => $venta->id,
                'producto_id'     => $item['id'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal'        => $item['precio'] * $item['cantidad'],
            ]);
        }

        return response()->json(['success' => true, 'venta_id' => $venta->id]);
    }
}