@extends('admin.layout')
@section('content')
<div class="card" style="max-width:550px; margin:0 auto;">
    <h1>✏️ Editar Cliente</h1>
    <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Tipo de Documento</label>
            <select name="tipo_documento" required>
                <option value="CC"  {{ $cliente->tipo_documento=='CC'  ? 'selected':'' }}>Cédula de Ciudadanía</option>
                <option value="CE"  {{ $cliente->tipo_documento=='CE'  ? 'selected':'' }}>Cédula de Extranjería</option>
                <option value="NIT" {{ $cliente->tipo_documento=='NIT' ? 'selected':'' }}>NIT</option>
                <option value="PP"  {{ $cliente->tipo_documento=='PP'  ? 'selected':'' }}>Pasaporte</option>
            </select>
        </div>
        <div class="form-group">
            <label>Número de Documento</label>
            <input type="text" name="numero_documento" value="{{ $cliente->numero_documento }}" required>
        </div>
        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" name="nombre" value="{{ $cliente->nombre }}" required>
        </div>
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ $cliente->direccion }}">
        </div>
        <div class="form-group">
            <label>Ciudad</label>
            <input type="text" name="ciudad" value="{{ $cliente->ciudad }}">
        </div>
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $cliente->telefono }}" required>
        </div>
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">Atrás</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection