echo '<!DOCTYPE html>
<html>
<head>
    <title>Listado de APUs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { display: inline-block; padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .btn-import { background: #28a745; margin-bottom: 20px; display: inline-block; }
        .badge { background: #6c757d; color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Listado de Análisis de Precios Unitarios</h1>
        
        <a href="/importar" class="btn btn-import">➕ Importar nuevo APU</a>
        <a href="/apu-summary" class="btn">📊 Ver resumen</a>
        <a href="{{ route('export.apus') }}" class="btn" style="background:#17a2b8">📥 Exportar todos</a>
        @if($apus->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Rubro</th>
                        <th>Unidad</th>
                        <th>Costo Total</th>
                        <th>Items</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apus as $apu)
                    <tr>
                        <td><strong>{{ $apu->code }}</strong></td>
                        <td>{{ Str::limit($apu->name, 50) }}</td>
                        <td>{{ $apu->unit }}</td>
                        <td>$ {{ number_format($apu->total_cost ?? 0, 2) }}</td>
                        <td><span class="badge">{{ $apu->items->count() }}</span></td>
                        <td>{{ $apu->created_at->format("d/m/Y H:i") }}</td>
                        <td><a href="/apu/{{ $apu->id }}" class="btn">Ver</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; padding: 40px;">
                📭 No hay APUs importados todavía.<br>
                <a href="/importar" class="btn" style="margin-top: 10px;">Importar mi primer APU</a>
            </p>
        @endif
    </div>
</body>
</html>' > resources\views\apus\index.blade.php