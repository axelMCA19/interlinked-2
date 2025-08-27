<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location:login.html');
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
	<title>Interlin</title>
	<!-- include the site stylesheet -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7COswald:400,700" rel="stylesheet">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/plugins.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="style.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/colors.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/responsive.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="css/gridgum.css">
	<style class="color_css"></style>
	<link rel="shortcut icon" href="logo.ico">
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
							<img src="../../../images/logo3.png" alt="Mono" class="light img-responsive width">
							<img src="../../../images/logo-dark1.png" alt="mono" class="dark img-responsive width">
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
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="../index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-houses-fill" viewBox="0 0 16 16">
										<path d="M7.207 1a1 1 0 0 0-1.414 0L.146 6.646a.5.5 0 0 0 .708.708L1 7.207V12.5A1.5 1.5 0 0 0 2.5 14h.55a2.5 2.5 0 0 1-.05-.5V9.415a1.5 1.5 0 0 1-.56-2.475l5.353-5.354z"/>
										<path d="M8.793 2a1 1 0 0 1 1.414 0L12 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l1.854 1.853a.5.5 0 0 1-.708.708L15 8.207V13.5a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 4 13.5V8.207l-.146.147a.5.5 0 1 1-.708-.708z"/>
									  </svg>
									  Inicio
								</a></li>
								<li><a href="../../busquedaAfiliados/index.php" >
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
										<path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
										<path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
									  </svg>
									  Afiliados registrados.
								</a></li>
								<li><a href="../../../IndexCarpetas/Ayuda y asistencia/ayuda.html">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
										<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
									  </svg>
									Ayuda y asistencia
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
							<br>
							<br>
							<h1>Documentación de <?php echo $_SESSION['usuario_nombre']; ?></h1>
							<p>
								Aqui podras acceder a tus documentos de verificación.
						    </p>
							<br>
							<p><strong>Certificado</strong>: <a style="color: white;" href="certificado/certificado.php">Clic aqui para obtener tu Certificado</a></p>
							<p><strong>Credencial</strong>: <a style="color: white;" href="credencial/credencial.php">Clic aqui para obtener tu Credencial</a></p>
							<p><strong>Carnet</strong>: <a style="color: white;" href="carnet/carnet.php">Clic aqui para obtener tu Carnet</a></p>
							<p><strong>Contrato AS</strong>: <a style="color: white;" href="contratoAdquisicionServicio/contrato-p-s.php">Clic aqui para obtener tu cotrato de adquisicion de servicios</a></p>
						</header>
					</div>
					<div class="aligncenter">
					</div>
				</div>
			</section>
			<!-- Hero area of the page end -->
			<!-- Features area of the page -->
	
			<!-- Features area of the page end -->
			<!-- Demo block of the page -->
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
							<div class="logo"><a href="#"><img src="../../../images/logo3.png" alt="mono"></a></div>
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
						<p>&copy; Copyright 2024, <a class="white" href="https://gridgum.com">INTERLINK</a>. <br>All Rights Reserved</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer of the page end -->
		<!-- Back Top of the page -->
    	<span id="back-top" class="fa fa-angle-up"></span>
    	<div id="loader" class="loader-holder">
			<div class="block"><img src="../../../images/svg/hearts.svg" width="100" alt="loader"></div>
		</div>
	</div>
	<!-- Wrapper of the page end -->
	<!-- include jQuery -->
	<script src="js/jquery.js"></script>
	<!-- include jQuery -->
	<script src="js/plugins.js"></script>
	<!-- include jQuery -->
	<script src="js/jquery.main.js"></script>
	<!-- include jQuery -->
	<script src="js/particles.js"></script>
	<div id="style-changer" data-src="style-changer.html"></div>
</body>
</html>