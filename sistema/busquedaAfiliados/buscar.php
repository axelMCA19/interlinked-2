<?php
session_start();
    include ("../conexion.php");
    // Crear la conexión
    $conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    if (isset($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        if (!empty($search)) {
            $sql = "SELECT * FROM usuarios WHERE nombres LIKE '%$search%' OR apellidos LIKE '%$search%'";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td class='" . (stripos($row['nombres'], $search) !== false ? 'resultado-destacado' : '') . "'>{$row['nombres']}</td>
                            <td class='" . (stripos($row['apellidos'], $search) !== false ? 'resultado-destacado' : '') . "'>{$row['apellidos']}</td>
                            <td>{$row['codigoA']}</td>
                            <td>{$row['federaciones']}</td>
                            <td>{$row['carnet']}</td>
                            <td>{$row['sindicato']}</td>
                            <td>{$row['numeroA']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron resultados.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Ingrese un nombre o apellido para buscar.</td></tr>";
        }
    }
    $conn->close();

?>
