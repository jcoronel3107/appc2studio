echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📦 Materiales</h1>
        <a href="{{ route("materials.create") }}">➕ Nuevo Material</a>
        <a href="{{ route("materials.import.form") }}">📤 Importar</a>
        
        @if(session("success"))
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ {{ session("success") }}</div>
        @endif
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="{{ route('materials.index') }}" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="{{ request('search') }}" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                @if(request('search'))
                    <a href="{{ route('materials.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                @endif
            </form>
        </div>
        @if(request('search'))
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            Resultados para: <strong>"{{ request('search') }}"</strong> - {{ $materials->total() }} encontrados
            </div>
        @endif



        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{ $material->code }}</td>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->unit }}</td>
                    <td>${{ number_format($material->price, 2) }}</td>
                    <td>{{ $material->termino ?? "-" }}</td>
                    <td>
                        <a href="{{ route("materials.edit", $material->id) }}">✏️ Editar</a>
                        <form action="{{ route("materials.destroy", $material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method("DELETE")
                            <button type="submit" onclick="return confirm(\"¿Eliminar este material?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginación -->
        @if($materials->hasPages())
        <div style="margin-top: 30px; text-align: center;">
            <div style="display: inline-flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                {{-- Botón Primera --}}
                @if($materials->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">« Primera</span>
                @else
                    <a href="{{ $materials->url(1) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">« Primera</a>
                @endif
                
                {{-- Botón Anterior --}}
                @if($materials->onFirstPage())
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">‹ Anterior</span>
                @else
                    <a href="{{ $materials->previousPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">‹ Anterior</a>
                @endif
                
                {{-- Números de página --}}
                @php
                    $start = max(1, $materials->currentPage() - 2);
                    $end = min($materials->lastPage(), $materials->currentPage() + 2);
                @endphp
                
                @if($start > 1)
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                @for($i = $start; $i <= $end; $i++)
                    @if($i == $materials->currentPage())
                        <span style="padding: 8px 12px; background: #3b82f6; color: white; border-radius: 4px;">{{ $i }}</span>
                    @else
                        <a href="{{ $materials->url($i) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">{{ $i }}</a>
                    @endif
                @endfor
                
                @if($end < $materials->lastPage())
                    <span style="padding: 8px 12px;">...</span>
                @endif
                
                {{-- Botón Siguiente --}}
                @if($materials->hasMorePages())
                    <a href="{{ $materials->nextPageUrl() }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Siguiente ›</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Siguiente ›</span>
                @endif
                
                {{-- Botón Última --}}
                @if($materials->hasMorePages())
                    <a href="{{ $materials->url($materials->lastPage()) }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Última »</a>
                @else
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Última »</span>
                @endif
            </div>
            
            <div style="margin-top: 15px; font-size: 14px; color: #666;">
                Mostrando {{ $materials->firstItem() }} - {{ $materials->lastItem() }} de {{ $materials->total() }} materiales
            </div>
        </div>
        @endif
        
        
        
    </div>
</div>
@endsection' > resources\views\materials\index.blade.php