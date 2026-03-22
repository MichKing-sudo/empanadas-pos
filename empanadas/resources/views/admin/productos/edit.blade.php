@extends('admin.layout')
@section('content')
<div class="card" style="max-width:500px; margin:0 auto;">
    <h1>✏️ Editar Producto</h1>
    <form action="{{ route('admin.productos.update', $producto) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" required>
        </div>
        <div class="form-group">
            <label>Categoría</label>
            <select name="categoria" required>
                <option value="empanada"    {{ $producto->categoria=='empanada'    ? 'selected' : '' }}>🫓 Empanada</option>
                <option value="papa_rellena"{{ $producto->categoria=='papa_rellena'? 'selected' : '' }}>🥔 Papa Rellena</option>
            </select>
        </div>
        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="precio" value="{{ $producto->precio }}" min="0" step="100" required>
        </div>
        <div class="form-group">
            <label>Disponible</label>
            <select name="disponible">
                <option value="1" {{ $producto->disponible ? 'selected' : '' }}>✅ Sí</option>
                <option value="0" {{ !$producto->disponible ? 'selected' : '' }}>❌ No</option>
            </select>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Atrás</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection