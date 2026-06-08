@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📋 Listado de APUs</h1>
        <a href="{{ route('apus.create') }}">➕ Nuevo APU</a>
        <a href="{{ url('/importar') }}">📤 Importar APU</a>
        
        @if(session('success'))
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ {{ session('success') }}</div>
        @endif
        
        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
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
                    <td>{{ $apu->items->count() }}</td>
                    <td>{{ $apu->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="/apu/{{ $apu->id }}" style="color: #3b82f6;">Ver</a>
                        <a href="/apu/{{ $apu->id }}/edit" style="color: #eab308;">Editar</a>
                        <a href="/apu/clonar/{{ $apu->id }}" style="color: #8b5cf6;">📋 Clonar</a>
                        <form action="/apu/{{ $apu->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este APU?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
             <!-- Paginación -->
        @if($apus->hasPages())
        <div style="margin-top: 30px; text-align: center;">
            <div style="display: inline-flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                {{-- Botón Primera --}}
                @if($apus->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">« Primera</span>
                @else
                    <a href="{{ $apus->url(1) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">« Primera</a>
                @endif
                
                {{-- Botón Anterior --}}
                @if($apus->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">‹ Anterior</span>
                @else
                    <a href="{{ $apus->previousPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">‹ Anterior</a>
                @endif
                
                {{-- Números de página --}}
                @php
                    $start = max(1, $apus->currentPage() - 2);
                    $end = min($apus->lastPage(), $apus->currentPage() + 2);
                @endphp
                
                @if($start > 1)
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                @for($i = $start; $i <= $end; $i++)
                    @if($i == $apus->currentPage())
                        <span style="padding: 8px 12px; background: #3b82f6; color: white; border-radius: 4px;">{{ $i }}</span>
                    @else
                        <a href="{{ $apus->url($i) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">{{ $i }}</a>
                    @endif
                @endfor
                
                @if($end < $apus->lastPage())
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                {{-- Botón Siguiente --}}
                @if($apus->hasMorePages())
                    <a href="{{ $apus->nextPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Siguiente ›</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Siguiente ›</span>
                @endif
                
                {{-- Botón Última --}}
                @if($apus->hasMorePages())
                    <a href="{{ $apus->url($apus->lastPage()) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Última »</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Última »</span>
                @endif
            </div>
            
            <div style="margin-top: 15px; font-size: 14px; color: #666;">
                Mostrando {{ $apus->firstItem() }} - {{ $apus->lastItem() }} de {{ $apus->total() }} apus
            </div>
        </div>
        @endif
        </table>
    </div>
</div>
@endsection