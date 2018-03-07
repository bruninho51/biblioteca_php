<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA PESSOA
     */

	require_once('../model/DAO.php');

	class Pessoa{
        /*
        *RECEBE O ISSN DO PERIÓDICO
        @access protected
        @name $issn
        */
		protected $id;
        /*
        *RECEBE O CPF DA PESSOA
        @access protected
        @name $cpf
        */
		protected $cpf;
        /*
        *RECEBE O NOME DA PESSOA
        @access protected
        @name $nome
        */
		protected $nome;
        /*
        *RECEBE O TELEFONE DA PESSOA
        @access protected
        @name $telefone
        */
		protected $telefone;

		public function __get($property){
			if(property_exists($this, $property)){
				return $this->$property;
			}
		}

		public function __set($property, $value){
			if(property_exists($this, $property)){
				switch ($property) {
					case 'id':
						if(gettype($value) == "integer"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: id deve receber um inteiro.");
			   			}
					break;
					
					case 'cpf':
						if(gettype($value) == "string" && strlen($value) == 11){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: cpf deve receber um inteiro de 9 caracteres.");
			   			}
					break;
					
					case 'nome':
						if(gettype($value) == "string" && strlen($value) <= 50){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: nome deve receber uma string de até 50 caracteres.");
			   			}
					break;
					
					case 'telefone':
						if(gettype($value) == "string" && strlen($value) == 10){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: telefone deve receber um inteiro de 10 caracteres.");
			   			}
					break;
					
					default:
						throw new Exception("Erro: a propriedade $value não existe.");
					break;
				}
			}
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR PESSOA NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
		function gravar(){
			$sql = "INSERT INTO pessoa(cpf, nome, telefone) VALUES('$this->cpf', '$this->nome', '$this->telefone')";

			$conexao = DAO::conexaoMySQLi();
			//VALIDA DADOS ANTES DE SEREM MANDADOS PARA O BANCO
			if($this->validarInsercao($conexao)){
				$conexao->query($sql);
				if($conexao->affected_rows > 0){
					return true;
				}else{
					return false;
				}

				
			}else{
				return false;
			}
			
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR VALIDAR DADOS ANTES DE SEREM COLOCADOS NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
		function validarInsercao($conexao){
			//VERIFICANDO SE AS PROPRIEDADES CPF, NOME E TELEFONE SE ENCONTRAM VÁZIAS
			$propriedades_faltando = array();
			if(empty($this->cpf)){
				$propriedades_faltando[] = 'cpf';
			}
			if(empty($this->nome)){
				$propriedades_faltando[] = 'nome';
			}
			if(empty($this->telefone)){
				$propriedades_faltando[] = 'telefone';
			}

			if(!empty($propriedades_faltando)){
				$this->erro = "A(s) propriedade(s) ".implode(", ", $propriedades_faltando)." são obrigatórias!";
				return false;
				
			}else{
				return true;
			}
			
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR RESGATAR AS PESSOAS DO BANCO DE DADOS
        * @access public
        * @return Array
        */ 
		function pegarPessoas(){
			//ARRAY QUE RECEBERÁ AS PESSOAS
			$conexao = DAO::conexaoMySQLi();
			$pessoas = array();
			//QUERY SQL
			$sql = 'SELECT * FROM pessoa';
			//EXECUTANDO QUERY NO BANCO
			$res = $conexao->query($sql);
			//WHILE QUE PERCORRERÁ A RESPOSTA, E CRIARÁ OS OBJETOS PESSOA
			while($row = $res->fetch_assoc()){
				$pessoa = new Pessoa();
				$pessoa->id = $row['id'];
				$pessoa->cpf = $row['cpf'];
				$pessoa->nome = $row['nome'];
				$pessoa->telefone = $row['telefone'];

				//COLOCANDO LIVRO NO ARRAY
				$pessoas[] = $pessoa;
			}
			return $pessoas;
		}
        
        static function existePessoa($codigo){
            $sql = "SELECT * FROM pessoa WHERE id = '" . $codigo . "'";
            $conexao = DAO::conexaoMySQLi();
            $conexao->query($sql);
            if($conexao->affected_rows > 0){
                return true;
            }else{
                return false;
            }
            
        }
	}
?>