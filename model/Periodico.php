<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA PERIODICO
     */

	class Periodico extends AbstractInformacional{
        /*
        *RECEBE O ISSN DO PERIÓDICO
        @access protected
        @name $issn
        */
		protected $issn;
        /*
        *RECEBE O ANO DE PÚBLICAÇÃO DO PERIÓDICO
        @access protected
        @name $ano
        */
		protected $ano;
        /*
        *RECEBE O VOLUME DO PERIÓDICO
        @access protected
        @name $volume
        */
		protected $volume;
        /*
        *RECEBE UMA DESCRIÇÃO DO PERIÓDICO
        @access protected
        @name $descricao
        */
        protected $descricao;
        /*
        *RECEBE EVENTUAIS ERROS QUE PODEM OCORRER NO OBJETO
        @access protected
        @name $erro
        */
        protected $erro;

		public function __get($property){
			if(property_exists($this, $property)){
				return $this->$property;
			}
		}

		public function __set($property, $value){
			if(property_exists($this, $property)){
				switch ($property) {
					case 'issn':
						if(gettype($value) == "string" && strlen($value) == 8){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: issn deve receber um inteiro.");
			   			}
					break;
					
					case 'ano':
						if(gettype($value) == "integer" && strlen($value) == 4){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: ano deve receber um inteiro de quatro digitos.");
			   			}
					break;
					
					case 'volume':
						if(gettype($value) == "integer"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: volume deve receber um inteiro.");
			   			}
					break;
                    
                    case 'descricao':
						if(gettype($value) == "string" && strlen($value) <= 250){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: descricao deve receber uma string de no máximo 250 caracteres.");
			   			}
					break;
					
					default:
						parent::__set($property, $value);
					break;
				}
			}
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR PERIÓDICO NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
        function gravar(){
            
			$sql = "CALL add_periodico('$this->issn', '$this->volume', '$this->ano', '$this->descricao', '$this->titulo', '$this->codBarras', '$this->estante', '$this->exemplares', @gravado)";

			$conexao = DAO::conexaoMySQLi();
			//VALIDA DADOS ANTES DE SEREM MANDADOS PARA O BANCO
			if($this->validarInsercao($conexao)){
				$conexao->query($sql);
				$gravado = $conexao->query('SELECT @gravado');
				$gravado = $gravado->fetch_array();
				if((int) $gravado[0] == 0){
					return false;
				}else{
					return true;
				}	
			}else{
				return false;
			}
			
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR VALIDAR DADOS ANTES DE ENVIAR AO BANCO
        * @access public
        * @return Boolean
        */ 
		function validarInsercao($conexao){
			//VERIFICANDO SE AS PROPRIEDADES ISSN, ANO, TITULO, CODBARRAS, ESTANTE E EXEMPLARES SE ENCONTRAM VÁZIAS
			$propriedades_faltando = array();
			if(empty($this->issn)){
				$propriedades_faltando[] = 'issn';
			}
			if(empty($this->ano)){
				$propriedades_faltando[] = 'ano';
			}
			if(empty($this->titulo)){
				$propriedades_faltando[] = 'titulo';
			}
            if(empty($this->codBarras)){
				$propriedades_faltando[] = 'codBarras';
			}
            if(empty($this->estante)){
				$propriedades_faltando[] = 'estante';
			}
            if(empty($this->exemplares)){
				$propriedades_faltando[] = 'exemplares';
			}
            
			if(!empty($propriedades_faltando)){
				$this->erro = "A(s) propriedade(s) ".implode(", ", $propriedades_faltando)." são obrigatórias!";
				return false;
				
			}

			//VERIFICA EXISTÊNCIA E DUPLICIDADE DOS DADOS INFORMADOS PELO USUÁRIO
			//DECLARANDO COMANDOS SQL QUE SERÃO USADOS NA VALIDAÇÃO
			$sql_valida_issn = "SELECT COUNT(*) FROM periodico WHERE issn = $this->issn";

			//VALIDANDO ISSN DUPLICADO
			$res_valida_issn = ($conexao->query($sql_valida_issn))->fetch_array()[0];
			if((int) $res_valida_issn == 0){
				return true;
			}

		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR RESGATAR PERIÓDICOS DO BANCO DE DADOS
        * @access public
        * @return Array
        */ 
		function pegarPeriodicos(){
			//ARRAY QUE RECEBERÁ OS PERIODICOS
			$conexao = DAO::conexaoMySQLi();
			$periodicos = array();
			//QUERY SQL
			$sql = 'SELECT * FROM periodico';
			//EXECUTANDO QUERY NO BANCO
			$res = $conexao->query($sql);
			//WHILE QUE PERCORRERÁ A RESPOSTA, E CRIARÁ OS OBJETOS PERIODICO
			while($row = $res->fetch_assoc()){
				$periodico = new Periodico();
				$periodico->issn = $row['issn'];
				$periodico->ano = $row['ano'];
                $periodico->descricao = $row['descricao'];
				$periodico->volume = $row['volume'];
				$periodico->titulo = $row['titulo'];
				$periodico->codBarras = $row['codigobarras'];
				$periodico->estante = $row['estante'];
				$periodico->exemplares = $row['exemplares'];
				$periodico->disponiveis = $row['disponiveis'];
                
				//COLOCANDO PERIODICO NO ARRAY
				$periodicos[] = $periodico;
			}
			return $periodicos;
		}

	}

?>