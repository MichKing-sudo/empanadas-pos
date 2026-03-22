@extends('admin.layout')
@section('content')
<div class="card" style="max-width:500px; margin:0 auto;">
    <h1>➕ Nuevo Producto</h1>
    <form action="{{ route('admin.productos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="Ej: Empanada de Pollo" required>
        </div>
        <div class="form-group">
            <label>Categoría</label>
            <select name="categoria" required>
                <option value="">-- Seleccionar --</option>
                <option value="empanada">🫓 Empanada</option>
                <option value="papa_rellena">🥔 Papa Rellena</option>
            </select>
        </div>
        <div class="form-group">
            <label>Precio</label>
            <input type="number" name="precio" min="0" step="100" placeholder="Ej: 2500" required>
        </div>
        <div class="form-group">
            <label>Disponible</label>
            <select name="disponible">
                <option value="1">✅ Sí</option>
                <option value="0">❌ No</option>
            </select>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Atrás</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection