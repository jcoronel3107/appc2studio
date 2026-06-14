@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px; max-width: 1400px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0;">📄 Presupuesto #{{ $budget->id }}</h1>
            <div>
                <a href="{{ route('budgets.edit', $budget->id) }}" style="background: #eab308; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; margin-right: 10px;">✏️ Editar</a>
                <a href="{{ route('budgets.index') }}" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">← Volver</a>
            </div>
        </div>
        
        <!-- Datos de cabecera -->
        <div style="background: #f0f0f0; padding: 20px; margin-bottom: 20px; border-radius: 8px;">
            <h3 style="margin: 0 0 15px 0; color: #333;">📋 Datos Generales</h3>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                <div><strong>🏗️ OBRA:</strong> {{ $budget->obra }}</div>
                <div><strong>📄 No. CONTRATO:</strong> {{ $budget->no_contrato ?? '-' }}</div>
                <div><strong>👤 CONTRATISTA:</strong> {{ $budget->contratista ?? '-' }}</div>
                <div><strong>📅 FECHA CONTRATO:</strong> {{ $budget->fecha_contrato ? \Carbon\Carbon::parse($budget->fecha_contrato)->format('d/m/Y') : '-' }}</div>
                <div><strong>💰 MONTO ANTICIPO:</strong> ${{ number_format($budget->monto_anticipo ?? 0, 2) }}</div>
                <div><strong>📅 FECHA ENTREGA ANTICIPO:</strong> {{ $budget->fecha_entrega_anticipo ? \Carbon\Carbon::parse($budget->fecha_entrega_anticipo)->format('d/m/Y') : '-' }}</div>
                <div><strong>🔍 FISCALIZADOR:</strong> {{ $budget->fiscalizador ?? '-' }}</div>
                <div><strong>📅 FECHA INICIO OBRA:</strong> {{ $budget->fecha_inicio_obra ? \Carbon\Carbon::parse($budget->fecha_inicio_obra)->format('d/m/Y') : '-' }}</div>
                <div><strong>👨‍💼 ADMINISTRADOR:</strong> {{ $budget->administrador ?? '-' }}</div>
                <div><strong>⏱️ PLAZO:</strong> {{ $budget->plazo_dias ?? '-' }} días</div>
                <div><strong>➕ AMPLIACIÓN:</strong> {{ $budget->ampliacion_plazo ?? 0 }} días</div>
                <div><strong>📅 FECHA TERMINACIÓN:</strong> {{ $budget->fecha_terminacion_plazo ? \Carbon\Carbon::parse($budget->fecha_terminacion_plazo)->format('d/m/Y') : '-' }}</div>
                <div><strong>📅 FECHA ELABORACIÓN:</strong> {{ $budget->fecha_elaboracion ? \Carbon\Carbon::parse($budget->fecha_elaboracion)->format('d/m/Y') : '-' }}</div>
            </div>
        </div>
        
        <!-- Estructura del Presupuesto: Hitos → Categorías → APUs -->
        <h3 style="margin-top: 20px;">📊 Estructura del Presupuesto</h3>
        
        @php
            // Agrupar items por hito y categoría
            $hitos = [];
            foreach($budget->items as $item) {
                $hitoKey = $item->milestone_id ?? 'sin_hito';
                if (!isset($hitos[$hitoKey])) {
                    $hitos[$hitoKey] = [
                        'code' => $item->milestone_code,
                        'name' => $item->milestone_name,
                        'categorias' => []
                    ];
                }
                $categoriaKey = $item->category_code ?? $item->category;
                if (!isset($hitos[$hitoKey]['categorias'][$categoriaKey])) {
                    $hitos[$hitoKey]['categorias'][$categoriaKey] = [
                        'name' => $item->category,
                        'items' => []
                    ];
                }
                $hitos[$hitoKey]['categorias'][$categoriaKey]['items'][] = $item;
            }
        @endphp
        
        @if(count($hitos) > 0)
            @php $totalGeneral = 0; @endphp
            
            @foreach($hitos as $hitoKey => $hito)
            <div style="margin-bottom: 35px; border: 2px solid #3b82f6; border-radius: 10px; overflow: hidden;">
                <!-- Encabezado del Hito -->
                <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 15px 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 20px; font-weight: bold;">{{ $hito['code'] }}</span>
                            <span style="font-size: 18px; margin-left: 15px;">{{ $hito['name'] }}</span>
                        </div>
                        @php $subtotalHito = 0; @endphp
                    </div>
                </div>
                
                <!-- Categorías dentro del Hito -->
                <div style="padding: 15px;">
                    @foreach($hito['categorias'] as $categoriaKey => $categoria)
                    <div style="margin-bottom: 25px; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                        <!-- Encabezado de Categoría -->
                        <div style="background: #eff6ff; padding: 10px 15px; border-bottom: 1px solid #e5e7eb;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-weight: bold; color: #2563eb;">{{ $categoriaKey }}</span>
                                    <span style="margin-left: 15px;">{{ $categoria['name'] }}</span>
                                </div>
                                @php $subtotalCategoria = 0; @endphp
                            </div>
                        </div>
                        
                        <!-- Tabla de APUs -->
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f3f4f6;">
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Código</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Nombre</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #e5e7eb;">Unidad</th>
                                    <th style="padding: 12px; text-align: center; border-bottom: 2px solid #e5e7eb;">Cantidad</th>
                                    <th style="padding: 12px; text-align: right; border-bottom: 2px solid #e5e7eb;">Precio Unit.</th>
                                    <th style="padding: 12px; text-align: right; border-bottom: 2px solid #e5e7eb;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoria['items'] as $item)
                                @php 
                                    $subtotalCategoria += $item->total;
                                    $subtotalHito += $item->total;
                                    $totalGeneral += $item->total;
                                @endphp
                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                    <td style="padding: 10px;">{{ $item->apu_code }}</td>
                                    <td style="padding: 10px;">{{ $item->apu_name }}</td>
                                    <td style="padding: 10px;">{{ $item->apu_unit }}</td>
                                    <td style="padding: 10px; text-align: center;">{{ number_format($item->quantity, 2) }}</td>
                                    <td style="padding: 10px; text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                                    <td style="padding: 10px; text-align: right;">${{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: #dbeafe;">
                                    <td colspan="5" style="padding: 10px; text-align: right; font-weight: bold;">Subtotal {{ $categoria['name'] }}:</td>
                                    <td style="padding: 10px; text-align: right; font-weight: bold;">${{ number_format($subtotalCategoria, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endforeach
                    
                    <!-- Subtotal del Hito -->
                    <div style="text-align: right; margin-top: 10px; padding: 12px; background: #bfdbfe; border-radius: 8px;">
                        <strong>SUBTOTAL HITO {{ $hito['code'] }} - {{ $hito['name'] }}:</strong>
                        <span style="font-size: 16px;">${{ number_format($subtotalHito, 2) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Totales Generales -->
            <div style="background: #d4edda; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span><strong>SUBTOTAL APUs:</strong></span>
                    <span><strong>${{ number_format($totalGeneral, 2) }}</strong></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #dc2626;">
                    <span><strong>MONTO ANTICIPO:</strong></span>
                    <span><strong>-${{ number_format($budget->monto_anticipo ?? 0, 2) }}</strong></span>
                </div>
                <hr style="margin: 15px 0;">
                <div style="display: flex; justify-content: space-between; font-size: 20px;">
                    <span><strong>TOTAL PRESUPUESTO:</strong></span>
                    <span><strong>${{ number_format($totalGeneral - ($budget->monto_anticipo ?? 0), 2) }}</strong></span>
                </div>
            </div>
        @else
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 40px; text-align: center;">
                <p style="margin: 0; color: #dc2626;">⚠️ No hay APUs agregados a este presupuesto.</p>
                <a href="{{ route('budgets.edit', $budget->id) }}" style="display: inline-block; margin-top: 15px; background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">➕ Agregar APUs</a>
            </div>
        @endif
    </div>
</div>
@endsection