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
        </table>
    </div>
</div>
@endsection