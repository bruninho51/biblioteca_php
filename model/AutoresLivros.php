<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA AUTORESLIVROS
     * DO BANCO DE DADOS
     */

    require_once('../model/DAO.php');

	class AutoresLivros{
        /*
        *RECEBE O ISBN DO LIVRO
        @access private 
        @name $id_livro
        */
		private $id_livro;
        /*
        *RECEBE O ID DO AUTOR
        @access private 
        @name $id_autor
        */
		private $id_autor;
        /*
        *RECEBE OS ERROS QUE PODEM TER OCORRIDO NO OBJETO
        @access private 
        @name $erro
        */
        private $erro;

        
		public function __get($property){
				return $this->$property;
		}

		public function __set($property, $value){
			
				switch ($property) {
					case 'id_livro':
						if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: id_livro deve receber um número inteiro.");
		   				}
					break;
					
					case 'id_autor':
						if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: id_autor deve receber um número inteiro.");
		   				}
					break;
				
					default:
						throw new Exception("Erro: a propriedade $property não existe.");
					break;
				}
			
		}

        /* 
        * FUNÇÃO QUE RESGATA OS AUTORES DE DETERMINADO LIVRO DO BANCO DE DADOS
        * @access public
        * @param String $id_livro
        * @return Array
        */ 
		function pegarAutoresLivros($id_livro){
			$conexao = DAO::conexaoMySQLi();
            //SELECIONA ID'S DOS AUTORES DO LIVRO PASSADO COMO ARGUMENTO
            $sql = "SELECT id_autor FROM autoreslivros WHERE id_livro = '$id_livro'";
			$res = $conexao->query($sql);
            
            //ARRAY QUE CONTERÁ OS AUTORES PEGOS DO BANCO DE DADOS
            $autores = array();
            //WHILE PERCORRE ESSES ID'S
			while ($id_autor = $res->fetch_assoc()) {
                    //AUTORES SÃO RESGATADOS DO BANCO ATRAVÉS DOS ID'S
                    $res2 = $conexao->query("SELECT * FROM autor WHERE id = '$id_autor[id_autor]'");
                    //UM OUTRO WHILE PERCORRERÁ O RESULTADO, E CRIARÁ O OBJETO AUTOR. ISSO SERÁ FEITO COM TODOS OS ID'S
                    while($autor_bd = $res2->fetch_assoc()){
                        $autor = new Autor();
                        $autor->id = (int) $autor_bd['id'];
                        $autor->nome = $autor_bd['nome'];
                        $autor->sobrenome = $autor_bd['sobrenome'];
                        $autores[] = $autor;           
                }
			}
            
			return $autores;

		}
        
        
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