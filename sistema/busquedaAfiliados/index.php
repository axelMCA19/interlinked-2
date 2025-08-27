<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.html');
    exit();

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Afiliados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="busquedaAfiliado.css">

    <style>
    </style>
    <script>
        function buscar() {
            let input = document.getElementById('search').value;
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('resultados').innerHTML = this.responseText;
                }
            };

            // Verificar si el campo de búsqueda está vacío
            if (input.trim() === '') {
                document.getElementById('resultados').innerHTML = '';
                return; // Salir de la función si no hay texto de búsqueda
            }

            xhr.open("GET", "buscar.php?search=" + input, true);
            xhr.send();
        }
    </script>
    <link rel="stylesheet" href="busqueda.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1>Buscar Afiliados</h1>
        <p >Bienvenido <?php echo $_SESSION['usuario_nombre']; ?> aqui podras verificar afiliados verificados.</p>
        <form onsubmit="return false;">
            <label for="search">Buscar por nombre o apellido:</label>
            <input type="text" id="search" onkeyup="buscar()" oninput="this.value = this.value.toUpperCase()" style="color: black;">
        </form>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>CodigoA</th>
                    <th>Federaciones</th>
                    <th>Carnet</th>
                    <th>Sindicato</th>
                    <th>NumeroA</th>
                </tr>
            </thead>
            <tbody id="resultados">
                <!-- Aquí se insertarán los resultados de la búsqueda -->
            </tbody>
        </table>
    </div>
</body>
</html>
