<?php
session_start();
include("../../conexion.php"); // Ajusta la ruta a tu conexion.php
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html"); // si no está logueado, redirige al login
    exit();
}

$id_afiliado = $_SESSION['usuario_id'];


// Guardar o actualizar ruta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $mapa = mysqli_real_escape_string($conn, $_POST['mapa']);
    $tarifa = mysqli_real_escape_string($conn, $_POST['tarifa']);

    // Verificar si ya existe ruta para este afiliado
    $check = $conn->query("SELECT id FROM rutas WHERE id_afiliado = $id_afiliado");

    if ($check->num_rows > 0) {
        // Actualizar
        $conn->query("UPDATE rutas 
                      SET titulo='$titulo', link_mapa='$mapa', tarifa='$tarifa' 
                      WHERE id_afiliado=$id_afiliado");
    } else {
        // Insertar nueva
        $conn->query("INSERT INTO rutas (id_afiliado, titulo, link_mapa, tarifa) 
                      VALUES ($id_afiliado, '$titulo', '$mapa', '$tarifa')");
    }
    echo "<p style='color:green;'>✅ Ruta guardada correctamente.</p>";
}

// Traer ruta existente para mostrar en el formulario
$ruta = $conn->query("SELECT * FROM rutas WHERE id_afiliado=$id_afiliado")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar / Editar Ruta</title>
    <link rel="stylesheet" href="RutaAfiliado.css">
</head>
<body>
    
    <div class="ruta-container">
        <h2 class="ruta-titulo">Registrar / Editar Ruta</h2>

        <form method="post" class="ruta-form">
            <label>Título de la ruta:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($ruta['titulo'] ?? '') ?>" required>

            <label>Link o iframe de Google Maps:</label>
            <textarea name="mapa" rows="4" required><?= htmlspecialchars($ruta['link_mapa'] ?? '') ?></textarea>

            <label>Tarifa aproximada:</label>
            <input type="text" name="tarifa" value="<?= htmlspecialchars($ruta['tarifa'] ?? '') ?>" required>

            <button type="submit" class="btn-guardar">Guardar</button>
        </form>

        <?php if ($ruta): ?>
            <div class="preview">
                <h3 class="ruta-subtitulo">Vista previa:</h3>
                <div class="mapa-wrapper">
                    <?= $ruta['link_mapa'] ?>
                </div>
                <p class="ruta-tarifa">Tarifa: <?= htmlspecialchars($ruta['tarifa'] ?? '') ?></p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
