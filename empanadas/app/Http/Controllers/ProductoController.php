<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|max:100',
            'categoria' => 'required|in:empanada,papa_rellena',
            'precio'    => 'required|numeric|min:0',
        ]);
        Producto::create($request->all());
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente ✅');
    }

    public function edit(Producto $producto)
    {
        return view('admin.productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'    => 'required|max:100',
            'categoria' => 'required|in:empanada,papa_rellena',
            'precio'    => 'required|numeric|min:0',
        ]);
        $producto->update($request->all());
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente ✅');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->tieneVentas()) {
            return redirect()->route('admin.productos.index')
                ->with('error', '❌ No se puede eliminar: este producto tiene ventas registradas.');
        }
        $producto->delete();
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente ✅');
    }
    public function toggle(Producto $producto)
{
    $producto->update(['disponible' => !$producto->disponible]);
    return redirect()->route('admin.productos.index')
        ->with('success', 'Disponibilidad actualizada ✅');
}
}
