<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CONSULTA DE EMPRÉSTIMOS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	$titulo_pagina = "Empréstimos Realizados";
	$link_css_pagina = "../view/css/emprestimos_realizados.css";
	$btn_voltar = true;
    require_once('../view/template/cabecario.php');
    require_once('../view/emprestimos_realizados.php');
?>
