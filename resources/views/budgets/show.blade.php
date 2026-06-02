@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>📄 Presupuesto #{{ $budget->id }}</h1>
            <div>
                <a href="{{ route('budgets.edit', $budget->id) }}" style="background: #eab308; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">✏️ Editar</a>
                <a href="{{ route('budgets.index') }}" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">← Volver</a>
            </div>
        </div>
        
        <div style="background: #f0f0f0; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                <p><strong>OBRA:</strong> {{ $budget->obra }}</p>
                <p><strong>CONTRATISTA:</strong> {{ $budget->contratista ?? '-' }}</p>
                <p><strong>MONTO ANTICIPO:</strong> ${{ number_format($budget->monto_anticipo ?? 0, 2) }}</p>
                <p><strong>FISCALIZADOR:</strong> {{ $budget->fiscalizador ?? '-' }}</p>
                <p><strong>ADMINISTRADOR:</strong> {{ $budget->administrador ?? '-' }}</p>
                <p><strong>No. CONTRATO:</strong> {{ $budget->no_contrato ?? '-' }}</p>
                <p><strong>FECHA CONTRATO:</strong> {{ $budget->fecha_contrato ? \Carbon\Carbon::parse($budget->fecha_contrato)->format('d/m/Y') : '-' }}</p>
                <p><strong>FECHA ENTREGA ANTICIPO:</strong> {{ $budget->fecha_entrega_anticipo ? \Carbon\Carbon::parse($budget->fecha_entrega_anticipo)->format('d/m/Y') : '-' }}</p>
                <p><strong>FECHA INICIO OBRA:</strong> {{ $budget->fecha_inicio_obra ? \Carbon\Carbon::parse($budget->fecha_inicio_obra)->format('d/m/Y') : '-' }}</p>
                <p><strong>PLAZO:</strong> {{ $budget->plazo_dias ?? '-' }} días</p>
                <p><strong>AMPLIACIÓN:</strong> {{ $budget->ampliacion_plazo ?? 0 }} días</p>
                <p><strong>FECHA TERMINACIÓN:</strong> {{ $budget->fecha_terminacion_plazo ? \Carbon\Carbon::parse($budget->fecha_terminacion_plazo)->format('d/m/Y') : '-' }}</p>
                <p><strong>FECHA ELABORACIÓN:</strong> {{ $budget->fecha_elaboracion ? \Carbon\Carbon::parse($budget->fecha_elaboracion)->format('d/m/Y') : '-' }}</p>
            </div>
        </div>
        
        <h3>📋 APUs del Presupuesto</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Código</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Nombre</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Unidad</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Cantidad</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Precio Unit.</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($budget->items as $item)
                @php $subtotal += $item->total; @endphp
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $item->apu_code }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $item->apu_name }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $item->apu_unit }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($item->quantity, 2) }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #d4edda;">
                    <td colspan="5" style="padding: 10px; text-align: right;"><strong>SUBTOTAL APUs:</strong></td>
                    <td style="padding: 10px;"><strong>${{ number_format($subtotal, 2) }}</strong></td>
                </tr>
                <tr style="background: #d4edda;">
                    <td colspan="5" style="padding: 10px; text-align: right;"><strong>MONTO ANTICIPO:</strong></td>
                    <td style="padding: 10px;"><strong>${{ number_format($budget->monto_anticipo ?? 0, 2) }}</strong></td>
                </tr>
                <tr style="background: #d4edda; font-size: 18px;">
                    <td colspan="5" style="padding: 10px; text-align: right;"><strong>TOTAL PRESUPUESTO:</strong></td>
                    <td style="padding: 10px;"><strong>${{ number_format($budget->monto ?? 0, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection