@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">📊 Dashboard</h1>
        <p style="margin-bottom: 30px;">Bienvenido, {{ Auth::user()->name }}!</p>
        
        <!-- Tarjetas de resumen -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Materiales -->
            <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 14px; opacity: 0.9;">📦 Materiales</p>
                        <p style="font-size: 32px; font-weight: bold; margin: 5px 0;">{{ number_format($totalMateriales) }}</p>
                    </div>
                    <div style="font-size: 40px;">📦</div>
                </div>
                <a href="{{ route('materials.index') }}" style="color: white; text-decoration: none; font-size: 12px; opacity: 0.8;">Ver catálogo →</a>
            </div>
            
            <!-- Equipos -->
            <div style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 14px; opacity: 0.9;">🖥️ Equipos</p>
                        <p style="font-size: 32px; font-weight: bold; margin: 5px 0;">{{ number_format($totalEquipos) }}</p>
                    </div>
                    <div style="font-size: 40px;">🖥️</div>
                </div>
                <a href="{{ route('equipments.index') }}" style="color: white; text-decoration: none; font-size: 12px; opacity: 0.8;">Ver catálogo →</a>
            </div>
            
            <!-- Mano de Obra -->
            <div style="background: linear-gradient(135deg, #eab308, #ca8a04); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 14px; opacity: 0.9;">👷 Mano de Obra</p>
                        <p style="font-size: 32px; font-weight: bold; margin: 5px 0;">{{ number_format($totalLabors) }}</p>
                    </div>
                    <div style="font-size: 40px;">👷</div>
                </div>
                <a href="{{ route('labors.index') }}" style="color: white; text-decoration: none; font-size: 12px; opacity: 0.8;">Ver catálogo →</a>
            </div>
            
            <!-- Transporte -->
            <div style="background: linear-gradient(135deg, #a855f7, #9333ea); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 14px; opacity: 0.9;">🚚 Transporte</p>
                        <p style="font-size: 32px; font-weight: bold; margin: 5px 0;">{{ number_format($totalTransportes) }}</p>
                    </div>
                    <div style="font-size: 40px;">🚚</div>
                </div>
                <a href="{{ route('transports.index') }}" style="color: white; text-decoration: none; font-size: 12px; opacity: 0.8;">Ver catálogo →</a>
            </div>
        </div>
        
        <!-- Segunda fila de tarjetas -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- APUs -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="margin: 0;">📋 APUs</h3>
                    <span style="background: #3b82f6; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px;">Total</span>
                </div>
                <p style="font-size: 36px; font-weight: bold; margin: 10px 0;">{{ number_format($totalApus) }}</p>
                <p style="color: #666; margin: 5px 0;">Items registrados: {{ number_format($totalItems) }}</p>
                <p style="color: #666; margin: 5px 0;">Costo total: ${{ number_format($costoTotalApus, 2) }}</p>
                <a href="{{ route('apus.index') }}" style="display: inline-block; margin-top: 15px; background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">Ver APUs →</a>
            </div>
            
            <!-- Últimos APUs -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px 0;">🕐 Últimos APUs</h3>
                @if($ultimosApus->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($ultimosApus as $apu)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 8px 0;"><strong>{{ $apu->code }}</strong></td>
                            <td style="padding: 8px 0;">{{ Str::limit($apu->name, 25) }}</td>
                            <td style="padding: 8px 0; text-align: right;">${{ number_format($apu->total_cost ?? 0, 2) }}</td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <p style="color: #999; text-align: center; padding: 20px;">No hay APUs registrados</p>
                @endif
                <a href="{{ route('apus.index') }}" style="display: inline-block; margin-top: 15px; color: #3b82f6;">Ver todos →</a>
            </div>
            
            <!-- Materiales más caros -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 15px 0;">💰 Materiales más caros</h3>
                @if($materialesCaros->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($materialesCaros as $material)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 8px 0;">{{ Str::limit($material->name, 20) }}</td>
                            <td style="padding: 8px 0; text-align: right;">${{ number_format($material->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <p style="color: #999; text-align: center; padding: 20px;">No hay materiales registrados</p>
                @endif
                <a href="{{ route('materials.index') }}" style="display: inline-block; margin-top: 15px; color: #3b82f6;">Ver catálogo →</a>
            </div>
        </div>
        
        <!-- Botones de acción rápida -->
        <div style="background: #f0f0f0; border-radius: 12px; padding: 20px;">
            <h3 style="margin: 0 0 15px 0;">⚡ Acciones Rápidas</h3>
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="{{ route('apus.create') }}" style="background: #22c55e; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">➕ Nuevo APU</a>
                <a href="{{ url('/importar') }}" style="background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">📤 Importar APU</a>
                <a href="{{ route('materials.create') }}" style="background: #8b5cf6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">📦 Nuevo Material</a>
                <a href="{{ route('equipments.create') }}" style="background: #ec4898; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">🖥️ Nuevo Equipo</a>
                <a href="{{ route('labors.create') }}" style="background: #f59e0b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">👷 Nueva Mano de Obra</a>
                <a href="{{ route('transports.create') }}" style="background: #06b6d4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">🚚 Nuevo Transporte</a>
            </div>
        </div>
    </div>
</div>
@endsection