<?php
// Conexión a la base de datos
    include ("../conexion.php");
    $conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);
    
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Consulta para obtener los usuarios y contar el total de registros
$sql = "SELECT * FROM usuarios WHERE nombres LIKE '%$searchTerm%' OR apellidos LIKE '%$searchTerm%'";
$result = $conn->query($sql);

$sqlCount = "SELECT COUNT(*) as total FROM usuarios";
$countResult = $conn->query($sqlCount);
$countRow = $countResult->fetch_assoc();
$total = $countRow['total'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
</head>
<body>
    <h1>Usuarios</h1>
    <p>Total de registros: <?php echo $total; ?></p>
    <form method="post">
        <input type="text" name="search" placeholder="Buscar por nombres o apellidos" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <input type="submit" value="Buscar">
    </form>
    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nombres']) . "</td>
                            <td>" . htmlspecialchars($row['apellidos']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
