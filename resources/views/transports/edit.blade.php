@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>✏️ Editar Transporte</h1>
        <form method="POST" action="{{ route('transports.update', $transport->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" value="{{ $transport->code }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" value="{{ $transport->name }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <input type="text" name="category" value="{{ $transport->category }}" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <select name="unit" required style="width:100%; padding: 8px;">
                    <option value="hora" {{ $transport->unit == 'hora' ? 'selected' : '' }}>Hora</option>
                    <option value="día" {{ $transport->unit == 'día' ? 'selected' : '' }}>Día</option>
                    <option value="viaje" {{ $transport->unit == 'viaje' ? 'selected' : '' }}>Viaje</option>
                    <option value="km" {{ $transport->unit == 'km' ? 'selected' : '' }}>Kilómetro</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Precio:</label>
                <input type="number" step="0.01" name="price" value="{{ $transport->price }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" value="{{ $transport->termino }}" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Descripción:</label>
                <textarea name="description" rows="3" style="width:100%; padding: 8px;">{{ $transport->description }}</textarea>
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none;">Actualizar</button>
            <a href="{{ route('transports.index') }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection