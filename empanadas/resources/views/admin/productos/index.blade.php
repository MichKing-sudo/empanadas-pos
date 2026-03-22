@extends('admin.layout')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h1>📦 Gestión de Productos</h1>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">+ Nuevo Producto</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->categoria == 'empanada' ? '🫓 Empanada' : '🥔 Papa Rellena' }}</td>
                <td>${{ number_format($p->precio, 0, ',', '.') }}</td>
                <td>{{ $p->disponible ? '✅' : '❌' }}</td>
<td>
    {{-- Toggle disponible --}}
    <form action="{{ route('admin.productos.toggle', $p) }}" method="POST" style="display:inline">
        @csrf @method('PATCH')
        <button class="btn {{ $p->disponible ? 'btn-secondary' : 'btn-primary' }}">
            {{ $p->disponible ? '⛔ Desactivar' : '✅ Activar' }}
        </button>
    </form>
    <a href="{{ route('admin.productos.edit', $p) }}" class="btn btn-warning">Editar</a>
    <form action="{{ route('admin.productos.destroy', $p) }}" method="POST" style="display:inline">
        @csrf @method('DELETE')
        <button class="btn btn-danger"
            onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
    </form>
</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#999;">No hay productos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection