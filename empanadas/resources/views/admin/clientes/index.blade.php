@extends('admin.layout')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1>👥 Gestión de Clientes</h1>
        <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">+ Nuevo Cliente</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $c)
            <tr>
                <td>{{ $c->tipo_documento }} {{ $c->numero_documento }}</td>
                <td>{{ $c->nombre }}</td>
                <td>{{ $c->ciudad }}</td>
                <td>{{ $c->telefono }}</td>
                <td>
                    <a href="{{ route('admin.clientes.edit', $c) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('admin.clientes.destroy', $c) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger"
                            onclick="return confirm('¿Eliminar este cliente?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#999;">No hay clientes registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection