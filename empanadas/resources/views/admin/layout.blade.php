<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🫓 EmpanadasPOS — Admin</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; }

        .navbar {
            background: #b5451b;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
        }
        .navbar .brand {
            color: white;
            font-size: 1.3rem;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar nav a {
            color: #ffe0d0;
            text-decoration: none;
            margin-left: 25px;
            font-size: 0.95rem;
            padding: 6px 12px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .navbar nav a:hover, .navbar nav a.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 20px;
        }

        h1 { color: #333; margin-bottom: 20px; font-size: 1.5rem; }

        .btn {
            padding: 8px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary   { background: #b5451b; color: white; }
        .btn-warning   { background: #f0a500; color: white; }
        .btn-danger    { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #b5451b; color: white; padding: 10px 14px; text-align: left; }
        td { padding: 10px 14px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #fff5f2; }

        .alert {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.95rem;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; }
        .form-group input,
        .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 0.95rem; }
        .form-group input:focus,
        .form-group select:focus { outline: none; border-color: #b5451b; }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="brand" href="/admin">🫓 EmpanadasPOS</a>
        <nav>
            <a href="{{ route('admin.productos.index') }}"
               class="{{ request()->is('admin/productos*') ? 'active' : '' }}">
               📦 Productos
            </a>
            <a href="{{ route('admin.clientes.index') }}"
               class="{{ request()->is('admin/clientes*') ? 'active' : '' }}">
               👥 Clientes
            </a>
            <a href="{{ route('admin.informes.index') }}"
               class="{{ request()->is('admin/informes*') ? 'active' : '' }}">
               📊 Informes
            </a>
            <a href="{{ route('pos.index') }}">🛒 Ir al POS</a>
        </nav>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>