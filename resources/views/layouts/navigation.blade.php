<nav style="background: white; border-bottom: 1px solid #e5e7eb; padding: 0 20px;">
    <div style="max-width: 1280px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; height: 64px;">
        <!-- Logo -->
        <div style="display: flex; align-items: center;">
            <a href="{{ route('dashboard') }}" style="font-weight: bold; font-size: 20px; color: #1f2937; text-decoration: none;">
                📊 APU System
            </a>
        </div>
        
        <!-- Menú principal -->
        <div style="display: flex; align-items: center; gap: 24px;">
            @auth
                <!-- APUs -->
                <a href="{{ url('/apus') }}" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                    📋 APUs
                </a>
                
                <!-- Importar -->
                <a href="{{ url('/importar') }}" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                    📤 Importar
                </a>
                
                <!-- Resumen -->
                <a href="{{ url('/apu-summary') }}" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                    📊 Resumen
                </a>
                
                <!-- Exportar -->
                <a href="{{ url('/exportar-apus') }}" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                    💾 Exportar
                </a>
                
                <!-- Separador -->
                <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                
                <!-- Presupuestos -->
                <a href="{{ url('/budgets') }}" style="color: #8b5cf6; text-decoration: none; padding: 8px 0;">
                    📋 Presupuestos
                </a>
                <a href="{{ url('/budgets/create-chapter') }}" style="color: #22c55e; text-decoration: none; padding: 8px 0;">
                    📝 Nuevo Presupuesto
                </a>
                
                <!-- Separador -->
                <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                
                <!-- Solo admin: Clientes -->
                @if(Auth::user()->is_admin)
                    <a href="{{ url('/admin/tenants') }}" style="color: #8b5cf6; text-decoration: none; padding: 8px 0;">
                        🏢 Clientes
                    </a>
                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                @endif
                
                <!-- Menú de usuario -->
                <div style="position: relative;">
                    <button onclick="toggleMenu()" style="display: flex; align-items: center; gap: 8px; background: none; border: none; cursor: pointer; color: #374151; padding: 8px; font-size: 16px;">
                        <span>👤 {{ Auth::user()->name ?? 'Usuario' }}</span>
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="user-menu" style="display: none; position: absolute; right: 0; top: 40px; min-width: 160px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; padding: 8px 0;">
                        <a href="{{ url('/profile') }}" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none; border-bottom: 1px solid #e5e7eb;">
                            ⚙️ Perfil
                        </a>
                        <form method="POST" action="{{ url('/logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 16px; color: #ef4444; background: none; border: none; cursor: pointer;">
                                🚪 Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none;">Iniciar Sesión</a>
                <a href="{{ route('register') }}" style="color: #22c55e; text-decoration: none;">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        var menu = document.getElementById('user-menu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }
    
    document.addEventListener('click', function(event) {
        var menu = document.getElementById('user-menu');
        var button = event.target.closest('button');
        if (!button || !button.textContent.includes('{{ Auth::user()->name ?? "Usuario" }}')) {
            if (menu) {
                menu.style.display = 'none';
            }
        }
    });
</script>