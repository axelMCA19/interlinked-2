<?php
session_start();
if ($_SERVER['REQUEST_METHOD']=="POST") {
    include ("conexión.php");

    $errores= array();
    //print_r($_POST);

    $email=(isset($_POST['email']))?htmlspecialchars($_POST['email']):null;
    $password=(isset($_POST['password']))?$_POST['password']:null;

    
    if (empty($email)) {
        $errores['email']=  "Debes Ingresar tu correo electrónico";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email']="El formato de correo electrónico no es válido";
}
if (empty($password)) {
    $errores['password']="la contraseña es obligatoria";
}


if (empty($errores)) {
    try {
        $pdo= new PDO('mysql:host='.$direccionservidor.';dbname='.$baseDatos,$usuarioBD,$contraseniaBD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // para que el PDO maneje los errores de manera automatica 

        $sql="SELECT * FROM usuarios WHERE email=:email ";
        $sentencia=$pdo->prepare($sql);
        $sentencia->execute(['email'=>$email]);

        $usuarios= $sentencia->fetchAll(PDO::FETCH_ASSOC);
        //print_r($usuarios);

        $login=false;


        foreach ($usuarios as $user) {
            if(password_verify($password,$user["password"])){
        //los valores que estan despues del igual en los corchetes son de la base de datos
                $_SESSION['usuario_id']= $user['id'];
                $_SESSION['usuario_nombre']=$user['nombres'];
                $login=true;
            }
        }



        if ($login) {
            echo "existe el usuario en la base datos";
            header("Location:index.php");
        }else {
            echo "El usuario y contraseña no estan registrados";
        }

    } catch (PDOException $e) {
    }
}else {
    foreach($errores as $errror){
        echo "<br>" .$errror."<br>";
        
    }
    echo "<br><a href='login.html'>regresar al inicio de seción</a>";
}


}

?>