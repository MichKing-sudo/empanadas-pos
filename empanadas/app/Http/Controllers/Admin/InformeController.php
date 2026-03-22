<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->desde ?? now()->startOfMonth()->toDateString();
        $hasta = $request->hasta ?? now()->toDateString();

        // Ventas totales por período
        $totalVentas = Venta::whereBetween(DB::raw('DATE(created_at)'), [$desde, $hasta])->sum('total');
        $cantidadVentas = Venta::whereBetween(DB::raw('DATE(created_at)'), [$desde, $hasta])->count();

        // Ventas por producto
        $ventasPorProducto = VentaDetalle::select(
                'producto_id',
                DB::raw('SUM(cantidad) as total_cantidad'),
                DB::raw('SUM(subtotal) as total_valor')
            )
            ->with('producto')
            ->groupBy('producto_id')
            ->orderByDesc('total_cantidad')
            ->get();

        // Tipo de cliente (mostrador vs registrado)
        $totalMostrador  = Venta::where('es_mostrador', 1)->count();
        $totalRegistrado = Venta::where('es_mostrador', 0)->count();

        // Ventas por ciudad
        $ventasPorCiudad = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->select('clientes.ciudad', DB::raw('COUNT(*) as total'))
            ->where('ventas.es_mostrador', 0)
            ->groupBy('clientes.ciudad')
            ->orderByDesc('total')
            ->get();
// Historial de ventas
$historialVentas = Venta::with(['cliente', 'detalles'])
    ->whereBetween(DB::raw('DATE(created_at)'), [$desde, $hasta])
    ->orderByDesc('created_at')
    ->get();

        return view('admin.informes.index', compact(
            'totalVentas', 'cantidadVentas',
            'ventasPorProducto',
            'totalMostrador', 'totalRegistrado',
            'ventasPorCiudad',
            'desde', 'hasta',
            'historialVentas'
        ));
    }
}