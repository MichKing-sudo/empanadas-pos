@extends('admin.layout')
@section('content')
<div class="card" style="max-width:550px; margin:0 auto;">
    <h1>➕ Nuevo Cliente</h1>
    <form action="{{ route('admin.clientes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tipo de Documento</label>
            <select name="tipo_documento" required>
                <option value="">-- Seleccionar --</option>
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="CE">Cédula de Extranjería</option>
                <option value="NIT">NIT</option>
                <option value="PP">Pasaporte</option>
            </select>
        </div>
        <div class="form-group">
            <label>Número de Documento</label>
            <input type="text" name="numero_documento" required>
        </div>
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion">
        </div>
        <div class="form-group">
            <label>Ciudad</label>
            <input type="text" name="ciudad">
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" required>
        </div>
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Atrás</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection