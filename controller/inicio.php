<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * INICIAL DO SISTEMA WEB.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	$titulo_pagina = "Sistema Bibliotecário";
	$link_css_pagina = "../view/css/inicio.css";
	$btn_voltar = false;
    require_once('../view/template/cabecario.php');
    require_once('../view/inicio.php');
?>
