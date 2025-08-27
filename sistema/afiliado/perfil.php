<?php
$conexion = new mysqli("localhost", "root", "", "sistema");
session_start();

// Simulamos ID del usuario. En producción, usar $_SESSION['usuario_id'].
$usuario_id = 1;

if (isset($_POST['subir'])) {
    $directorio = "perfiles/"; // Directorio relativo a perfil.php
    $archivo = $directorio . basename($_FILES["imagen"]["name"]);
    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

    $esImagen = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($esImagen !== false) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo)) {
            // Eliminar imagen anterior si existe
            $conexion->query("DELETE FROM fotos_perfil WHERE usuario_id = $usuario_id");
            // Guardar nueva ruta
            $conexion->query("INSERT INTO fotos_perfil (usuario_id, ruta_imagen) VALUES ($usuario_id, '$archivo')");
            echo "✅ Imagen subida con éxito.";
        } else {
            echo "❌ Error al subir la imagen.";
        }
    } else {
        echo "❌ El archivo no es una imagen.";
    }
}

if (isset($_POST['eliminar'])) {
    $result = $conexion->query("SELECT ruta_imagen FROM fotos_perfil WHERE usuario_id = $usuario_id");
    if ($row = $result->fetch_assoc()) {
        @unlink($row['ruta_imagen']);
        $conexion->query("DELETE FROM fotos_perfil WHERE usuario_id = $usuario_id");
        echo "🗑 Imagen eliminada.";
    }
}

$imagen_actual = null;
$result = $conexion->query("SELECT ruta_imagen FROM fotos_perfil WHERE usuario_id = $usuario_id");
if ($row = $result->fetch_assoc()) {
    $imagen_actual = $row['ruta_imagen'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Foto de Perfil</title>
</head>
<body>
    <h2>👤 Foto de Perfil</h2>

    <?php if ($imagen_actual): ?>
        <img src="<?= $imagen_actual ?>" alt="Perfil" width="150"><br><br>
    <?php else: ?>
        <p>No tienes una imagen de perfil.</p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="imagen" required><br><br>
        <button type="submit" name="subir"><?= $imagen_actual ? "Cambiar imagen" : "Subir imagen" ?></button>
        <?php if ($imagen_actual): ?>
            <button type="submit" name="eliminar" onclick="return confirm('¿Eliminar tu foto de perfil?')">Eliminar imagen</button>
        <?php endif; ?>
    </form>
</body>
</html>
