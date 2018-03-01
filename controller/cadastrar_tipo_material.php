<?php
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE TIPOS DE MATERIAIS ESPECIAIS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

    require_once('../helper/helper.php');
	require_once('../model/TipoMaterialEspecial.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Tipo de Material Especial";
	$link_css_pagina = "../view/css/cadastra_tipo_material.css";
	$btn_voltar = false;

	if(!empty($_POST)){
        
		if(validacao($_POST, $erro)){
            
			gravarTipoMaterial($_POST, $erro, $gravado);
		}
	}

    //VERIFICA SE A REQUISIÇÃO VEIO PELA JANELA DE ADICIONAMENTO RÁPIDO NA PÁGINA DE CADASTRAR MATERIAIS
    if(isset($_POST['popup'])){
        header('Location:cadastrar_material.php');
        //SE NÃO FOR, A REQUISIÇÃO VEIO DA PÁGINA DE CADASTRO DE TIPOS DE MATERIAIS ESPECIAIS. ESTA SERÁ CARREGADA
    }else{
        require_once('../view/template/cabecario.php');
        require_once('../view/cadastra_tipo_material.php');    
    }
	

	function validacao($post, &$erro){
        //ARRAY COM OS NOMES DOS CAMPOS
        $array = array('nome_tipo_material');
        //FOREACH PERCORRERÁ O ARRAY...
        foreach($array as $campo){
            //VERIFICARÁ SE CAMPOS EXISTEM...
            if(isset($post[$campo])){
                //E SE ESTÃO VAZIOS...
                if(!empty($post[$campo])){
                    //DEPOIS VERIFICARÁ SE CAMPOS FORAM PREENCHIDOS DE FORMA CORRETA...
                    switch($campo){
                        case 'nome_tipo_material':
                            if(strlen($post[$campo]) <= 50){
                                return true;
                            }else{
                                $erro[$campo] = 'O campo deve ter no máximo 50 caracteres!';
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

	function gravarTipoMaterial($post, &$erro, &$gravado){
		//DECLARANDO EDITORA
		$tipo_material = new TipoMaterialEspecial(); 
		//ATRIBUINDO VALORES PARA ATRIBUTOS DE TIPO MATERIAL
		$tipo_material->nome = $post['nome_tipo_material'];

		//GRAVANDO TIPO DE MATERIAL ESPECIAL NO BANCO DE DADOS
		if(empty($tipo_material->erro)){
            echo 'Nenhum erro...<br>';
			if($tipo_material->gravar()){
				echo 'Material gravado!<br>';
                
				$gravado = true;
			}else{
				
				$erro = $tipo_material->erro;
				
			}
		}else{
			$erro = $tipo_material->erro;
		}
	}    
?>