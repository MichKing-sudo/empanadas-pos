<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 EmpanadasPOS — Punto de Venta</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #1a1a2e; color: #eee; min-height: 100vh; }

        .topbar {
            background: #b5451b;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .brand { font-size: 1.3rem; font-weight: bold; color: white; }
        .topbar a { color: #ffe0d0; text-decoration: none; font-size: 0.9rem; }

        .pos-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            padding: 20px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .panel {
            background: #16213e;
            border-radius: 12px;
            padding: 20px;
        }

        h2 { font-size: 1.1rem; color: #ffb347; margin-bottom: 15px; }

        /* Cliente */
        .cliente-toggle { display: flex; gap: 10px; margin-bottom: 15px; }
        .toggle-btn {
            flex: 1; padding: 8px; border: 2px solid #b5451b;
            background: transparent; color: #ccc; border-radius: 8px;
            cursor: pointer; font-size: 0.9rem; transition: all 0.2s;
        }
        .toggle-btn.active { background: #b5451b; color: white; }

        .cliente-form input, .cliente-form select {
            width: 100%; padding: 8px 10px; margin-bottom: 8px;
            background: #0f3460; border: 1px solid #444; border-radius: 6px;
            color: white; font-size: 0.9rem;
        }
        .cliente-form input::placeholder { color: #888; }

        /* Productos */
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
        }
        .producto-card {
            background: #0f3460;
            border: 2px solid transparent;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .producto-card:hover { border-color: #b5451b; transform: translateY(-2px); }
        .producto-card .emoji { font-size: 2rem; }
        .producto-card .nombre { font-size: 0.85rem; margin: 8px 0 4px; color: #ddd; }
        .producto-card .precio { color: #ffb347; font-weight: bold; font-size: 0.95rem; }

        /* Carrito */
        .carrito-items { min-height: 200px; margin-bottom: 15px; }
        .carrito-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #2a2a4a;
        }
        .carrito-item .item-nombre { font-size: 0.9rem; color: #ddd; flex: 1; }
        .qty-controls { display: flex; align-items: center; gap: 8px; }
        .qty-btn {
            width: 26px; height: 26px; border-radius: 50%;
            border: none; cursor: pointer; font-size: 1rem; font-weight: bold;
            display: flex; align-items: center; justify-content: center;
        }
        .qty-minus { background: #444; color: white; }
        .qty-plus  { background: #b5451b; color: white; }
        .qty-num   { color: white; font-weight: bold; min-width: 20px; text-align: center; }
        .item-subtotal { color: #ffb347; font-weight: bold; font-size: 0.9rem; min-width: 70px; text-align: right; }

        .total-box {
            background: #0f3460;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }
        .total-label { color: #aaa; font-size: 0.85rem; }
        .total-valor { font-size: 2rem; font-weight: bold; color: #ffb347; }

        .btn-venta {
            width: 100%; padding: 14px;
            background: #b5451b; color: white;
            border: none; border-radius: 10px;
            font-size: 1.1rem; font-weight: bold;
            cursor: pointer; transition: background 0.2s;
        }
        .btn-venta:hover { background: #d4521f; }
        .btn-venta:disabled { background: #444; cursor: not-allowed; }

        .empty-cart { text-align: center; color: #555; padding: 40px 0; font-size: 0.9rem; }

        /* Modal cliente nuevo */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.7); z-index: 100;
            justify-content: center; align-items: center;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #16213e; border-radius: 14px;
            padding: 25px; width: 420px; max-width: 95vw;
        }
        .modal h3 { color: #ffb347; margin-bottom: 15px; }
        .modal input, .modal select {
            width: 100%; padding: 9px 11px; margin-bottom: 10px;
            background: #0f3460; border: 1px solid #444;
            border-radius: 6px; color: white; font-size: 0.9rem;
        }
        .modal-btns { display: flex; gap: 10px; margin-top: 5px; }
        .btn-confirm { flex:1; padding:10px; background:#b5451b; color:white; border:none; border-radius:8px; cursor:pointer; font-size:0.95rem; }
        .btn-cancel  { flex:1; padding:10px; background:#444; color:white; border:none; border-radius:8px; cursor:pointer; font-size:0.95rem; }

        /* Toast */
        .toast {
            position: fixed; bottom: 25px; right: 25px;
            background: #22c55e; color: white;
            padding: 14px 22px; border-radius: 10px;
            font-weight: bold; font-size: 0.95rem;
            opacity: 0; transition: opacity 0.4s;
            z-index: 200;
        }
        .toast.show { opacity: 1; }
    </style>
</head>
<body>

<div class="topbar">
    <span class="brand">🫓 EmpanadasPOS — Punto de Venta</span>
    <a href="/admin">⚙️ Ir al Admin</a>
</div>

<div class="pos-grid">

    {{-- COLUMNA IZQUIERDA --}}
    <div>
     {{-- Cliente --}}
<div class="panel" style="margin-bottom:20px;">
    <h2>👤 Cliente</h2>
    <div class="cliente-toggle">
        <button class="toggle-btn active" id="btnMostrador" onclick="setMostrador(true)">🏪 Mostrador</button>
        <button class="toggle-btn" id="btnRegistrado" onclick="setMostrador(false)">👤 Cliente Registrado</button>
    </div>

    <div id="seccionCliente" style="display:none;" class="cliente-form">

        {{-- Estado: sin cliente seleccionado --}}
        <div id="estadoSinCliente">
            <input type="text" id="buscarDoc"
                placeholder="Buscar por número de documento..."
                oninput="buscarCliente(this.value)">

            {{-- Resultados de búsqueda --}}
            <div id="resultadoBusqueda" style="display:none;
                background:#0f3460; border-radius:8px;
                margin-bottom:8px; overflow:hidden;">
            </div>

            <button onclick="abrirModalCliente()"
                style="background:transparent; border:1px solid #b5451b;
                color:#b5451b; padding:7px 14px; border-radius:6px;
                cursor:pointer; font-size:0.85rem; margin-top:4px; width:100%;">
                + Crear nuevo cliente
            </button>
        </div>

        {{-- Estado: cliente ya seleccionado --}}
        <div id="estadoClienteSeleccionado" style="display:none;
            background:#0a2a0a; border:1px solid #22c55e;
            border-radius:10px; padding:14px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="color:#22c55e; font-weight:bold; font-size:0.95rem;">
                        ✅ Cliente seleccionado
                    </div>
                    <div id="clienteSelecNombre" style="color:white; font-size:1rem; margin-top:4px; font-weight:600;"></div>
                    <div id="clienteSelecDoc" style="color:#aaa; font-size:0.82rem; margin-top:2px;"></div>
                    <div id="clienteSelecCiudad" style="color:#aaa; font-size:0.82rem;"></div>
                </div>
                <button onclick="deseleccionarCliente()"
                    style="background:#dc3545; border:none; color:white;
                    border-radius:50%; width:28px; height:28px;
                    cursor:pointer; font-size:1rem; font-weight:bold;
                    display:flex; align-items:center; justify-content:center;">
                    ✕
                </button>
            </div>
        </div>

    </div>
</div>

        {{-- Productos --}}
        <div class="panel">
            <h2>🫓 Productos</h2>
            <div class="productos-grid">
                @foreach($productos as $p)
                <div class="producto-card" onclick="agregarAlCarrito({{ $p->id }}, '{{ $p->nombre }}', {{ $p->precio }})">
                    <div class="emoji">{{ $p->categoria == 'empanada' ? '🫓' : '🥔' }}</div>
                    <div class="nombre">{{ $p->nombre }}</div>
                    <div class="precio">${{ number_format($p->precio, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA: CARRITO --}}
    <div class="panel" style="position:sticky; top:20px; align-self:start;">
        <h2>🛒 Carrito</h2>
        <div class="carrito-items" id="carritoItems">
            <div class="empty-cart" id="emptyMsg">Toca un producto para agregarlo 👆</div>
        </div>
        <div class="total-box">
            <div class="total-label">TOTAL</div>
            <div class="total-valor" id="totalValor">$0</div>
        </div>
        <button class="btn-venta" id="btnVenta" onclick="registrarVenta()" disabled>
            💳 Registrar Venta
        </button>
    </div>
</div>

{{-- Modal nuevo cliente --}}
<div class="modal-overlay" id="modalCliente">
    <div class="modal">
        <h3>➕ Nuevo Cliente</h3>
        <select id="nc_tipo"><option value="">Tipo de documento</option>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="CE">Cédula de Extranjería</option>
            <option value="NIT">NIT</option>
            <option value="PP">Pasaporte</option>
        </select>
        <input id="nc_numero"    type="text"  placeholder="Número de documento">
        <input id="nc_nombre"    type="text"  placeholder="Nombre completo">
        <input id="nc_direccion" type="text"  placeholder="Dirección">
        <input id="nc_ciudad"    type="text"  placeholder="Ciudad">
        <input id="nc_telefono"  type="text"  placeholder="Teléfono">
        <div class="modal-btns">
            <button class="btn-cancel"  onclick="cerrarModal()">Cancelar</button>
            <button class="btn-confirm" onclick="guardarNuevoCliente()">Guardar</button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
    let carrito = {};
    let esMostrador = true;
    let clienteId = null;

    function setMostrador(val) {
        esMostrador = val;
        document.getElementById('seccionCliente').style.display = val ? 'none' : 'block';
        document.getElementById('btnMostrador').classList.toggle('active', val);
        document.getElementById('btnRegistrado').classList.toggle('active', !val);
        if (val) { clienteId = null; }
    }

    // ── Búsqueda de cliente ───────────────────────────────────
    function buscarCliente(doc) {
        const resultado = document.getElementById('resultadoBusqueda');
        if (doc.length < 3) { resultado.style.display = 'none'; return; }

        fetch(`/pos/buscar-cliente?numero_documento=${doc}`)
            .then(r => r.json()).then(data => {
                if (data.encontrado) {
                    const c = data.cliente;
                    resultado.style.display = 'block';
                    resultado.innerHTML = `
                        <div onclick="seleccionarCliente(${c.id}, '${c.nombre}', '${c.tipo_documento} ${c.numero_documento}', '${c.ciudad ?? ''}')"
                            style="padding:12px 15px; cursor:pointer; transition:background 0.15s;
                            border-left: 3px solid #22c55e;"
                            onmouseover="this.style.background='#1a4a6a'"
                            onmouseout="this.style.background='transparent'">
                            <div style="color:white; font-weight:600;">👤 ${c.nombre}</div>
                            <div style="color:#aaa; font-size:0.82rem;">${c.tipo_documento} ${c.numero_documento} · ${c.ciudad ?? 'Sin ciudad'}</div>
                            <div style="color:#22c55e; font-size:0.78rem; margin-top:3px;">Toca para seleccionar</div>
                        </div>`;
                } else {
                    resultado.style.display = 'block';
                    resultado.innerHTML = `
                        <div style="padding:12px 15px; color:#f87171; font-size:0.88rem;">
                            ❌ No se encontró ningún cliente con ese documento
                        </div>`;
                }
            });
    }

    function seleccionarCliente(id, nombre, doc, ciudad) {
        clienteId = id;
        // Mostrar tarjeta de cliente seleccionado
        document.getElementById('estadoSinCliente').style.display = 'none';
        document.getElementById('estadoClienteSeleccionado').style.display = 'block';
        document.getElementById('clienteSelecNombre').textContent = nombre;
        document.getElementById('clienteSelecDoc').textContent = '📄 ' + doc;
        document.getElementById('clienteSelecCiudad').textContent = ciudad ? '📍 ' + ciudad : '';
        // Limpiar búsqueda
        document.getElementById('buscarDoc').value = '';
        document.getElementById('resultadoBusqueda').style.display = 'none';
    }

    function deseleccionarCliente() {
        clienteId = null;
        document.getElementById('estadoSinCliente').style.display = 'block';
        document.getElementById('estadoClienteSeleccionado').style.display = 'none';
    }

    // ── Carrito ───────────────────────────────────────────────
    function agregarAlCarrito(id, nombre, precio) {
        if (carrito[id]) {
            carrito[id].cantidad++;
        } else {
            carrito[id] = { id, nombre, precio, cantidad: 1 };
        }
        renderCarrito();
    }

    function cambiarCantidad(id, delta) {
        carrito[id].cantidad += delta;
        if (carrito[id].cantidad <= 0) delete carrito[id];
        renderCarrito();
    }

    function renderCarrito() {
        const container = document.getElementById('carritoItems');
        const keys = Object.keys(carrito);

        let html = '';
        let total = 0;
        keys.forEach(id => {
            const item = carrito[id];
            const sub = item.precio * item.cantidad;
            total += sub;
            html += `
                <div class="carrito-item">
                    <span class="item-nombre">${item.nombre}</span>
                    <div class="qty-controls">
                        <button class="qty-btn qty-minus" onclick="cambiarCantidad(${id}, -1)">−</button>
                        <span class="qty-num">${item.cantidad}</span>
                        <button class="qty-btn qty-plus"  onclick="cambiarCantidad(${id}, +1)">+</button>
                    </div>
                    <span class="item-subtotal">$${sub.toLocaleString('es-CO')}</span>
                </div>`;
        });

        container.innerHTML = html + `
            <div class="empty-cart" id="emptyMsg"
                style="display:${keys.length ? 'none' : 'block'}">
                Toca un producto para agregarlo 👆
            </div>`;

        document.getElementById('totalValor').textContent = '$' + total.toLocaleString('es-CO');
        document.getElementById('btnVenta').disabled = keys.length === 0;
    }

    // ── Registrar venta ───────────────────────────────────────
    function registrarVenta() {
        const items = Object.values(carrito);
        if (!items.length) return;
        if (!esMostrador && !clienteId) {
            showToast('⚠️ Debes seleccionar un cliente', '#f0a500');
            return;
        }

        const data = new FormData();
        data.append('_token', '{{ csrf_token() }}');
        data.append('es_mostrador', esMostrador ? '1' : '0');
        data.append('cliente_id', clienteId ?? '');
        data.append('items', JSON.stringify(items));

        fetch('/pos/venta', { method: 'POST', body: data })
            .then(r => r.json()).then(res => {
                if (res.success) {
                    carrito = {};
                    clienteId = null;
                    deseleccionarCliente();
                    renderCarrito();
                    showToast('✅ Venta registrada exitosamente!');
                }
            });
    }

    // ── Modal nuevo cliente ───────────────────────────────────
    function abrirModalCliente() { document.getElementById('modalCliente').classList.add('open'); }
    function cerrarModal()       { document.getElementById('modalCliente').classList.remove('open'); }

    function guardarNuevoCliente() {
        const tipo    = document.getElementById('nc_tipo').value;
        const numero  = document.getElementById('nc_numero').value;
        const nombre  = document.getElementById('nc_nombre').value;
        const telefono= document.getElementById('nc_telefono').value;

        if (!tipo || !numero || !nombre || !telefono) {
            showToast('⚠️ Completa los campos requeridos', '#f0a500'); return;
        }

        const data = new FormData();
        data.append('_token',           '{{ csrf_token() }}');
        data.append('tipo_documento',   tipo);
        data.append('numero_documento', numero);
        data.append('nombre',           nombre);
        data.append('direccion',        document.getElementById('nc_direccion').value);
        data.append('ciudad',           document.getElementById('nc_ciudad').value);
        data.append('telefono',         telefono);

        fetch('/pos/crear-cliente', { method: 'POST', body: data })
            .then(r => r.json()).then(res => {
                if (res.success) {
                    const c = res.cliente;
                    seleccionarCliente(c.id, c.nombre,
                        `${c.tipo_documento} ${c.numero_documento}`, c.ciudad);
                    cerrarModal();
                    showToast('✅ Cliente creado y seleccionado');
                }
            });
    }

    // ── Toast ─────────────────────────────────────────────────
    function showToast(msg, color = '#22c55e') {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.style.background = color;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }
</script>
</body>
</html>