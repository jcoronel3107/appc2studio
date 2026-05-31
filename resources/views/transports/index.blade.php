@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🚚 Transporte</h1>
        
        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('transports.create') }}" style="background: #22c55e; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">➕ Nuevo Transporte</a>
            <a href="{{ route('transports.import.form') }}" style="background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">📤 Importar</a>
            <a href="{{ route('transports.export') }}" style="background: #a855f7; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">💾 Exportar</a>
        </div>
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">✅ {{ session('success') }}</div>
        @endif
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">Código</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Nombre</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Categoría</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Unidad</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Precio</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Término</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transports as $transport)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><strong>{{ $transport->code }}</strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $transport->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $transport->category ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $transport->unit }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($transport->price, 2) }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $transport->termino ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <a href="{{ route('transports.edit', $transport->id) }}" style="color: #eab308;">✏️ Editar</a>
                        <form action="{{ route('transports.destroy', $transport->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center;">📭 No hay registros de transporte</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transports->links() }}
    </div>
</div>
@endsection