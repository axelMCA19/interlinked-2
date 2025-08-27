<?php
include("../../conexion.php"); // Conexión a la base de datos
session_start();

// Modo público (token) o propio (sesión)
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM rutas WHERE token='$token'";
} elseif (isset($_SESSION['usuario_id'])) {
    $id_afiliado = $_SESSION['usuario_id'];
    $sql = "SELECT * FROM rutas WHERE id_afiliado=$id_afiliado";
} else {
    // No hay sesión ni token → pedir login
    header("Location: ../login.html");
    exit();
}

$ruta = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ubicación del Afiliado</title>
    <link rel="stylesheet" href="ver_ruta.css">
</head>
<body>
    <div class="ruta-container">
        <h2 class="ruta-titulo"><?= htmlspecialchars($ruta['titulo'] ?? 'Ruta del Afiliado') ?></h2>

        <?php if ($ruta): ?>
            <div class="mapa-wrapper">
                <?= $ruta['link_mapa'] ?> <!-- Solo mostrar iframe o link -->
            </div>
            <p class="ruta-tarifa">Tarifa: <?= htmlspecialchars($ruta['tarifa'] ?? '') ?></p>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <p style="text-align:center; font-size:0.9rem; color:#555;">
                    Puedes compartir esta ruta usando este link seguro:
                    <br>
                    <input type="text" readonly value="https://tusitio.com/ubicacion_compartida/ver_ruta.php?token=<?= $ruta['token'] ?>" style="width:100%; padding:5px; text-align:center;">
                </p>
            <?php endif; ?>

        <?php else: ?>
            <p>❌ Esta ruta aún no está disponible.</p>
        <?php endif; ?>
    </div>


    
</body>
</html>




