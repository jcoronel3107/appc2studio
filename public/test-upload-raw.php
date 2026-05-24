<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    echo "POST data:\n";
    print_r($_POST);
    echo "\nFILES data:\n";
    print_r($_FILES);
    echo "</pre>";
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        echo "✅ Archivo recibido: " . $_FILES['file']['name'];
    } else if (isset($_FILES['file'])) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => "El archivo excede upload_max_filesize",
            UPLOAD_ERR_FORM_SIZE => "El archivo excede MAX_FILE_SIZE del formulario",
            UPLOAD_ERR_PARTIAL => "El archivo se subió parcialmente",
            UPLOAD_ERR_NO_FILE => "No se subió ningún archivo",
            UPLOAD_ERR_NO_TMP_DIR => "Falta carpeta temporal",
            UPLOAD_ERR_CANT_WRITE => "No se pudo escribir el archivo en disco",
            UPLOAD_ERR_EXTENSION => "Extensión de PHP detuvo la subida",
        ];
        $error_code = $_FILES['file']['error'];
        echo "❌ Error: " . ($errors[$error_code] ?? "Código $error_code");
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Test Upload Raw PHP</title></head>
<body>
    <h1>Prueba de subida con PHP puro</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Subir</button>
    </form>
</body>
</html>