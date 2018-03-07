<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA MATERIALESPECIAL
     */

	class MaterialEspecial extends AbstractInformacional{
        /*
        *RECEBE O ID DO MATERIAL ESPECIAL, SEJA ELE DVD, JOGO, ETC
        @access protected
        @name $id
        */
		protected $id;
        /*
        *RECEBE O TIPO DO MATERIAL, QUE PODE SER DVD, JOGO, ETC
        @access protected
        @name $tipo
        */
		protected $tipo;
        /*
        *RECEBE A DESCRIÇÃO DO MATERIAL ESPECIAL
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
			}else{
                parent::__get($property);
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
					
					case 'tipo':
						if(gettype($value) == "object" && get_class($value) == "TipoMaterialEspecial"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: tipo deve receber um TipoMaterialEspecial.");
			   			}
					break;

					case 'descricao':
						if(gettype($value) == "string"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: descrição deve receber uma string.");
			   			}
					break;
					
					default:
						parent::__set($property, $value);
					break;
				}
			}
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR MATERIAL ESPECIAL NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
        function gravar(){
            $id_tipo_mat = (string) $this->tipo->id;
            
			$sql = "CALL add_material_especial('$id_tipo_mat', '$this->titulo', '$this->codBarras', '$this->estante', '$this->exemplares', '$this->descricao', @gravado)";

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
        * FUNÇÃO RESPONSÁVEL VALIDAR MATERIAL ESPECIAL ANTES DESTE SER ENVIADO AO BANCO
        * @access public
        * @return Boolean
        */ 
		function validarInsercao($conexao){
			//VERIFICANDO SE AS PROPRIEDADES TIPO, TITULO, ESTANTE, EXEMPLARES E CODBARRAS SE ENCONTRAM VÁZIAS
			$propriedades_faltando = array();
			if(empty($this->tipo)){
				$propriedades_faltando[] = 'tipo';
			}
			if(empty($this->titulo)){
				$propriedades_faltando[] = 'titulo';
			}
            
			if(!empty($propriedades_faltando)){
				$this->erro = "A(s) propriedade(s) ".implode(", ", $propriedades_faltando)." são obrigatórias!";
				return false;
				
			}
            
            return true;

		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR RESGATAR MATERIAIS ESPECIAIS DO BANCO DE DADOS
        * @access public
        * @return Array
        */ 
		function pegarMateriaisEspeciais(){
			//ARRAY QUE RECEBERÁ OS MATERIAIS ESPECIAIS
			$conexao = DAO::conexaoMySQLi();
			$materiais_especiais = array();
			//QUERY SQL
			$sql = 'SELECT * FROM materialespecial';
			//EXECUTANDO QUERY NO BANCO
			$res = $conexao->query($sql);
			//WHILE QUE PERCORRERÁ A RESPOSTA, E CRIARÁ OS OBJETOS MATERIAL ESPECIAL
			while($row = $res->fetch_assoc()){
				$material_especial = new MaterialEspecial();
				$material_especial->id = $row['id_material_especial'];
                
                //CRIANDO TIPO MATERIAL ESPECIAL
                $tipo_mat = new TipoMaterialEspecial();
                $tipo_mat->id = (int) $row['id_tipo_material_especial'];
                $material_especial->tipo = $tipo_mat;
                    
                //MANDANDO TIPO MATERIAL ESPECIAL SE COMPLETAR
                $material_especial->tipo->pegarTiposMaterialEspecial($material_especial->tipo->id);
                
                $material_especial->titulo = $row['titulo'];
				$material_especial->codBarras = $row['codigobarras'];
				$material_especial->estante = $row['estante'];
				$material_especial->exemplares = $row['exemplares'];
				$material_especial->disponiveis = $row['disponiveis'];
				$material_especial->descricao = $row['descricao'];
                
				//COLOCANDO MATERIAL ESPECIAL NO ARRAY
				$materiais_especiais[] = $material_especial;
			}
			return $materiais_especiais;
		}
        
        static function existeMaterialEspecial($codigo){
            $sql = "SELECT * FROM materialespecial WHERE id_material_especial = '" . $codigo . "'";
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