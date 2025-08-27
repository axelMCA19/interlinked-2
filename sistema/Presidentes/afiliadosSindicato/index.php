<?php

session_start();
// Establecer conexión a la base de datos
include ("../../conexion.php");

$conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variable de sesión $session_sindicato (asegúrate de haberla inicializado previamente)
$session_sindicato = $_SESSION['sindicato'];

// Si se enviaron datos por POST (cuando se realiza una edición y se envía el formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recorremos cada registro para actualizar los cambios
    foreach ($_POST['id'] as $key => $id) {
        $nombres = mysqli_real_escape_string($conn, $_POST['nombres'][$key]);
        $apellidos = mysqli_real_escape_string($conn, $_POST['apellidos'][$key]);
        $carnet = mysqli_real_escape_string($conn, $_POST['carnet'][$key]);
        $sindicato = mysqli_real_escape_string($conn, $_POST['sindicato'][$key]);

        // Consulta SQL para actualizar el registro
        $sql_update = "UPDATE usuarios SET nombres='$nombres', apellidos='$apellidos', carnet='$carnet', sindicato='$sindicato' WHERE id='$id'";
        $conn->query($sql_update);
    }
    // Redireccionar o mostrar un mensaje de éxito si se desea
    // header("Location: tu_pagina.php");
    // exit();
}

// Consulta SQL para obtener los afiliados del sindicato actual y contarlos
$sql = "SELECT * FROM usuarios WHERE sindicato = '$session_sindicato'";
$result = $conn->query($sql);

// Contar el número de afiliados
$num_afiliados = $result->num_rows;
?>



<!doctype html>
<html lang="en">
    <head>
        <title>Afiliados Sindicato</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    <style>
        
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('searchInput');
            var userTableBody = document.getElementById('userTableBody');
            var noResults = document.getElementById('noResults');

            searchInput.addEventListener('input', function() {
                var searchText = searchInput.value.trim().toUpperCase();
                var rows = userTableBody.getElementsByTagName('tr');
                var hasResults = false;

                Array.from(rows).forEach(function(row) {
                    var nombres = row.cells[1].getElementsByTagName('input')[0].value.toUpperCase();
                    var apellidos = row.cells[2].getElementsByTagName('input')[0].value.toUpperCase();

                    if (nombres.includes(searchText) || apellidos.includes(searchText)) {
                        row.style.display = '';
                        hasResults = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (hasResults) {
                    noResults.style.display = 'none';
                } else {
                    noResults.style.display = 'block';
                }
            });

            Array.from(userTableBody.getElementsByTagName('input')).forEach(function(input) {
                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            });
        });
    </script>
    <link rel="stylesheet" href="registroAfiliadoSindicato.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            
    <h1>Bienvenido, Sr Pdte <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>.</h1>
    <p>Aquí podrás gestionar los datos de todos tus afiliados de tu sindicato <strong><?php echo htmlspecialchars($_SESSION['sindicato']); ?></strong> </p>
    <p>Aqui podras llevar un control exacto de todos tus afiliados y podras modificar si es nesesario su (nombres,apellidos,carnet,sindicato)</p>
    <p>Afiliados total: <?php echo $num_afiliados; ?></p>
    <p><a
        name=""
        id=""
        class="btn btn-primary"
        href="../registroAS/registroAS.php"
        role="button"
        >Registrar afiliado</a
    >
    </p>

    <input type="text" id="searchInput" placeholder="Buscar por nombre o apellido">
    <p id="noResults" style="display:none;">No se encontraron coincidencias</p>

    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Carnet</th>
                    <th>Sindicato</th>
                    <th>Código A</th>
                    <th>Federaciones</th>
                    <th>Número A</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td><input type='text' name='nombres[]' value='" . htmlspecialchars($row['nombres']) . "'></td>";
                        echo "<td><input type='text' name='apellidos[]' value='" . htmlspecialchars($row['apellidos']) . "'></td>";
                        echo "<td><input type='text' name='carnet[]' value='" . htmlspecialchars($row['carnet']) . "'></td>";
                        echo "<td><input type='text' name='sindicato[]' value='" . htmlspecialchars($row['sindicato']) . "'></td>";
                        echo "<td>" . htmlspecialchars($row['codigoA']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['federaciones']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['numeroA']) . "</td>";
                        echo "<input type='hidden' name='id[]' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron afiliados para este sindicato.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <input type="submit" value="Guardar cambios">
    </form>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>





<?php
$conn->close();
?>
