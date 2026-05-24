<!DOCTYPE html>
<html>
<head>
    <title>Importar APU</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px; }
        form { margin-top: 20px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input, button { padding: 10px; margin: 5px; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Importar Análisis de Precios Unitarios (APU)</h1>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <!-- IMPORTANTE: enctype="multipart/form-data" es CRUCIAL -->
    <form action="{{ route('apu.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Selecciona el archivo Excel:</label><br>
            <input type="file" name="file" accept=".xlsx,.xls" required>
        </div>
        <div>
            <button type="submit">Importar</button>
        </div>
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var fileInput = document.querySelector('input[name="file"]');
            if (!fileInput.files || !fileInput.files[0]) {
                alert('❌ Por favor selecciona un archivo');
                e.preventDefault();
                return;
            }
            console.log('Archivo a enviar:', fileInput.files[0].name);
        });
    </script>
</body>
</html>