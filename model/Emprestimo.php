<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD 
     * DAS TABELAS DE EMPRÉSTIMO
     */

	require_once('helper/helper.php');

	class Emprestimo{
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
		protected $pessoa = new Pessoa();
        /*
        *RECEBE O MATERIAL QUE ESTÁ SENDO EMPRESTADO
        @access protected
        @name $material
        */
		protected $material = new AbstractInformacional();
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
		protected $devolvido = false;


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
						if(gettype($value) == "objetct" && get_class($value) == "Pessoa"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: pessoa deve receber um objeto da classe Pessoa.");
		   				}
					break;
					
					case 'material':
						if(gettype($value) == "objetct" && get_parent_class($value) == "AbstractInformacional"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: material deve receber um Livro, Periodico ou MaterialEspecial.");
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
						return throw new Exception("Erro: a propriedade $value não existe.");
					break;
				}
			}
		}

		
	}

?>