<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA EDITORA
     */

	require_once('../model/DAO.php');

	class Editora{
        /*
        *RECEBE O ID DA EDITORA
        @access private 
        @name $id
        */
		private $id;
        /*
        *RECEBE O NOME DA EDITORA
        @access private
        @name $nome
        */
		private $nome;
        /*
        *RECEBE O TIPO DA EDITORA(NACIONAL(0)/INTERNACIONAL(1))
        @access private 
        @name $tipo
        */
		private $tipo;
        /*
        *RECEBE OS ERROS QUE PODEM OCORRER NO OBJETO
        @access private
        @name $erro
        */
        private $erro;

		function __get($property){
				return $this->$property;
		}

		function __set($property, $value){
				switch ($property) {
					case 'id':
						if(gettype($value) == "integer" ){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: id deve receber um inteiro.");
			   			}	
					break;
					
					case 'nome':
						if(gettype($value) == "string" && strlen($value) <= 50){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: nome deve receber uma string.");
			   			}
					break;
					
					case 'tipo':
						if(gettype($value) == "integer" && ($value == 0 || $value == 1)){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: tipo deve receber o valor 0(nacional) ou 1(internacional).");
			   			}
					break;
					
					default:
						throw new Exception("Erro: a propriedade $property não existe.");
					break;
				}
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR PEGAR EDITORAS DO BANCO DE DADOS
        * @access public
        * @param Integer $id
        * @return mixed
        */ 
		function pegarEditoras($id = false){
			$conexao = DAO::conexaoMySQLi();
			//SE ID NÃO FOR INFORMADO...
			if($id == false){
				//SELECT SELECIONARÁ TODOS OS REGISTROS...
				$sql = 'SELECT * FROM editora';
			}else{
				//SE FOR INFORMADO SELECIONARÁ SÓ UM
				$sql = 'SELECT * FROM editora WHERE id = ' . $id;
			}

			//EXECUTANDO QUERY SQL
			$res = $conexao->query($sql);

			//SE ID FOI INFORMADO...
			if(!$id == false){
				//REGISTRO SERÁ PEGO E GUARDADO NO PRÓPRIO OBJETO
				$row = $res->fetch_assoc();
				$this->id = (int) $row['id'];
				$this->nome = $row['nome'];
				$this->tipo = $row['tipo'];
			}else{
				//SE NÃO FOI INFORMADO, A FUNÇÃO RETORNARÁ UM ARRAY COM OS REGISTROS
				$editoras = array();
				while ($row = $res->fetch_assoc()) {
					$editora = new Editora();
					$editora->id = $row['id'];
					$editora->nome = $row['nome'];
					$editora->tipo = $row['tipo'];
					array_push($editoras, $editora);
				}
				return $editoras;	
			}
			

		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR EDITORA NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
        function gravar(){
			$conexao = DAO::conexaoMySQLi();
            $sql = "INSERT INTO editora(nome, tipo) VALUES('$this->nome', $this->tipo)";
            $res = $conexao->query($sql);
			if($conexao->affected_rows > 0){
                return true;
            }else{
                $erro = 'Sinto muito! Não conseguimos salvar seus dados. Tente novamente!';
                return false;
            }
        }
	}

?>