<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .success { background: #d4edda; color: #155724; padding: 15px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Test de Subida de Archivos</h1>
    
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('test.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Subir</button>
    </form>
</body>
</html>