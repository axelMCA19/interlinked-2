<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.html');
    exit();

}
// Datos de conexión a la base de datos
include("../../conexion.php");
// Crear la conexión
$conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para recuperar los datos
$sql = "SELECT nombres, apellidos FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Almacenar los datos en variables de sesión
    while($row = $result->fetch_assoc()) {
        $_SESSION['nombres'] = $row['nombres'];
        $_SESSION['apellidos'] = $row['apellidos'];
    }
} else {
    echo "0 results";
}
$conn->close();


?>

<!doctype html>
<html lang="en">
<head>
    <title>Certificado afiliados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="certificado.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <!-- Aquí iría la barra de navegación (navbar) -->
    </header>
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="card">
                        <!-- Encabezado de la tarjeta -->
                        <div class="card-header"><strong><h1 style="text-align: center;">FORMULARIO DE OBTENCIÓN DE CERTIFICADO</h1></strong></div>
                        <div class="card-body">
                            <!-- Formulario de solicitud -->
                            <form action="ejemplo.php" id="formularios" method="post">

                                <!-- Sección de datos personales -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Nombres:</strong></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="nombres"
                                                id="nombres"
                                                aria-describedby="helpId"
                                                value="<?php echo $_SESSION['usuario_nombre']; ?>"
                                                readonly
                                            />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Apellidos:</strong></label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="apellidos"
                                                id="apellidos"
                                                value="<?php echo $_SESSION['usuario_apellido']; ?>"
                                                readonly
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección de números de afiliación y carnet -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Numero de afiliado:</strong></label>
                                        <input
                                            type="Text"
                                            class="form-control"
                                            name="numeroA"
                                            id="numeroA"
                                            value="<?php echo $_SESSION['numeroA']; ?>"
                                            readonly
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Numero de carnet:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="carnet"
                                            id="carnet"
                                            value="<?php echo $_SESSION['carnet']; ?>"
                                        />
                                    </div>
                                </div>

                                <!-- Sección de código afiliado y sindicato -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Codigo afiliado:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="codigoA"
                                            id="codigoA"
                                            value="<?php echo $_SESSION['codigo']; ?>"
                                            readonly
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Sindicato:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="sindicato"
                                            id="sindicato"
                                            value="<?php echo $_SESSION['sindicato']; ?>"
                                            readonly
                                        />
                                    </div>
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Presidente de federación:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="presidenteF"
                                            id="presidenteF"
                                            value="<?php echo $_SESSION['nombres'] . ' ' . $_SESSION['apellidos']; ?>"
                                            readonly
                                        />
                                    </div>  
                                <!-- Sección de federación y fecha de solicitud -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Federación:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="federacion"
                                            id="federacion"
                                            value="<?php echo $_SESSION['federacion']; ?>"
                                            readonly
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Fecha SC:</strong></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="solicitud"
                                            id="solicitud"
                                            placeholder="fecha de solicitud"
                                            required
                                        />
                                    </div>
                                </div>

                                <!-- Sección de contraseña y confirmación de contraseña -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Contraseña:</strong></label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                name="password"
                                                id="password"
                                                placeholder="Contraseña"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Repetir contraseña:</strong></label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                name="confirmarContraseña"
                                                id="confirmarContraseña"
                                                placeholder="Repetir contraseña"
                                                required
                                            />
                                            <div class="invalid-feedback">¡Las contraseñas no coinciden!</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de envío y regreso -->
                                <div class="botones">
                                    <button type="submit" id="registrarme" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-add" viewBox="0 0 16 16">
                                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                                            <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
                                        </svg>Obtener certificado
                                    </button>
                                    <a href="../" id="iniciar" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                        </svg>Regresar
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- Pie de la tarjeta -->
                        <div class="card-footer text-muted"><p class="interlineado" style="text-align: center;">Interconectados</p></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- Aquí iría el pie de página -->
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
    <!-- Script adicional para validar contraseñas -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.getElementById("formularios").addEventListener('submit', function(event){
                var password = document.getElementById("password").value;
                var confirmarContraseña = document.getElementById("confirmarContraseña").value;
                
                // Verificación de las contraseñas
                if (password !== confirmarContraseña) {
                    document.getElementById("confirmarContraseña").classList.add('is-invalid');
                    event.preventDefault(); // Detenemos el envío del formulario
                } else {
                    document.getElementById("confirmarContraseña").classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>

