@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>📋 Presupuestos</h1>
            <a href="{{ route('budgets.create') }}" style="background: #22c55e; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">➕ Nuevo Presupuesto</a>
        </div>
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">✅ {{ session('success') }}</div>
        @endif
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Obra</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Contratista</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Monto</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Fecha</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgets as $budget)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $budget->id }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $budget->obra }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $budget->contratista ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($budget->monto ?? 0, 2) }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $budget->created_at->format('d/m/Y') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <a href="{{ route('budgets.show', $budget->id) }}" style="color: #3b82f6;">👁️ Ver</a>
                        <a href="{{ route('budgets.edit', $budget->id) }}" style="color: #eab308; margin-left: 10px;">✏️ Editar</a>
                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline; margin-left: 10px;">
                            @csrf @method('DELETE')
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este presupuesto?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $budgets->links() }}
    </div>
</div>
@endsection