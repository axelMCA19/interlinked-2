<?php
session_start();
include ("../../conexion.php");


// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos enviados por el formulario
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar que las nuevas contraseñas coinciden
    if ($new_password != $confirm_password) {
        die("Las nuevas contraseñas no coinciden.");
    }

    // Obtener el ID del usuario desde la sesión (esto asume que el usuario está logueado y su ID está almacenado en la sesión)
    $user_id = $_SESSION['usuario_id'];

    // Conectar a la base de datos


    $conn = new mysqli($direccionservidor, $usuarioBD, $contraseniaBD, $baseDatos);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verificar la contraseña actual
    $sql = "SELECT password FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_password);
    $stmt->fetch();

    // Verificar si la contraseña actual coincide
    if (!password_verify($current_password, $db_password)) {
        die("La contraseña actual es incorrecta.");
    }

    // Actualizar la contraseña en la base de datos
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE usuarios SET password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_password_hashed, $user_id);

    if ($update_stmt->execute()) {
        echo "Contraseña actualizada exitosamente.";
    } else {
        echo "Error al actualizar la contraseña.";
    }

    // Cerrar la conexión
    $stmt->close();
    $update_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        .password-wrapper {
            position: relative;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            input[type="password"], input[type="submit"] {
                padding: 8px;
            }
        }
    </style>
    <link rel="stylesheet" href="cambio.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Cambiar Contraseña</h2>
        <form action="" method="post">
            <label for="current_password" class="current_password">Contraseña Actual:</label>
            <div class="password-wrapper">
                <input type="password" id="current_password" name="current_password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('current_password')">&#x1F441;</span>
            </div>

            <label for="new_password" class="new_password">Nueva Contraseña:</label>
            <div class="password-wrapper">
                <input type="password" id="new_password" name="new_password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('new_password')">&#x1F441;</span>
            </div>

            <label for="confirm_password" class="confirm_password">Confirmar Nueva Contraseña:</label>
            <div class="password-wrapper">
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">&#x1F441;</span>
            </div>

            <input type="submit" value="Cambiar Contraseña">
        </form>
    </div>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
