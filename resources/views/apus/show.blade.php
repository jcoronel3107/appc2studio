echo '<!DOCTYPE html>
<html>
<head>
    <title>Detalle APU - {{ $apu->code }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1, h2, h3 { color: #333; }
        .header-info { background: #e8f4f8; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .section { margin-top: 30px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        .section-title { background: #007bff; color: white; padding: 10px 15px; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f0f0f0; }
        .total-row { background: #e8f4f8; font-weight: bold; }
        .totals { margin-top: 20px; padding: 15px; background: #d4edda; border-radius: 8px; text-align: right; }
        .grand-total { font-size: 20px; font-weight: bold; color: #28a745; }
        .btn { display: inline-block; padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 15px; }
        .btn-export { background: #17a2b8; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/apus" class="btn">← Volver al listado</a>
        <a href="/exportar-apu/{{ $apu->id }}" class="btn btn-export">📥 Exportar este APU</a>
        <a href="/apu/{{ $apu->id }}/edit" class="btn" style="background:#ffc107; color:#333; margin-left:10px;">✏️ Editar APU</a>

        <a href="{{ route('apus.clone', $apu->id) }}" class="btn" style="background:#8b5cf6; margin-left:10px;">📋 Clonar APU</a>

        <h1>📄 Análisis de Precios Unitarios</h1>
        
        <div class="header-info">
            <p><strong>Código:</strong> {{ $apu->code }}</p>
            <p><strong>Rubro:</strong> {{ $apu->name }}</p>
            <p><strong>Unidad:</strong> {{ $apu->unit }}</p>
            <p><strong>Fecha:</strong> {{ $apu->created_at->format("d/m/Y H:i:s") }}</p>
        </div>
        
        @php $equipos = $apu->items->where("section", "equipment"); @endphp
        @if($equipos->count() > 0)
        <div class="section">
            <h3 class="section-title">🖥️ EQUIPOS</h3>
            <table>
                <thead><tr><th>Descripción</th><th>Cantidad</th><th>Tarifa</th><th>Rendimiento</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($equipos as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->performance }}</td>
                        <td>$ {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row"><td colspan="4"><strong>SUBTOTAL EQUIPOS</strong></td><td><strong>$ {{ number_format($equipos->sum("total"), 2) }}</strong></td></tr>
                </tbody>
            </table>
        </div>
        @endif
        
        @php $labor = $apu->items->where("section", "labor"); @endphp
        @if($labor->count() > 0)
        <div class="section">
            <h3 class="section-title">👷 MANO DE OBRA</h3>
            <table>
                <thead><tr><th>Descripción</th><th>Cantidad</th><th>Jornal/HR</th><th>Rendimiento</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($labor as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->performance }}</td>
                        <td>$ {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row"><td colspan="4"><strong>SUBTOTAL MANO DE OBRA</strong></td><td><strong>$ {{ number_format($labor->sum("total"), 2) }}</strong></td></tr>
                </tbody>
            </table>
        </div>
        @endif
        
        @php $materiales = $apu->items->where("section", "material"); @endphp
        @if($materiales->count() > 0)
        <div class="section">
            <h3 class="section-title">🧱 MATERIALES</h3>
            <table>
                <thead><tr><th>Descripción</th><th>Cantidad</th><th>Precio Unit.</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($materiales as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->unit_price, 2) }}</td>
                        <td>$ {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row"><td colspan="3"><strong>SUBTOTAL MATERIALES</strong></td><td><strong>$ {{ number_format($materiales->sum("total"), 2) }}</strong></td></tr>
                </tbody>
            </table>
        </div>
        @endif
        
        @php $transporte = $apu->items->where("section", "transport"); @endphp
        @if($transporte->count() > 0)
        <div class="section">
            <h3 class="section-title">🚚 TRANSPORTE</h3>
            <table>
                <thead><tr><th>Descripción</th><th>Cantidad</th><th>Tarifa</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($transporte as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->unit_price, 2) }}</td>
                        <td>$ {{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row"><td colspan="3"><strong>SUBTOTAL TRANSPORTE</strong></td><td><strong>$ {{ number_format($transporte->sum("total"), 2) }}</strong></td></tr>
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="totals">
            <p><strong>TOTAL COSTO DIRECTO:</strong> $ {{ number_format($apu->total_direct_cost ?? 0, 2) }}</p>
            <p><strong>INDIRECTOS (20%):</strong> $ {{ number_format($apu->indirect_cost ?? 0, 2) }}</p>
            <p class="grand-total"><strong>COSTO TOTAL:</strong> $ {{ number_format($apu->total_cost ?? 0, 2) }}</p>
        </div>
    </div>
</body>
</html>' > resources\views\apus\show.blade.php