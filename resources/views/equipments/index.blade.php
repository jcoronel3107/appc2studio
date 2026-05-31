@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🖥️ Equipos</h1>
        
        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('equipments.create') }}" style="background: #22c55e; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">➕ Nuevo Equipo</a>
            <a href="{{ route('equipments.import.form') }}" style="background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">📤 Importar</a>
            <a href="{{ route('equipments.export') }}" style="background: #a855f7; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">💾 Exportar</a>
        </div>
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; margin: 10px 0; border-radius: 4px;">
                ❌ {{ session('error') }}
            </div>
        @endif
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="{{ route('equipments.index') }}" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="{{ request('search') }}" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                @if(request('search'))
                    <a href="{{ route('equipments.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                @endif
            </form>
        </div>

        @if(request('search'))
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                Resultados para: <strong>"{{ request('search') }}"</strong> - {{ $equipments->total() }} encontrados
            </div>
        @endif



        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Código</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Nombre</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Categoría</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Unidad</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Precio</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Término</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipments as $equipment)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <strong>{{ $equipment->code }}</strong>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        {{ $equipment->name }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        {{ $equipment->category ?? '-' }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        {{ $equipment->unit }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        ${{ number_format($equipment->price, 2) }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        {{ $equipment->termino ?? '-' }}
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('equipments.edit', $equipment->id) }}" style="color: #eab308; text-decoration: none;">✏️ Editar</a>
                            <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este equipo?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; border: 1px solid #ddd;">
                        📭 No hay equipos registrados.
                        <a href="{{ route('equipments.create') }}" style="display: block; margin-top: 10px; color: #3b82f6;">➕ Crear el primer equipo</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Paginación -->
        @if($equipments->hasPages())
        <div style="margin-top: 30px; text-align: center;">
            <div style="display: inline-flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                {{-- Botón Primera --}}
                @if($equipments->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">« Primera</span>
                @else
                    <a href="{{ $equipments->url(1) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">« Primera</a>
                @endif
                
                {{-- Botón Anterior --}}
                @if($equipments->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">‹ Anterior</span>
                @else
                    <a href="{{ $equipments->previousPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">‹ Anterior</a>
                @endif
                
                {{-- Números de página --}}
                @php
                    $start = max(1, $equipments->currentPage() - 2);
                    $end = min($equipments->lastPage(), $equipments->currentPage() + 2);
                @endphp
                
                @if($start > 1)
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                @for($i = $start; $i <= $end; $i++)
                    @if($i == $equipments->currentPage())
                        <span style="padding: 8px 12px; background: #3b82f6; color: white; border-radius: 4px;">{{ $i }}</span>
                    @else
                        <a href="{{ $equipments->url($i) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">{{ $i }}</a>
                    @endif
                @endfor
                
                @if($end < $equipments->lastPage())
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                {{-- Botón Siguiente --}}
                @if($equipments->hasMorePages())
                    <a href="{{ $equipments->nextPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Siguiente ›</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Siguiente ›</span>
                @endif
                
                {{-- Botón Última --}}
                @if($equipments->hasMorePages())
                    <a href="{{ $equipments->url($equipments->lastPage()) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Última »</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Última »</span>
                @endif
            </div>
            
            <div style="margin-top: 15px; font-size: 14px; color: #666;">
                Mostrando {{ $equipments->firstItem() }} - {{ $equipments->lastItem() }} de {{ $equipments->total() }} equipos
            </div>
        </div>
        @endif
    </div>
</div>
@endsection