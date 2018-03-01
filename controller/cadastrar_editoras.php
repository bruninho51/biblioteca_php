<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE EDITORAS E CONTROLAR O CADASTRO POPUP DA PÁGINA DE
    * CADASTRO DE MATERIAIS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

    require_once('../helper/helper.php');
	require_once('../model/Editora.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Editora";
	$link_css_pagina = "../view/css/cadastra_editoras.css";
	$btn_voltar = true;

	if(!empty($_POST)){
        
		if(validacao($_POST, $erro)){
            
			gravarEditora($_POST, $erro, $gravado);
		}
	}

    //VERIFICA SE A REQUISIÇÃO VEIO PELA JANELA DE ADICIONAMENTO RÁPIDO NA PÁGINA DE CADASTRAR MATERIAIS
    if(isset($_POST['popup'])){
        header('Location:cadastrar_material.php');
        //SE NÃO FOR, A REQUISIÇÃO VEIO DA PÁGINA DE CADASTRO DE EDITORAS. ESTA SERÁ CARREGADA
    }else{
        require_once('../view/template/cabecario.php');
        require_once('../view/cadastra_editoras.php');    
    }
	

	function validacao($post, &$erro){
        //ARRAY COM OS NOMES DOS CAMPOS
        $array = array('nome_editora','tipo_editora');
        //FOREACH PERCORRERÁ O ARRAY...
        foreach($array as $campo){
            //VERIFICARÁ SE CAMPOS EXISTEM...
            if(isset($post[$campo])){
                //E SE ESTÃO VAZIOS...
                if(!empty($post[$campo])){
                    //DEPOIS VERIFICARÁ SE CAMPOS FORAM PREENCHIDOS DE FORMA CORRETA...
                    switch($campo){
                        case 'nome_editora':
                            if(strlen($post[$campo]) <= 50){
                                return true;
                            }else{
                                $erro[$campo] = 'O campo deve ter no máximo 50 caracteres!';
                                return false;
                            }
                        break;
                        
                        case 'tipo_editora':
                            if($post[$campo] == '0' || $post[$campo] == '1'){
                                return true;
                            }else{
                                $erro = 'Valor informado incorreto!';
                                return false;
                            }
                        break;
                        
                        default:
                        break;
                    }
                }else{
                    $erro[$campo] = 'Campo obrigatório';
                    return false;
                }
            }else{
                $erro[$campo] = 'Campo obrigatório';
                return false;
            }
        }
        
	}

	function gravarEditora($post, &$erro, &$gravado){
		//DECLARANDO EDITORA
		$editora = new Editora(); 
		//ATRIBUINDO VALORES PARA ATRIBUTOS DA EDITORA
		$editora->nome = $post['nome_editora'];
		$editora->tipo = (int) $post['tipo_editora'];

		//GRAVANDO EDITORA NO BANCO DE DADOS
		if(empty($editora->erro)){
			if($editora->gravar()){
				
				$gravado = true;
			}else{
				
				$erro = $editora->erro;
				
			}
		}else{
			$erro = $editora->erro;
		}
	}    
?>