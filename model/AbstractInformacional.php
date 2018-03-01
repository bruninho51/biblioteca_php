<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE ABSTRATA USADA PARA MONTAR AS CLASSES
     * PERIODICO, LIVRO E MATERIALESPECIAL
     */

	abstract class AbstractInformacional{
        /*
        *RECEBE TÍTULO DO MATERIAL, SEJA ELE QUAL FOR
        @access protected 
        @name $titulo
        */
		protected $titulo;
        /* RECEBE O CÓDIGO DE BARRAS DO MATERIAL
        @access protected
        @name $codBarras
        */
		protected $codBarras;
        /* RECEBE A ESTANTE EM QUE O MATERIAL ESTARÁ NA BIBLIOTECA
        @access protected
        @name $estante
        */
		protected $estante;
        /* RECEBE O NÚMERO DE EXEMPLARES QUE A BIBLIOTECA POSSUI DESSE MATERIAL
        @access protected
        @name $exemplares
        */
		protected $exemplares;
        /* RECEBE A QUANTIDADE DE MATERIAL DISPONÍVEL PARA EMPRÉSTIMO NA BIBLIOTECA
        @access protected
        @name $disponiveis
        */
		protected $disponiveis;
        

		public function __get($property) {
			
			   	return $this->$property;
			
		}
		public function __set($property, $value) {
		   	
		   		switch ($property) {

		   			case 'titulo':
		   				if(gettype($value) == "string" && strlen($value) <= 50){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: titulo deve receber uma string e ter menos que 50 caracteres.");
		   				}
		   			break;

		   			case 'codBarras':
		   				if(gettype($value) == "string" && strlen($value) <= 13){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: codBarras deve receber uma string e ter menos que 50 caracteres.");
		   				}
		   			break;

		   			case 'estante':
		   				if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: estante deve receber um inteiro.");
		   				}
		   			break;

		   			case 'exemplares':
		   				if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: exemplares deve receber um inteiro.");
		   				}
		   			break;

		   			case 'disponiveis':
		   				if(gettype($value) == "integer"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: disponiveis deve receber um inteiro.");
		   				}
		   			break;

		   			
		   			
		   			default:
		   				throw new Exception("Erro: a propriedade $property não existe.");
		   				break;
		   		}
		}

	}
?>