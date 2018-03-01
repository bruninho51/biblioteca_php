<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE EMPRÉSTIMOS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

    require_once('../helper/helper.php');
    require_once('../model/Livro.php');
    require_once('../model/Autor.php');
    require_once('../model/Pessoa.php');
    require_once('../model/Periodico.php');
    require_once('../model/MaterialEspecial.php');
    require_once('../model/TipoMaterialEspecial.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Empréstimo";
	$link_css_pagina = "../view/css/cadastra_emprestimo.css";
	$btn_voltar = true;

    //RESGATANDO LIVROS DO BANCO DE DADOS
    $livro = new Livro();
    $livros = $livro->pegarLivros();

    //RESGATANDO PESSOAS DO BANCO DE DADOS
    $pessoa = new Pessoa();
    $pessoas = $pessoa->pegarPessoas();

    //RESGATANDO PERIÓDICOS DO BANCO DE DADOS
    $periodico = new Periodico();
    $periodicos = $periodico->pegarPeriodicos();

    //RESGATANDO MATERIAIS ESPECIAIS DO BANCO DE DADOS
    $mat_especial = new MaterialEspecial();
    $mat_especiais = $mat_especial->pegarMateriaisEspeciais();
    
    require_once('../view/template/cabecario.php');
    require_once('../view/cadastra_emprestimo.php');
?>