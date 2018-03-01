<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE AUTORES E CONTROLAR O CADASTRO POPUP DA PÁGINA DE
    * CADASTRO DE MATERIAIS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

    require_once('../helper/helper.php');
	require_once('../model/Autor.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Autor";
	$link_css_pagina = "../view/css/cadastra_autores.css";
	$btn_voltar = true;

	if(!empty($_POST)){
        
		if(validacao($_POST, $erro)){
            
			gravarAutor($_POST, $erro, $gravado);
		}
	}

    //VERIFICA SE A REQUISIÇÃO VEIO PELA JANELA DE ADICIONAMENTO RÁPIDO NA PÁGINA DE CADASTRAR MATERIAIS
    if(isset($_POST['popup'])){
        header('Location:cadastrar_material.php');
        //SE NÃO FOR, A REQUISIÇÃO VEIO DA PÁGINA DE CADASTRO DE AUTORES. ESTA SERÁ CARREGADA
    }else{
        require_once('../view/template/cabecario.php');
        require_once('../view/cadastra_autores.php');
    }
	

	function validacao($post, &$erro){
        //ARRAY COM OS NOMES DOS CAMPOS
        $array = array('nome_autor','sobrenome_autor');
        //FOREACH PERCORRERÁ O ARRAY...
        foreach($array as $campo){
            //VERIFICARÁ SE CAMPOS EXISTEM...
            if(isset($post[$campo])){
                //E SE ESTÃO VAZIOS...
                if(!empty($post[$campo])){
                    //DEPOIS VERIFICARÁ SE CAMPOS FORAM PREENCHIDOS DE FORMA CORRETA...
                    switch($campo){
                        case 'nome_autor':
                            if(!(strlen($post[$campo]) <= 50)){
                                echo 'erro na validacao do campo ' . $campo;
                                $erro[$campo] = 'O campo deve ter no máximo 50 caracteres!';
                                return false;
                            }
                        break;
                        
                        case 'sobrenome_autor':
                            if(!(strlen($post[$campo]) <= 50)){
                                $erro = 'O campo deve ter no máximo 50 caracteres!';
                                return false;
                            }
                        break;
                        
                        default:
                        break;
                    }
                }else{
                    $erro[$campo] = 'Campo obrigatório';
                }
            }else{
                $erro[$campo] = 'Campo obrigatório';
            }
        }
        
        if(empty($erro)){
            return true;
        }else{
            return false;
        }
        
	}

	function gravarAutor($post, &$erro, &$gravado){
		//DECLARANDO AUTOR
        echo 'gravar autor acionado';
		$autor = new Autor(); 
		//ATRIBUINDO VALORES PARA ATRIBUTOS DO AUTOR
		$autor->nome = $post['nome_autor'];
		$autor->sobrenome = $post['sobrenome_autor'];

		//GRAVANDO EDITORA NO BANCO DE DADOS
		if(empty($autor->erro)){
			if($autor->gravar()){
				echo 'autor gravado';
				$gravado = true;
			}else{
				echo 'autor nao gravado';
				$erro = $autor->erro;
				
			}
		}else{
            echo 'autor nao gravado! Erro ocorrido';
			$erro = $autor->erro;
		}
	}    
?>