<nav style="background: white; border-bottom: 1px solid #ccc; padding: 0 20px;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; height: 60px;">
        <a href="{{ route('dashboard') }}" style="font-weight: bold; font-size: 20px; color: #333; text-decoration: none;">
            📊 APU System
        </a>
        
        <div style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('apus.index') }}" style="color: #555; text-decoration: none;">APUs</a>
            <span style="color: #ccc;">|</span>
            <a href="{{ url('/importar') }}" style="color: #555; text-decoration: none;">Importar</a>
            <span style="color: #ccc;">|</span>
            <a href="{{ route('apus.summary') }}" style="color: #555; text-decoration: none;">Resumen</a>
            <span style="color: #ccc;">|</span>
            <a href="{{ route('export.apus') }}" style="color: #555; text-decoration: none;">Exportar</a>
            <span style="color: #ccc;">|</span>
            
            <div style="position: relative;">
                <button onclick="toggleMenu()" style="background: none; border: none; cursor: pointer; color: #555;">
                    👤 {{ Auth::user()->name ?? 'Usuario' }} ▼
                </button>
                <div id="user-menu" style="display: none; position: absolute; right: 0; top: 30px; background: white; border: 1px solid #ccc; border-radius: 5px; min-width: 120px;">
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 8px 12px; color: #333; text-decoration: none;">⚙️ Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="display: block; width: 100%; text-align: left; padding: 8px 12px; color: #d33; background: none; border: none; cursor: pointer;">
                            🚪 Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        var menu = document.getElementById('user-menu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    
    document.addEventListener('click', function(event) {
        var menu = document.getElementById('user-menu');
        var button = event.target.closest('button');
        if (!button || !button.textContent.includes('Usuario')) {
            menu.style.display = 'none';
        }
    });
</script>