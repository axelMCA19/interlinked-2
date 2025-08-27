<?php 
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../../conexion.php");

    $errores = array();
    $successes = false;

    $nombres = isset($_POST['nombres']) ? mb_strtoupper($_POST['nombres'], 'UTF-8') : null;
    $apellidos = isset($_POST['apellidos']) ? mb_strtoupper($_POST['apellidos'], 'UTF-8') : null;
    $codigoA = isset($_POST['codigoA']) ? $_POST['codigoA'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confirmarContraseña = isset($_POST['confirmarContraseña']) ? $_POST['confirmarContraseña'] : null;

    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $federaciones = isset($_POST['federaciones']) ? $_POST['federaciones'] : null;

    $carnet = isset($_POST['carnet']) ? $_POST['carnet'] : null;
    $sindicato = isset($_POST['sindicato']) ? $_POST['sindicato'] : null;
    $numeroA = isset($_POST['numeroA']) ? $_POST['numeroA'] : null;

    if (empty($nombres)) {
        $errores['nombres'] = "Debes ingresar tus nombres";
    }
    if (empty($apellidos)) {
        $errores['apellidos'] = "Debes ingresar tus apellidos";
    }
    if (empty($codigoA)) {
        $errores['codigoA'] = "Debes ingresar tu código de afiliado";
    }
    if (empty($genero)) {
        $errores['genero'] = "Debes ingresar tu género";
    }
    if (empty($federaciones)) {
        $errores['federaciones'] = "Debes ingresar la federación a la que quieres pertenecer";
    }

    // Validación de contraseña
    if (empty($password)) {
        $errores['password'] = "La contraseña es obligatoria";
    }
    if (empty($confirmarContraseña)) {
        $errores['confirmarContraseña'] = "Debes confirmar tu contraseña";
    } elseif ($password != $confirmarContraseña) {
        $errores['confirmarContraseña'] = "Las contraseñas no coinciden";
    }

    // Validación específica para mensaje de error personalizado
    if (!empty($errores)) {
        if (empty($nombres)) {
            $errores['nombres'] = "Debes ingresar tus nombres en mayúsculas";
        }
        if (empty($apellidos)) {
            $errores['apellidos'] = "Debes ingresar tus apellidos en mayúsculas";
        }
        if (empty($sindicato)) {
            $errores['sindicato'] = "Debes ingresar el sindicato en mayúsculas";
        }
    }

    foreach ($errores as $error) {
        echo "<br>" . $error . "<br>";
    }

    if (empty($errores)) {
        try {
            $pdo = new PDO('mysql:host=' . $direccionservidor . ';dbname=' . $baseDatos, $usuarioBD, $contraseniaBD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para que el PDO maneje los errores de manera automática

            // Verificar si el código de afiliado está disponible
            $sql = "SELECT * FROM codigos_afiliados WHERE codigo = :codigo AND estado = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':codigo' => $codigoA]);
            $codigoDisponible = $stmt->fetch();

            if ($codigoDisponible) {
                $nuevoPassword = password_hash($password, PASSWORD_DEFAULT);

                // Verificar si el usuario ya existe con el mismo correo electrónico
                $sql_user_exists = "SELECT * FROM usuarios WHERE carnet = :carnet";
                $stmt_user_exists = $pdo->prepare($sql_user_exists);
                $stmt_user_exists->execute([':carnet' => $carnet]);
                $userExists = $stmt_user_exists->fetch();

                if ($userExists) {
                    echo "El usuario ya está registrado con este correo electrónico.";
                } else {
                    $sql_insert = "INSERT INTO usuarios (nombres, apellidos, codigoA, password, genero, federaciones, carnet, sindicato, numeroA) 
                        VALUES (:nombres, :apellidos,  :codigoA, :password, :genero, :federaciones,  :carnet, :sindicato, :numeroA)";
                    $stmt_insert = $pdo->prepare($sql_insert);
                    $stmt_insert->execute([
                        ':nombres' => $nombres,
                        ':apellidos' => $apellidos,
                        ':codigoA' => $codigoA,
                        ':password' => $nuevoPassword,
                        ':genero' => $genero,
                        ':federaciones' => $federaciones,
                        ':carnet' => $carnet,
                        ':sindicato' => $sindicato,
                        ':numeroA' => $numeroA,
                    ]);

                    // Actualizar el estado del código de afiliado
                    $sql_update = "UPDATE codigos_afiliados SET estado = 1 WHERE codigo = :codigo";
                    $stmt_update = $pdo->prepare($sql_update);
                    $stmt_update->execute([':codigo' => $codigoA]);

                    $successes = true;
                }
            } else {
                echo "Código de afiliado no válido o ya usado.";
            }
        } catch (PDOException $e) {
            echo 'Error al conectar con la base de datos: ' . $e->getMessage();
        }
    } else {
        echo "No se han registrado los datos. Comuníquese con Axel.";
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Registro afiliado</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="../logo.ico">
    <link rel="stylesheet" href="registroA.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
</head>
<body>
    <header>
    </header>
    <main>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    
                    <!-- Mostrar mensajes de éxito o error -->
                    <?php if (isset($successes) && $successes) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>¡Afiliado registrado correctamente!</strong> Felicidades has registrado a un nuevo afiliado a tu ciudad <?php echo $_SESSION['ciudad'];?>! clic 
                            <a
                                name=""
                                id=""
                                class="btn btn-primary"
                                href="../ListasAF/index.php"
                                role="button"
                                >aqui</a
                            >
                            para poder ver tus afiliados
                        </div>
                    <?php } elseif (isset($successes) && !$successes) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>¡El registro falló! debido a que intentas registrar un codigo ya usado o no disponible o a que ya tienes registro revisa tus datos o comunicate con axel</strong> <?php echo isset($error_message) ? $error_message : ''; ?>
                        </div>
                    <?php } ?>
                    
                    <!-- Formulario de registro -->
                    <div class="card">
                        <div class="card-header"><h3 style="text-align: center;"><strong>Formulario de registro de afiliado</strong></h3></div>
                        <p class="parrafo">Bienvenido sr presidente <?php echo $_SESSION['usuario_nombre'];?> aqui podras registrar a tus afiliados</p>
                        <div class="card-body">
                            <form action="registro.php" id="formularios" method="post">
                                
                                <!-- Campos de nombres y apellidos -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Nombres:</strong></label>
                                            <input type="text" class="form-control" name="nombres" id="nombres" aria-describedby="helpId" required oninput="this.value = this.value.toUpperCase()" placeholder="Nombre" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Apellidos:</strong></label>
                                            <input type="text" class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId" required oninput="this.value = this.value.toUpperCase()" placeholder="Apellido" />
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Campos de número de afiliado y carnet -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Numero de afiliado</strong></label>
                                        <input type="Text" class="form-control" name="numeroA" id="numeroA" required placeholder="N° afiliado" />
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Numero de carnet:</strong></label>
                                        <input type="text" class="form-control" name="carnet" id="carnet" required placeholder="CI" />
                                    </div>
                                </div>
                                
                                <!-- Campos de código afiliado y sindicato -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Codigo afiliado:</strong></label>
                                        <input type="text" class="form-control" name="codigoA" id="codigoA" aria-describedby="helpId" required placeholder="Codigo afiliado" />
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-label"><strong>Sindicato:</strong></label>
                                        <input type="text" class="form-control" name="sindicato" id="sindicato" placeholder="sindicato" required oninput="this.value = this.value.toUpperCase()"/>
                                    </div>
                                </div>
                                
                                <!-- Campos de género y federaciones -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="genero" class="form-label"><strong>Genero:</strong></label>
                                        <select class="form-select" name="genero" id="genero" required>
                                            <option value="">Seleccione su genero</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select> 
                                    </div>
                                    <div class="col">
                                        <label for="federaciones" class="form-label"><strong>Federaciones:</strong></label>
                                        <select class="form-select" name="federaciones" id="federaciones" required>
                                            <option value="">Elija su federación</option>
                                            <option value="1era-federación">1era-federación</option>
                                            <option value="2da-federación">2da federación</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Campos de contraseña y repetir contraseña -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Contraseña:</strong></label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="" class="form-label"><strong>Repetir contraseña:</strong></label>
                                            <input type="password" class="form-control" name="confirmarContraseña" id="confirmarContraseña" placeholder="Repetir contraseña" required />
                                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones para registrar e iniciar sesión -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="submit" id="registrarme" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-add" viewBox="0 0 16 16">
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                                                <path d="M12.096 6.223A5 5 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.5 4.5 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-.813-.927Q8.378 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.6 4.6 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10q.393 0 .774-.024a4.5 4.5 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777M3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4"/>
                                            </svg> Registrar afiliado
                                        </button>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="card-footer text-muted"><p class="interlineado" style="text-align: center;">INTERCONECTADOS</p></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    <footer>
    </footer>
    
    <!-- Bootstrap y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    <!-- Validación de contraseña -->
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







