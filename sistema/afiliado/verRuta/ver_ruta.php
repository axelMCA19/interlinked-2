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




<?php
// Consulta promedio y total
$sqlPromedio = "SELECT AVG(estrellas) AS promedio, COUNT(*) AS total 
                FROM reseñas 
                WHERE id_afiliado = $id_afiliado";
$resProm = $conn->query($sqlPromedio);
$data = $resProm->fetch_assoc();

$promedio = round($data['promedio'], 1);
$totalResenas = $data['total'];

// Obtener reseñas
$result = $conn->query("SELECT * FROM reseñas WHERE id_afiliado=$id_afiliado ORDER BY fecha DESC");
?>

<div class="reseñas-container">

    <!-- Promedio -->
    <div class="promedio-box">
        <?php if ($totalResenas > 0): ?>
            <h3><?= $promedio ?>/5.0</h3>
            <div class="estrellas">
                <?php
                $estrellasLlenas = floor($promedio);
                $mediaEstrella = ($promedio - $estrellasLlenas >= 0.5) ? 1 : 0;
                $estrellasVacias = 5 - $estrellasLlenas - $mediaEstrella;

                for ($i = 0; $i < $estrellasLlenas; $i++) echo "⭐";
                if ($mediaEstrella) echo "✨"; 
                for ($i = 0; $i < $estrellasVacias; $i++) echo "☆";
                ?>
            </div>
            <p><?= $totalResenas ?> reseñas en total</p>
        <?php else: ?>
            <p>Aún no hay reseñas, ¡sé el primero en comentar!</p>
        <?php endif; ?>
    </div>

    <!-- Lista de reseñas -->
    <div class="lista-reseñas">
        <?php while ($r = $result->fetch_assoc()): ?>
            <div class="reseña">
                <div class="reseña-header">
                    <strong><?= htmlspecialchars($r['nombre']) ?></strong>
                    <span><?= $r['estrellas'] ?>⭐</span>
                </div>
                <p><?= nl2br(htmlspecialchars($r['comentario'])) ?></p>
                <?php if ($r['foto']): ?>
                    <img src="<?= $r['foto'] ?>" alt="foto reseña">
                <?php endif; ?>
                <small><?= date("d/m/Y H:i", strtotime($r['fecha'])) ?></small>
            </div>
        <?php endwhile; ?>
    </div>

</div>
