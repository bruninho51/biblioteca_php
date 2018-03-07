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
    require_once('../model/Emprestimo.php');

	//VARIÁVEIS PARA A VIEW
	$gravado = false;
	$erro = array();
	$titulo_pagina = "Cadastrar Empréstimo";
	$link_css_pagina = "../view/css/cadastra_emprestimo.css";
	$btn_voltar = true;

    
    if(!empty($_POST)){
		if(validacao($_POST, $erro)){
			gravarEmprestimo($_POST, $erro, $gravado);
		}
	}


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



    function validacao($post, &$erro){
		$id_pessoa = $post['id_pessoa'];
        $data_devolucao = $post['data_devolucao'];
        $items_emprestimo = $post['item_emprestimo'];
        
        //CHECANDO SE DATA É VÁLIDA
        $split_data_devolucao = explode("-", $data_devolucao);
        if(!checkdate($split_data_devolucao[1],$split_data_devolucao[2],$split_data_devolucao[0])){
            return false;
        }
        
        //CHECANDO SE ITEMS EXISTEM
        foreach($items_emprestimo as $item_emprestimo){
            $s_it_emp = explode(".", $item_emprestimo);
            switch ($s_it_emp[0]){
                case 'isbn':
                    if(!Livro::existeLivro($s_it_emp[1])){
                        return false;
                    }
                break;
                    
                case 'issn':
                    if(!Periodico::existePeriodico($s_it_emp[1])){
                        return false;
                    }
                break;
                    
                case 'id':
                    if(!MaterialEspecial::existeMaterialEspecial($s_it_emp[1])){
                        return false;
                    }
                break;
            }
            
            //CHECANDO SE PESSOA EXISTE
            if(!Pessoa::existePessoa($id_pessoa)){
                return false;
            }
            
            return true;
        }
        
        
	}


	function gravarEmprestimo($post, &$erro, &$gravado){
        $emprestimo = new Emprestimo();
        $p = new Pessoa();
        $p->id = (int) $post['id_pessoa'];
        $emprestimo->pessoa = $p;
        $emprestimo->dataDevolucao = $post['data_devolucao'];
        foreach($post['item_emprestimo'] as $item){
            $arr_item = explode('.', $item);
            switch ($arr_item[0]){
                case 'isbn':
                    $livro = new Livro();
                    $livro->isbn = $arr_item[1];
                    $emprestimo->materiais = $livro;
                break;
                
                case 'issn':
                    $periodico = new Periodico();
                    $periodico->issn = $arr_item[1];
                    $emprestimo->materiais = $periodico;
                break;
                
                case 'id':
                    $mat_especial = new MaterialEspecial();
                    $mat_especial->id = (int) $arr_item[1];
                    $emprestimo->materiais = $mat_especial;
                break;
            }
        }
        
        if($emprestimo->gravar()){
            $gravado = true;
            return true;
        }else{
            $erro = $emprestimo->erro;
        }
        
    }

?>