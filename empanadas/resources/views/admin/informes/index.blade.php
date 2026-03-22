@extends('admin.layout')
@section('content')
<div class="card">
    <h1>📊 Informes de Ventas</h1>

    {{-- Filtro por fechas --}}
    <form method="GET" style="display:flex; gap:15px; align-items:flex-end; margin-bottom:25px; flex-wrap:wrap;">
        <div class="form-group" style="margin:0">
            <label>Desde</label>
            <input type="date" name="desde" value="{{ $desde }}" style="width:auto">
        </div>
        <div class="form-group" style="margin:0">
            <label>Hasta</label>
            <input type="date" name="hasta" value="{{ $hasta }}" style="width:auto">
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    {{-- Tarjetas resumen --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:15px; margin-bottom:25px;">
        <div style="background:#fff5f2; border:2px solid #b5451b; border-radius:10px; padding:20px; text-align:center;">
            <div style="font-size:2rem; font-weight:bold; color:#b5451b;">${{ number_format($totalVentas,0,',','.') }}</div>
            <div style="color:#666; margin-top:5px;">💰 Total Vendido</div>
        </div>
        <div style="background:#f0f9ff; border:2px solid #0ea5e9; border-radius:10px; padding:20px; text-align:center;">
            <div style="font-size:2rem; font-weight:bold; color:#0ea5e9;">{{ $cantidadVentas }}</div>
            <div style="color:#666; margin-top:5px;">🧾 Ventas Realizadas</div>
        </div>
        <div style="background:#f0fdf4; border:2px solid #22c55e; border-radius:10px; padding:20px; text-align:center;">
            <div style="font-size:2rem; font-weight:bold; color:#22c55e;">{{ $totalMostrador }}</div>
            <div style="color:#666; margin-top:5px;">🏪 Ventas Mostrador</div>
        </div>
        <div style="background:#fefce8; border:2px solid #eab308; border-radius:10px; padding:20px; text-align:center;">
            <div style="font-size:2rem; font-weight:bold; color:#eab308;">{{ $totalRegistrado }}</div>
            <div style="color:#666; margin-top:5px;">👤 Clientes Registrados</div>
        </div>
    </div>

    {{-- Gráfica tipo de cliente --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:25px;">
        <div>
            <h2 style="font-size:1.1rem; margin-bottom:15px;">🏪 Tipo de Cliente</h2>
            <canvas id="graficaTipoCliente" height="200"></canvas>
        </div>
        <div>
            <h2 style="font-size:1.1rem; margin-bottom:15px;">🫓 Ventas por Producto</h2>
            <canvas id="graficaProductos" height="200"></canvas>
        </div>
    </div>

    {{-- Tabla ventas por producto --}}
    <h2 style="font-size:1.1rem; margin-bottom:15px;">📋 Detalle por Producto</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Unidades Vendidas</th>
                <th>Total Recaudado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ventasPorProducto as $v)
            <tr>
                <td>{{ $v->producto->nombre ?? 'N/A' }}</td>
                <td>{{ $v->producto->categoria == 'empanada' ? '🫓 Empanada' : '🥔 Papa Rellena' }}</td>
                <td>{{ $v->total_cantidad }}</td>
                <td>${{ number_format($v->total_valor, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#999;">Sin datos</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tabla por ciudad --}}
    @if($ventasPorCiudad->count() > 0)
    <h2 style="font-size:1.1rem; margin:25px 0 15px;">🏙️ Ventas por Ciudad</h2>
    <table>
        <thead><tr><th>Ciudad</th><th>Número de Ventas</th></tr></thead>
        <tbody>
            @foreach($ventasPorCiudad as $vc)
            <tr>
                <td>{{ $vc->ciudad ?? 'Sin ciudad' }}</td>
                <td>{{ $vc->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
{{-- Historial de ventas --}}
<h2 style="font-size:1.1rem; margin:25px 0 15px;">🧾 Historial de Ventas</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Items</th>
            <th>Total</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        @forelse($historialVentas as $v)
        <tr>
            <td>#{{ $v->id }}</td>
            <td>{{ date('d/m/Y H:i', strtotime($v->created_at)) }}</td>
            <td>
                @if($v->es_mostrador)
                    🏪 Mostrador
                @else
                    👤 {{ $v->cliente->nombre ?? 'N/A' }}<br>
                    <small style="color:#999;">{{ $v->cliente->tipo_documento ?? '' }} {{ $v->cliente->numero_documento ?? '' }}</small>
                @endif
            </td>
            <td>{{ $v->detalles->sum('cantidad') }} unidades</td>
            <td style="color:#b5451b; font-weight:bold;">${{ number_format($v->total, 0, ',', '.') }}</td>
            <td>
                <button onclick="toggleDetalle({{ $v->id }})"
                    style="background:transparent; border:1px solid #b5451b;
                    color:#b5451b; padding:4px 10px; border-radius:5px;
                    cursor:pointer; font-size:0.82rem;">
                    Ver ▼
                </button>
                {{-- Fila expandible con detalle --}}
                <tr id="detalle-{{ $v->id }}" style="display:none;">
                    <td colspan="6" style="background:#fff5f2; padding:10px 20px;">
                        <table style="width:auto; box-shadow:none;">
                            <thead>
                                <tr>
                                    <th style="background:#eee; color:#333;">Producto</th>
                                    <th style="background:#eee; color:#333;">Cant.</th>
                                    <th style="background:#eee; color:#333;">Precio unit.</th>
                                    <th style="background:#eee; color:#333;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($v->detalles as $d)
                                <tr>
                                    <td>{{ $d->producto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $d->cantidad }}</td>
                                    <td>${{ number_format($d->precio_unitario, 0, ',', '.') }}</td>
                                    <td>${{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center; color:#999;">No hay ventas en este período</td></tr>
        @endforelse
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfica tipo de cliente (dona)
new Chart(document.getElementById('graficaTipoCliente'), {
    type: 'doughnut',
    data: {
        labels: ['Mostrador', 'Registrado'],
        datasets: [{ data: [{{ $totalMostrador }}, {{ $totalRegistrado }}],
            backgroundColor: ['#b5451b', '#0ea5e9'] }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});

// Gráfica por producto (barras)
new Chart(document.getElementById('graficaProductos'), {
    type: 'bar',
    data: {
        labels: [@foreach($ventasPorProducto as $v)'{{ $v->producto->nombre ?? "" }}',@endforeach],
        datasets: [{
            label: 'Unidades vendidas',
            data: [@foreach($ventasPorProducto as $v){{ $v->total_cantidad }},@endforeach],
            backgroundColor: '#b5451b'
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
function toggleDetalle(id) {
    const fila = document.getElementById('detalle-' + id);
    fila.style.display = fila.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection