<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD 
     * DAS TABELAS DE EMPRÉSTIMO
     */

	require_once('../helper/helper.php');

	class Emprestimo{
        protected $codigo_emprestimo;
        
        /*
        *RECEBE O ID DO EMPRÉSTIMO
        @access protected 
        @name $id
        */
		protected $id;
        /*
        *RECEBE A PESSOA QUE ESTÁ FAZENDO O EMPRÉSTIMO
        @access protected
        @name $pessoa
        */
		protected $pessoa;
        /*
        *RECEBE O MATERIAL QUE ESTÁ SENDO EMPRESTADO
        @access protected
        @name $material
        */
		protected $materiais;
        /*
        *RECEBE A DATA DO EMPRÉSTIMO
        @access protected
        @name $dataEmprestimo
        */
		protected $dataEmprestimo;
        /*
        *RECEBE A DATA DE DEVOLUÇÃO DO MATERIAL EMPRESTADO
        @access protected
        @name $dataDevolucao
        */
		protected $dataDevolucao;
        /*
        *RECEBE VERDADEIRO SE O MATERIAL EMPRESTADO FOI DEVOLVIDO
        @access protected
        @name $devolvido
        */
		protected $devolvido;
        
        function __construct(){
            $this->devolvido = false;
            $this->materiais = array();
            $this->pessoa = new Pessoa();
        }


		public function __get($property){
			if(property_exists($this, $property)){
				return $this->property;
			}
		}

		public function __set($property, $value){
			if(property_exists($this, $property)){
				switch ($property) {
					case 'id':
						if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: id deve receber um número inteiro.");
		   				}
					break;
					
					case 'pessoa':
						if(gettype($value) == "object" && get_class($value) == "Pessoa"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: pessoa deve receber um objeto da classe Pessoa.");
		   				}
					break;
					
					case 'materiais':
						if(get_parent_class($value) == "AbstractInformacional"){
		   					$this->$property[] = $value;
		   				}else{
		   					throw new Exception("Erro: material deve receber um material.");
		   				}
					break;
					
					case 'dataEmprestimo':
						if(gettype($value) == "string" && validarData($value)){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: dataEmprestimo deve receber uma string em formato 0000/00/00.");
		   				}
					break;
					
					case 'dataDevolucao':
						if(gettype($value) == "string" && validarData($value)){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: dataEmprestimo deve receber uma string em formato 0000/00/00.");
		   				}
					break;
					
					case 'devolvido':
						if(gettype($value) == "boolean"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: devolvido deve receber um valor booleano.");
		   				}
					break;
					
					default:
						throw new Exception("Erro: a propriedade $propery não existe.");
					break;
				}
			}
		}
        
        function gerarCodigoEmprestimo($id_pessoa){
            $prefix = $id_pessoa + rand(10,100);
            
            return uniqid($prefix, false);
        }
        
        function gravar(){
            //GERANDO CÓDIGO DO EMPRÉSTIMO
            $codigo = self::gerarCodigoEmprestimo($this->pessoa->id);
            $id_pessoa = $this->pessoa->id;
            $data = date('Y-m-d');
            $data_devolucao = date('Y-m-d', strtotime($data. ' + 15 days'));
            //ESTABELECENDO CONEXÃO
			$conexao = DAO::conexaoMySQLi();
			
            foreach($this->materiais as $material){
                switch (get_class($material)){
                    case 'Livro':
                        $sql = "CALL add_emprestimo_livro('$codigo', '$material->isbn', $id_pessoa, '$data_devolucao', @disponivel)";
                        echo $sql . '<br>';
                    break;
                        
                    case 'Periodico':
                        $sql = "CALL add_emprestimo_periodico('$codigo', '$material->issn', $id_pessoa, '$data_devolucao', @disponivel)";
                        echo $sql . '<br>';
                    break;
                        
                    case 'MaterialEspecial':
                        $sql = "CALL add_emprestimo_material_especial('$codigo', '$material->id', $id_pessoa, '$data_devolucao', @disponivel)";
                        echo $sql . '<br>';
                    break;
                }
                
                $conexao->query($sql);
                $res = $conexao->query('SELECT @disponivel');
                $res = $res->fetch_array();
                
                if($res[0] == false){
                    $erro = 'Material não disponível para emprestimo!';
                    return false;
                }
            }
            
            return true;
            
        }

		
	}

?>