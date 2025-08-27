<?php
session_start(); // Asegúrate de iniciar la sesión al principio del archivo
include("../../conexion.php");

// Crear conexión
$conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de actualización si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Recorrer los datos enviados y actualizar la base de datos
    foreach ($_POST['id'] as $key => $id) {
        // Obtener y limpiar los datos
        $id = mysqli_real_escape_string($conn, $id);
        $nombres = mysqli_real_escape_string($conn, $_POST['nombres'][$key]);
        $apellidos = mysqli_real_escape_string($conn, $_POST['apellidos'][$key]);
        $carnet = mysqli_real_escape_string($conn, $_POST['carnet'][$key]);
        $sindicato = mysqli_real_escape_string($conn, $_POST['sindicato'][$key]);

        // Convertir a mayúsculas
        $nombres = strtoupper($nombres);
        $apellidos = strtoupper($apellidos);
        $sindicato = strtoupper($sindicato);

        // Query SQL para actualizar los datos en la tabla 'presidentes'
        $update_sql = "UPDATE presidentes SET nombres='$nombres', apellidos='$apellidos', carnet='$carnet', sindicato='$sindicato' WHERE id='$id'";

        // Ejecutar la consulta de actualización
        if ($conn->query($update_sql) === TRUE) {
            echo "Datos actualizados correctamente.";
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    }
}

// Consulta SQL para seleccionar todos los datos de la tabla 'presidentes'
$sql_all = "SELECT * FROM presidentes";
$result_all = $conn->query($sql_all);

// Contenedor centrado
echo "<div style='text-align: center;'>";

// Título y mensaje introductorio con ciudad de la sesión
echo "<h1>Bienvenido " . htmlspecialchars($_SESSION['usuario_nombre']) . ".</h1>";
echo "<p>Aquí podrás gestionar los datos de tus presidentes en " . htmlspecialchars($_SESSION['ciudad']) . ".</p>";
echo "<p>Recuerda que solo puedes actualizar los sgt datos (Nombres,Apellidos,carnet,sindicato)</p>";


// Mostrar el formulario de búsqueda por nombre y la tabla completa
echo "<input type='text' id='searchInput' placeholder='Buscar por nombre'>";
echo "<div id='searchResults'></div>";

echo "<div style='overflow-x:auto; display: inline-block; text-align: left;'>";
echo "<form method='post'>";
echo "<table border='1' style='width: 100%; margin: auto;'>";
echo "<thead>
        <tr>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Código PS</th>
          <th>Federaciones</th>
          <th>Carnet</th>
          <th>Sindicato</th>
          <th>Número PS</th>
          <th>Acción</th>
        </tr>
      </thead>";
echo "<tbody id='presidentesTableBody'>";

// Mostrar los datos en la tabla completa
while ($row = $result_all->fetch_assoc()) {
    echo "<tr>
            <td><input type='text' value='" . htmlspecialchars($row['nombres']) . "' name='nombres[]' oninput='this.value = this.value.toUpperCase()'></td>
            <td><input type='text' value='" . htmlspecialchars($row['apellidos']) . "' name='apellidos[]' oninput='this.value = this.value.toUpperCase()'></td>
            <td><input type='text' value='" . htmlspecialchars($row['codigoPS']) . "' name='codigoPS[]' readonly></td>
            <td><input type='text' value='" . htmlspecialchars($row['federaciones']) . "' name='federaciones[]' readonly></td>
            <td><input type='text' value='" . htmlspecialchars($row['carnet']) . "' name='carnet[]'></td>
            <td><input type='text' value='" . htmlspecialchars($row['sindicato']) . "' name='sindicato[]' oninput='this.value = this.value.toUpperCase()'></td>
            <td><input type='text' value='" . htmlspecialchars($row['numeroPS']) . "' name='numeroPS[]' readonly></td>
            <td><input type='hidden' name='id[]' value='" . $row['id'] . "'>
                <button type='submit'>Guardar</button></td>
          </tr>";
}

echo "</tbody>";
echo "</table>";
echo "</form>";
echo "</div>";
echo "</div>";

// Liberar resultado
$result_all->free();

// Cerrar conexión
$conn->close();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener el campo de búsqueda por nombre
    var searchInput = document.getElementById('searchInput');
    // Obtener el contenedor donde se mostrarán los resultados
    var searchResults = document.getElementById('searchResults');
    // Obtener el cuerpo de la tabla de presidentes
    var presidentesTableBody = document.getElementById('presidentesTableBody');

    // Manejar el evento 'input' en el campo de búsqueda
    searchInput.addEventListener('input', function() {
        var searchText = searchInput.value.trim().toUpperCase();
        var resultsHtml = '';

        // Recorrer cada fila de la tabla de presidentes
        Array.from(presidentesTableBody.rows).forEach(function(row) {
            var nombresCell = row.cells[0].getElementsByTagName('input')[0].value.toUpperCase();
            var apellidosCell = row.cells[1].getElementsByTagName('input')[0].value.toUpperCase();

            // Verificar si el nombre o apellido coincide con el texto de búsqueda
            if (nombresCell.includes(searchText) || apellidosCell.includes(searchText)) {
                row.style.display = ''; // Mostrar la fila
            } else {
                row.style.display = 'none'; // Ocultar la fila si no coincide
            }
        });

        // Mostrar mensaje si no hay resultados
        var visibleRows = Array.from(presidentesTableBody.rows).filter(function(row) {
            return row.style.display !== 'none';
        });

        if (visibleRows.length === 0) {
            searchResults.innerHTML = "<p>Usuario no registrado o criterios no encontrados</p>";
        } else {
            searchResults.innerHTML = ""; // Limpiar el mensaje si hay resultados
        }
    });

    // Convertir automáticamente a mayúsculas al escribir en nombres y apellidos
    Array.from(presidentesTableBody.rows).forEach(function(row) {
        var nombresInput = row.cells[0].getElementsByTagName('input')[0];
        var apellidosInput = row.cells[1].getElementsByTagName('input')[0];
        var sindicatoInput = row.cells[5].getElementsByTagName('input')[0];

        nombresInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        apellidosInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        sindicatoInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
});
</script>
