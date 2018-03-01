<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE PESSOAS E CONTROLAR O CADASTRO POPUP DA PÁGINA DE
    * CADASTRO DE EMPRÉSTIMOS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	require_once('../helper/helper.php');
	require_once('../model/Pessoa.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Pessoa";
	$link_css_pagina = "../view/css/cadastra_pessoa.css";
	$btn_voltar = true;
	$erro = array();
	$gravado = false;

	if(!empty($_POST)){
		if(validacao($_POST, $erro)){

			gravarPessoa($_POST, $erro, $gravado);
		}
	}

    //VERIFICA SE A REQUISIÇÃO VEIO PELA JANELA DE ADICIONAMENTO RÁPIDO NA PÁGINA DE CADASTRAR MATERIAIS
    if(isset($_POST['popup'])){
        header('Location:cadastrar_material.php');
        //SE NÃO FOR, A REQUISIÇÃO VEIO DA PÁGINA DE CADASTRO DE PESSOAS. ESTA SERÁ CARREGADA
    }else{
        require_once('../view/template/cabecario.php');
        require_once('../view/cadastra_pessoa.php');    
    }

	function validacao(&$post, &$erro){

		$nomeCampos = array("nome_pessoa","telefone_pessoa", "cpf_pessoa");

		//FOREACH PERCORRERÁ O ARRAY COM OS NOMES DOS CAMPOS...
		foreach ($nomeCampos as $chave => $valor) {
			//E PROCURARÁ ESSES NOMES NOS ÍNDICES DO $_POST PARA VER SE TODOS ESTÃO LÁ...

			$res = array_search($valor, array_keys($post));
			//SE UM NOME NÃO FOR ENCONTRADO...
			if((string) $res == ""){
				//ERRO DE CAMPO OBRIGATÓRIO(CAMPO NÃO FOI ENVIADO VIA POST)
				$erro[$valor] = "Campo obrigatório!";

			}else{
				//SE O CAMPO FOI ENVIADO, MAS ESTIVER VAZIO...

				if(empty($post[array_keys($post)[$res]])){
					//ERRO DE CAMPO OBRIGATÓRIO(CAMPO ENVIADO MAS NÃO PREENCHIDO)
					$erro[$valor] = "Campo obrigatório!";
				}
			}
				
		}

		if(empty($erro)){

			$post['cpf_pessoa'] = soNumeros($post['cpf_pessoa']);
			$post['telefone_pessoa'] = soNumeros($post['telefone_pessoa']);

			return true;
		}else{
			return false;
		}

	}

	function gravarPessoa($post, &$erro, &$gravado){
		//DECLARANDO PESSOA
		$pessoa = new Pessoa(); 
		//ATRIBUINDO VALORES PARA ATRIBUTOS DA PESSOA
		$pessoa->cpf = $post['cpf_pessoa'];
		$pessoa->nome = $post['nome_pessoa'];
		$pessoa->telefone = $post['telefone_pessoa'];

		//GRAVANDO PESSOA NO BANCO DE DADOS
		if(empty($pessoa->erro)){
			if($pessoa->gravar()){
				$gravado = true;

			}else{
				$erro = $pessoa->erro;

			}
		}else{
			$erro = $pessoa->erro;

		}
	}


?>