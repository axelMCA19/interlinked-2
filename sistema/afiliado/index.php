<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location:../login.html');
    exit();
}
$conexion = new mysqli("localhost", "root", "", "sistema");


$usuario_id = $_SESSION['usuario_id']; // Cambia esto si usas otro sistema de sesión

$directorio = "perfiles/";
$imagen_predeterminada = $directorio . "predeterminado.png";
$imagen_actual = "";

// Verificamos si el usuario ya tiene una imagen subida (por ejemplo: usuario_5.jpg)
foreach (['jpg', 'jpeg', 'png', 'gif'] as $ext) {
    $ruta = $directorio . "usuario_" . $usuario_id . "." . $ext;
    if (file_exists($ruta)) {
        $imagen_actual = $ruta;
        break;
    }
}

// Si no hay imagen personalizada, usar la predeterminada
if (!$imagen_actual) {
    $imagen_actual = $imagen_predeterminada;
}

// SUBIR IMAGEN
if (isset($_POST['subir']) && isset($_FILES['imagen'])) {
    $archivo = $_FILES['imagen'];
    $nombre_temp = $archivo['tmp_name'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nueva_ruta = $directorio . "usuario_" . $usuario_id . "." . $extension;

    // Borrar antigua si existe y no es la predeterminada
    foreach (['jpg', 'jpeg', 'png', 'gif'] as $ext) {
        $vieja_ruta = $directorio . "usuario_" . $usuario_id . "." . $ext;
        if (file_exists($vieja_ruta)) {
            unlink($vieja_ruta);
        }
    }

    // Mover nueva
    move_uploaded_file($nombre_temp, $nueva_ruta);
    header("Location: ".$_SERVER['PHP_SELF']); // recargar
    exit();
}

// ELIMINAR IMAGEN
if (isset($_POST['eliminar'])) {
    foreach (['jpg', 'jpeg', 'png', 'gif'] as $ext) {
        $ruta = $directorio . "usuario_" . $usuario_id . "." . $ext;
        if (file_exists($ruta)) {
            unlink($ruta); // elimina la imagen personalizada
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- set the encoding of your site -->
	<meta charset="utf-8">
	<!-- set the viewport width and initial-scale on mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- set the apple mobile web app capable -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- set the HandheldFriendly -->
	<meta name="HandheldFriendly" content="True">
	<!-- set the apple mobile web app status bar style -->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!-- set the description -->
	<meta name="description" content="App Landing Page">
	<!-- set the Keyword -->
	<meta name="keywords" content="app, app landing, clean, landing, landing page, marketing, marketing landing, product, product landing, responsive, seo, startup landing ">
	<meta name="author" content="Vue Laboratories">
	<title>Interconectados afiliados</title>
	<!-- include the site stylesheet -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7COswald:400,700" rel="stylesheet">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/plugins.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/font-awesome.min.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../style.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/colors.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/responsive.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="../../css/gridgum.css">
	<style class="color_css"></style>
	<link rel="shortcut icon" href="../../logo.ico">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8380155752707218"
     crossorigin="anonymous"></script>
	 
</head>
<body>
	<!-- Wrapper of the page -->
	 
	<div id="wrapper">
		<!-- Header of the page -->
		<header id="header">
			<div class="container">
				<div class="holder center-block">
					<!-- Logo of the page -->
					<div class="logo">
						<a href="#">
							<img src="../../images/LOGO-WHITE-INK.svg" alt="Interconectados" class="light img-responsive width">
							<img src="../../images/LOGO-INK-DARK.svg"alt="Interconectados" class="dark img-responsive width">
						</a>
					</div>
					<!-- Logo of the page end -->
					<!-- Navbar of the page -->
					<nav class="navbar navbar-default">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<a href="../cerrar.php" class="btn btn-default btn-white"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
							<path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
							<path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
							</svg>  cerrar seción</a>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="../documentacion/index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-houses-fill" viewBox="0 0 16 16">
										<path d="M7.207 1a1 1 0 0 0-1.414 0L.146 6.646a.5.5 0 0 0 .708.708L1 7.207V12.5A1.5 1.5 0 0 0 2.5 14h.55a2.5 2.5 0 0 1-.05-.5V9.415a1.5 1.5 0 0 1-.56-2.475l5.353-5.354z"/>
										<path d="M8.793 2a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708z"/>
									  </svg>
									  Descargar documentación
								</a></li>
								<li><a href="../busquedaAfiliados/index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  Afiliados registrados
								</a></li>
								<li><a href="cambioC/index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  Cambiar contraseña
								</a></li>
								<li><a href="#" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  buscar
								</a></li>
								<li><a href="RutaAfiliado/index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  Editar mi ruta
								</a></li>
								<li><a href="verRuta/ver_ruta.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  Ver mi Ruta
								</a></li>
							</ul>
						</div>
					</nav>
					<!-- Navbar of the page end -->
				</div>
			</div>
		</header>
		<!-- Header of the page end -->
		<!-- Main of the page -->
		<main id="main">
			<!-- Hero area of the page -->
			<section class="hero-area text-center overlay" style="background-image: url(images/slide-1.jpg);" data-scroll-index="0">
				<div id="particles-js"></div>
				<div class="container">
					<div class="row">
						<header class="heading-holder col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
							<br>

							<body>
							<p>Bienvenido al Panel de Afiliado</p>
							<h1><?php echo $_SESSION['usuario_nombre']; ?></h1>
                                <div style="  width: 90vw;           /* ocupa el 90% del ancho de la pantalla */
                                              max-width: 300px;      /* nunca será más ancha que 400px */
                                              aspect-ratio: 5 / 7;   /* mantiene proporción vertical (5:7) */
                                              border-radius: 20%;
                                              overflow: hidden;
                                              border: 3px solid black;
                                              cursor: pointer;
                                              margin: 0 auto;        /* centra la imagen horizontalmente */
                                   ">
                                    <img id="fotoPerfil" src="<?= $imagen_actual ?>" alt="Perfil" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <div id="opcionesImagen" style="display: none; margin-bottom: 20px; color: black;">
                                    <form action="" method="POST" enctype="multipart/form-data" id="formCambiar">
                                        <input type="file" name="imagen" required><br><br>
                                        <button type="submit" name="subir" style="border-radius: 20%; font-weight: bold; padding: 5px;"><?= $imagen_actual === $imagen_predeterminada ? "Subir imagen" : "Cambiar imagen" ?></button>
                                    </form>
                                      <?php if ($imagen_actual !== $imagen_predeterminada): ?>
                                      <form action="" method="POST" id="formEliminar" onsubmit="return confirm('¿Eliminar tu foto de perfil?')">
										<br>
                                          <button type="submit" name="eliminar" style="border-radius: 20%; font-weight: bold; padding: 5px;">Eliminar imagen</button>
                                    </form>
                                      <?php endif; ?>
                               </div>
							    <script>
                                   const fotoPerfil = document.getElementById('fotoPerfil');
                                   const opciones = document.getElementById('opcionesImagen'); 
                                   fotoPerfil.addEventListener('click', () => {
                                       opciones.style.display = opciones.style.display === 'none' ? 'block' : 'none';
                                   });
                                </script>
                            </body>



							<br>
							<p>
								Bienvenido al <strong>panel de afiliado</strong> aqui podras acceder a tus datos de afiliado, y podras ver en tiempo real los afiliados de tu sindicato <strong><?php echo  $_SESSION['sindicato']; ?></strong>.

						    </p>
							<br>
						</header>
					</div>
					<div class="aligncenter">
					</div>
				</div>
			</section>
			<!-- Hero area of the page end -->
			<!-- Features area of the page -->
			<section class="features-area container" data-scroll-index="1">
				<div class="row">
					<header class="col-xs-12 heading-wrap col-sm-6 col-sm-offset-3 text-center">
						<h2><strong>DATOS DE AFILIADO</strong></h2>
					</header>
				</div>
				<!-- Features of the page -->
				<ul class="features-list">
					<li>
						<div class="icon-holder">
						</div>
						<h3>NOMBRES:</h3>
						<p><strong><?php echo $_SESSION['usuario_nombre'];?></strong></p>
					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>APELLIDOS:</h3>
						<p><strong><?php  echo $_SESSION['usuario_apellido'];?></strong></p>

					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>FEDERACIÓN:</h3>
						<p>Actualmente estas en la <strong><?php echo  $_SESSION['federacion'];?></strong></p>

					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>SINDICATO:</h3>
						<p>Actualmente estas afiliado al sindicato: "<strong><?php echo  $_SESSION['sindicato'];?></strong>"</p>

					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>CEDULA DE IDENTIDAD:</h3>
						<p>"<strong><?php  echo  $_SESSION['carnet'];?></strong>"</p>

					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>NUMERO DE AFILIADO:</h3>
						<p>afiliado "<strong><?php echo   $_SESSION['numeroA'];?></strong>" del sindicato "<strong><?php echo   $_SESSION['sindicato'];?></strong>"</p>


					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>CODIGO DE AFILIADO:</h3>
						<p>Tu codigo de acceso de afiliado: "<strong><?php echo   $_SESSION['codigo'];?></strong>"</p>


					</li>
					<li>
						<div class="icon-holder">
						</div>
						<h3>GENERO:</h3>
						<p>Genero: <?php  echo   $_SESSION['generos'];?></p>
					</li>
				</ul>
				<!-- Features of the page end -->
			</section>
			<!-- Features area of the page end -->
			<!-- Demo block of the page -->
			<aside class="demo-block">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-md-7">
							<h2>RECUERDA QUE NOSOTROS NO COMPARTIMOS TU INFORMACIÓN CON NADIE.</h2>
							<p>
								Todos tus datos estan enciptados nosotros no podemos acceder a tus datos sin tu concentimiento tu información y contraseñas estan estrictamente encriptados.
							</p>
						</div>
						<div class="col-xs-12 col-md-5">
							<ul>
								<li><a href="../documentacion/index.php" class="btn btn-default btn-white"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
									<path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z"/>
								  </svg> documentación</a></li>
							</ul>
						</div>
					</div>
				</div>
			</aside>
			<!-- Demo block of the page end -->
			<!-- Product Features of the page -->
			<section class="container product-features" data-scroll-index="2">
				<div class="row sameheight-container">
					<!-- Descr of the page -->
					<!-- Descr of the page end -->
					<!-- img holder of the page -->
					<!-- img holder of the page end -->
				</div>
			</section>
			<!-- Product Features of the page end -->
			<!-- Video block of the page -->
			<!-- <aside class="video-block" data-scroll-index="3">
				<div class="video overlay">
					<img src="images/2600-430.jpg" alt="image description" class="img-responsive">
					<a href="https://www.youtube.com/watch?v=XjDh_5ZH9wQ?autoplay=1" class="ico-play lightbox fancybox.iframe"></a>
				</div>
			</aside> -->
			<!-- Video block of the page end -->


			<!-- Trial block of the page -->
			<!-- Trial block of the page end -->
			<!-- Brands area of the page -->
			<!-- Brands area of the page end -->
		</main>
		<!-- Main of the page end -->
		<!-- Footer of the page -->
		<footer id="footer">
			<!-- Aside of the page -->
			<aside class="aside">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 text-center col-sm-6 col-sm-offset-3">
							<div class="logo"><a href="#"><img src="../../images/logo3.png" alt="mono"></a></div>
							<p>Transportarse con seguridad en un derecho fundamental y inprencindible</p>
							<!-- Social Networks of the page -->
							<ul class="social-networks">
								<li><a href="#"><span class="icon ico-facebook"></span></a></li>
								<li><a href="#"><span class="icon ico-twitter"></span></a></li>
								<li><a href="#"><span class="icon ico-google-plus"></span></a></li>
								<li><a href="#"><span class="icon ico-pinterest"></span></a></li>
								<li><a href="#"><span class="icon ico-icon1"></span></a></li>
							</ul>
							<!-- Social Networks of the page end -->
						</div>
					</div>
				</div>
			</aside>
			<!-- Aside of the page end -->
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-sm-offset-4 text-center">
						<p>&copy; Copyright 2024, <a class="white" href="https://gridgum.com">INTERLINKED</a>. <br>All Rights Reserved</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer of the page end -->
		<!-- Back Top of the page -->
    	<span id="back-top" class="fa fa-angle-up"></span>
  	<div id="loader" class="loader-holder">
			<div class="block"><img src="../../images/svg/hearts.svg" width="100" alt="loader"></div>
		</div>
	</div>
	<!-- Wrapper of the page end -->
	<!-- include jQuery -->
	<script src="../../js/jquery.js"></script>
	<!-- include jQuery -->
	<script src="../../js/plugins.js"></script>
	<!-- include jQuery -->
	<script src="../../js/jquery.main.js"></script>
	<!-- include jQuery -->
	<script src="../../js/particles.js"></script>
	<div id="style-changer" data-src="style-changer.html"></div>
</body>
</html>




