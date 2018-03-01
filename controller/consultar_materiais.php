<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CONSULTA DE MATERIAIS CADASTRADOS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	require_once('../helper/helper.php');
	require_once('../model/Editora.php');
	require_once('../model/Autor.php');
	require_once('../model/Livro.php');

	//DEFININDO VÁRIAVEIS
	$titulo_pagina = "Consultar Materiais";
	$link_css_pagina = "../view/css/consulta_materiais.css";
	$btn_voltar = true;

	//CRIANDO OBJETO LIVRO QUE SERÁ USADO PARA OBTER TODOS OS LIVROS DO BANCO DE DADOS
	$objLivro = new Livro();
	$livros = $objLivro->pegarLivros();
	
    require_once('../view/template/cabecario.php');
    require_once('../view/consulta_materiais.php');
?>
