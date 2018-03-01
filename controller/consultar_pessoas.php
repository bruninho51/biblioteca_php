<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CONSULTA DE PESSOAS CADASTRADAS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	require_once('../helper/helper.php');
	require_once('../model/Pessoa.php');

	//DEFININDO VÁRIAVEIS
	$titulo_pagina = "Consultar Pessoas";
	$link_css_pagina = "../view/css/consulta_pessoas.css";
	$btn_voltar = true;

	//CRIANDO OBJETO PESSOA QUE SERÁ USADO PARA OBTER TODOS OS LIVROS DO BANCO DE DADOS
	$objPessoa = new Pessoa();
	$pessoas = $objPessoa->pegarPessoas();
	
    require_once('../view/template/cabecario.php');
    require_once('../view/consulta_pessoas.php');
 ?>