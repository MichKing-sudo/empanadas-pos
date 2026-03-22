<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento'   => 'required',
            'numero_documento' => 'required|unique:clientes',
            'nombre'           => 'required|max:100',
            'telefono'         => 'required',
        ]);
        Cliente::create($request->all());
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente creado correctamente ✅');
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'   => 'required|max:100',
            'telefono' => 'required',
        ]);
        $cliente->update($request->all());
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente actualizado correctamente ✅');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->tieneVentas()) {
            return redirect()->route('admin.clientes.index')
                ->with('error', '❌ No se puede eliminar: este cliente tiene compras registradas.');
        }
        $cliente->delete();
        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente eliminado correctamente ✅');
    }
}