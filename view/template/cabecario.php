<!DOCTYPE html>
<html>	
	<head>
			<title><?php echo $titulo_pagina?></title>
			<meta charset="utf-8">
			<link rel="stylesheet" href="../view/css/estilo_principal.css">
			<link rel="stylesheet" href="<?php echo $link_css_pagina?>">
			<script src="../jquery-3.2.1.min.js"></script>
			<script src="../view/js/helper.js"></script>
			<script src="../view/js/valida.js"></script>
			<meta name="viewport" content="width=device-width, user-scalable=no">
		</head>
	<body>
		<div class="container">
			<header class="cabecario">
				<section class="titulo-site">
					<img class="logo" src="../view/img/logo.png">
					<h1>Sistema Bibliotecário</h1>	
				</section>
				
				<section class="botoes-menu">
					<nav>
						<?php if($btn_voltar == true):?>
							<img onclick="window.location.href='../index.php';" class="voltar" src="../view/img/voltar.png" width="32">
						<?php endif;?>
					</nav>
				</section>
			</header>