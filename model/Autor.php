<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA AUTOR
     * DO BANCO DE DADOS
     */

    require_once('../model/DAO.php');

	class Autor{
        /*
        *RECEBE O ID DO AUTOR
        @access protected 
        @name $id
        */
		protected $id;
        /*
        *RECEBE O NOME DO AUTOR
        @access protected 
        @name $nome
        */
		protected $nome;
        /*
        *RECEBE O SOBRENOME DO AUTOR
        @access protected 
        @name $sobrenome
        */
		protected $sobrenome;
        /*
        *RECEBE OS ERROS QUE PODEM OCORRER NO OBJETO
        @access protected 
        @name $erro
        */
        protected $erro;

		public function __get($property){
				return $this->$property;
		}

		public function __set($property, $value){
			
				switch ($property) {
					case 'id':
						if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: id deve receber um número inteiro.");
		   				}
					break;
					
					case 'nome':
						if(gettype($value) == "string" && strlen($value) <= 25){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: nome deve receber uma string de até 50 caracteres.");
		   				}
					break;
					
					case 'sobrenome':
						if(gettype($value) == "string" && strlen($value) <= 25){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: sobrenome deve receber uma string de até 50 caracteres.");
		   				}
					break;
					
					default:
						throw new Exception("Erro: a propriedade $property não existe.");
					break;
				}
			
		}

        /* 
        * FUNÇÃO QUE DEVOLVE NOME COMPLETO NORMAL OU EM PADRÃO CIÊNTIFICO(sobrenome, nome)
        * @access public
        * @param String $formato
        * @return String
        */ 
		function nomeCompleto($formato = ''){
			if($formato == 'cientifico'){
				$nomeCompleto = $this->sobrenome . ", " . $this->nome; 
				
			}else{
				$nomeCompleto = $this->nome . " " . $this->sobrenome;	
			}
			
			return $nomeCompleto;
		}

        /* 
        * FUNÇÃO RESGATA OS AUTORES DO BANCO DE DADOS
        * @access public
        * @return Array
        */ 
		function pegarAutores(){
			$conexao = DAO::conexaoMySQLi();
			$res = $conexao->query('SELECT * FROM autor');
			
			$autores = array();
			while ($row = $res->fetch_assoc()) {
				$autor = new Autor();
				$autor->id = $row['id'];
				$autor->nome = $row['nome'];
				$autor->sobrenome = $row['sobrenome'];
				array_push($autores, $autor);
			}
			return $autores;

		}
        
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR UM AUTOR NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
        function gravar(){
			$conexao = DAO::conexaoMySQLi();
            $sql = "INSERT INTO autor(nome, sobrenome) VALUES('$this->nome', '$this->sobrenome')";
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