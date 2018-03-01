<?php 
    /* @author BRUNO MENDES PIMENTA
    * ESSE CONTROLADOR É RESPONSÁVEL POR FORMAR A PÁGINA
    * DE CADASTRO DE MATERIAIS.
    * ELE FAZ A CONEXÃO DAS VIEWS COM AS MODELS
    */

	require_once('../helper/helper.php');
	require_once('../model/Editora.php');
	require_once('../model/Autor.php');
	require_once('../model/Livro.php');
    require_once('../model/Periodico.php');
    require_once('../model/MaterialEspecial.php');
    require_once('../model/TipoMaterialEspecial.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Material";
	$link_css_pagina = "../view/css/cadastra_material.css";
	$btn_voltar = true;

	if(!empty($_POST)){
		if(validacao($_POST, $erro)){
			gravarMaterial($_POST, $erro, $gravado);
		}
	}

	//RESGATANDO EDITORAS DO BANCO DE DADOS
	$objEditora = new Editora();
	$editoras = $objEditora->pegarEditoras();

	//RESGATANDO AUTORES DO BANCO DE DADOS
	$objAutor = new Autor();
	$autores = $objAutor->pegarAutores();

    //RESGATANDO TIPOS DE MATERIAL ESPECIAL DO BANCO DE DADOS
	$objTipoMaterial = new TipoMaterialEspecial();
	$tipos_material_especial = $objTipoMaterial->pegarTiposMaterialEspecial();

	require_once('../view/template/cabecario.php');
	require_once('../view/cadastra_material.php');

	function validacao($post, &$erro){
		if(isset($post['tipo_material_escolhido'])){
			switch ($post['tipo_material_escolhido']) {
				case 'livro':
					if(validacaoLivro($post, $erro)){
						return true;
					}else{
						return false;
					}
					break;

				case 'material-especial':
					   if(validacaoMaterialEspecial($post, $erro)){
                           return true;
                       }else{
                           return false;
                       }
					break;

				case 'periodico':
					if(validacaoPeriodico($post, $erro)){
                        return true;
                    }else{
                        return false;
                    }
					break;
				
				default:
					$erro['tipo_material_escolhido'] = "Material não definido!";
					break;
			}
		}else{
            return false;
            $erro['tipo_material_escolhido'] = 'Tipo de material não informado ao servidor!';
        }
        
	}

	function validacaoLivro($post, &$erro){
		//CRIA UM ARRAY COM OS NOMES DOS CAMPOS
		$nomeCampos = array("isbn_livro","editora_livro","ano_livro","volume_livro","edicao_livro","titulo_absi","estante_absi","exemplares_absi","codigobarras_absi","autores");

		//FOREACH PERCORRERÁ O ARRAY COM OS NOMES DOS CAMPOS...
		foreach ($nomeCampos as $chave => $valor) {
			//E PROCURARÁ ESSES NOMES NOS ÍNDICES DO $_POST PARA VER SE TODOS ESTÃO LÁ...
			$res = array_search($valor, array_keys($post));
			//SE UM NOME NÃO FOR ENCONTRADO...
			if($res == false || $res == 0 || $res == ""){
				//ERRO DE CAMPO OBRIGATÓRIO(CAMPO NÃO FOI ENVIADO VIA POST)
				$erro[$valor] = "Campo obrigatório!";
				//echo "$valor com erro! Resultado = $res";
			}else{
				//SE O CAMPO FOI ENVIADO, MAS ESTIVER VAZIO...
				//echo '>>>>>>>>>'.$res.'<<<<<<<<<<';
				if(empty($post[array_keys($post)[$res]])){
					//ERRO DE CAMPO OBRIGATÓRIO(CAMPO ENVIADO MAS NÃO PREENCHIDO)
					$erro[$valor] = "Campo obrigatório!";
				}
			}
		}
		//SE $erro ESTIVER VAZIO...
		if(empty($erro)){
			//RETORNA VERDADEIRO! OS CAMPOS EXISTEM E NÃO ESTÃO NULOS...
			return true;	
		}else{
			//SE NÃO, RETORNA FALSO!
			return false;
		}
		
	}

    function validacaoPeriodico($post, &$erro){
		//CRIA UM ARRAY COM OS NOMES DOS CAMPOS
		$nomeCampos = array("issn_periodico","ano_periodico","volume_periodico","titulo_absi","estante_absi","exemplares_absi","codigobarras_absi");

		//FOREACH PERCORRERÁ O ARRAY COM OS NOMES DOS CAMPOS...
		foreach ($nomeCampos as $chave => $valor) {
			//E PROCURARÁ ESSES NOMES NOS ÍNDICES DO $_POST PARA VER SE TODOS ESTÃO LÁ...
			$res = array_search($valor, array_keys($post));
			//SE UM NOME NÃO FOR ENCONTRADO...
			if($res == false || $res == 0 || $res == ""){
				//ERRO DE CAMPO OBRIGATÓRIO(CAMPO NÃO FOI ENVIADO VIA POST)
				$erro[$valor] = "Campo obrigatório!";
				//echo "$valor com erro! Resultado = $res";
			}else{
				//SE O CAMPO FOI ENVIADO, MAS ESTIVER VAZIO...
				//echo '>>>>>>>>>'.$res.'<<<<<<<<<<';
				if(empty($post[array_keys($post)[$res]])){
					//ERRO DE CAMPO OBRIGATÓRIO(CAMPO ENVIADO MAS NÃO PREENCHIDO)
					$erro[$valor] = "Campo obrigatório!";
				}
			}
		}
		//SE $erro ESTIVER VAZIO...
		if(empty($erro)){
			//RETORNA VERDADEIRO! OS CAMPOS EXISTEM E NÃO ESTÃO NULOS...
			return true;	
		}else{
			//SE NÃO, RETORNA FALSO!
			return false;
		}
		
	}

    function validacaoMaterialEspecial($post, &$erro){
		//CRIA UM ARRAY COM OS NOMES DOS CAMPOS
		$nomeCampos = array("tipo_material_especial","titulo_absi","estante_absi","exemplares_absi","codigobarras_absi");

		//FOREACH PERCORRERÁ O ARRAY COM OS NOMES DOS CAMPOS...
		foreach ($nomeCampos as $chave => $valor) {
			//E PROCURARÁ ESSES NOMES NOS ÍNDICES DO $_POST PARA VER SE TODOS ESTÃO LÁ...
			$res = array_search($valor, array_keys($post));
			//SE UM NOME NÃO FOR ENCONTRADO...
			if($res == false || $res == 0 || $res == ""){
				//ERRO DE CAMPO OBRIGATÓRIO(CAMPO NÃO FOI ENVIADO VIA POST)
				$erro[$valor] = "Campo obrigatório!";
				//echo "$valor com erro! Resultado = $res";
			}else{
				//SE O CAMPO FOI ENVIADO, MAS ESTIVER VAZIO...
				//echo '>>>>>>>>>'.$res.'<<<<<<<<<<';
				if(empty($post[array_keys($post)[$res]])){
					//ERRO DE CAMPO OBRIGATÓRIO(CAMPO ENVIADO MAS NÃO PREENCHIDO)
					$erro[$valor] = "Campo obrigatório!";
				}
			}
		}
		//SE $erro ESTIVER VAZIO...
		if(empty($erro)){
			//RETORNA VERDADEIRO! OS CAMPOS EXISTEM E NÃO ESTÃO NULOS...
			return true;	
		}else{
			//SE NÃO, RETORNA FALSO!
			return false;
		}
    }

	function gravarMaterial($post, &$erro, &$gravado){
        
        if($post['tipo_material_escolhido'] == 'livro'){
            //DECLARANDO LIVRO
            $livro = new Livro(); 
            //ATRIBUINDO VALORES PARA ATRIBUTOS DO LIVRO
            $livro->isbn = $post['isbn_livro'];
            $livro->ano = (int) $post['ano_livro'];
            $livro->volume = (int) $post['volume_livro'];
            $livro->edicao = (int) $post['edicao_livro'];

            //CRIANDO OBJETO EDITORA
            $editora_livro = new Editora();
            $editora_livro->id = (int) $post['editora_livro'];
            //COLOCANDO EDITORA NO OBJETO LIVRO
            $livro->editora = $editora_livro;

            //CAMPOS DO ABSTRACTINFORMACIONAL
            $livro->titulo = $_POST['titulo_absi'];
            $livro->codBarras = $_POST['codigobarras_absi'];
            $livro->estante = (int) $_POST['estante_absi'];
            $livro->exemplares = (int) $_POST['exemplares_absi'];
            $livro->disponiveis = (int) $_POST['exemplares_absi'];

            //COLOCANDO AUTORES NO LIVRO
            $autores = array();
            foreach ($_POST['autores'] as $autor_id) {
                $autor = new Autor();
                $autor->id = (int) $autor_id;
                $livro->autores = $autor;
            }

            //GRAVANDO LIVRO NO BANCO DE DADOS
            if(empty($livro->erro)){
                if($livro->gravar()){
                    $gravado = true;
                }else{
                    $erro = $livro->erro;
                }
            }else{
                $erro = $livro->erro;
            }    
        }
        
        if($post['tipo_material_escolhido'] == 'periodico'){
            //DECLARANDO PERIODICO
            $periodico = new Periodico(); 
            //ATRIBUINDO VALORES PARA ATRIBUTOS DO PERIODICO
            $periodico->issn = $post['issn_periodico'];
            $periodico->ano = (int) $post['ano_periodico'];
            $periodico->volume = (int) $post['volume_periodico'];
            $periodico->descricao = $post['descricao_periodico'];

            //CAMPOS DO ABSTRACTINFORMACIONAL
            $periodico->titulo = $_POST['titulo_absi'];
            $periodico->codBarras = $_POST['codigobarras_absi'];
            $periodico->estante = (int) $_POST['estante_absi'];
            $periodico->exemplares = (int) $_POST['exemplares_absi'];
            $periodico->disponiveis = (int) $_POST['exemplares_absi'];

            //GRAVANDO PERIODICO NO BANCO DE DADOS
            //SE ERRO ESTIVER VAZIO...
            if(empty($periodico->erro)){
                //PERIODICO TENTARÁ SER GRAVADO...
                if($periodico->gravar()){
                   
                    $gravado = true;
                }else{
                   
                    $erro = $periodico->erro;
                    
                }
            }else{
                $erro = $periodico->erro;
            }
        }
        
        if($post['tipo_material_escolhido'] == 'material-especial'){
            //DECLARANDO MATERIAL ESPECIAL
            $material_especial = new MaterialEspecial(); 
            //ATRIBUINDO VALORES PARA ATRIBUTOS DO MATERIAL ESPECIAL
            
            //DECLARANDO TIPO DE MATERIAL ESPECIAL E ATRIBUINDO ID
            $tipo_mat = new TipoMaterialEspecial();
            $tipo_mat->id = (int) $post['tipo_material_especial'];
            //MANDANDO TIPO MATERIAL ESPECIAL SE COMPLETAR
            $tipo_mat->pegarTiposMaterialEspecial($tipo_mat->id);
            //ATRIBUINDO TIPO AO MATERIAL ESPECIAL
            $material_especial->tipo = $tipo_mat;
            
            $material_especial->descricao = $post['descricao_material_especial'];

            //CAMPOS DO ABSTRACTINFORMACIONAL
            $material_especial->titulo = $_POST['titulo_absi'];
            $material_especial->codBarras = $_POST['codigobarras_absi'];
            $material_especial->estante = (int) $_POST['estante_absi'];
            $material_especial->exemplares = (int) $_POST['exemplares_absi'];
            $material_especial->disponiveis = (int) $_POST['exemplares_absi'];

            //GRAVANDO MATERIAL ESPECIAL NO BANCO DE DADOS
            //SE ERRO ESTIVER VAZIO...
            if(empty($material_especial->erro)){
                //PERIODICO TENTARÁ SER GRAVADO...
                if($material_especial->gravar()){
                   
                    $gravado = true;
                }else{
                   
                    $erro = $material_especial->erro;
                    
                }
            }else{
                $erro = $material_especial->erro;
            }
        }
		
	}
	

?>