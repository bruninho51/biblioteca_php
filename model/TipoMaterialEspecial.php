<?php
    require_once('../model/DAO.php');

	class TipoMaterialEspecial{
		protected $id;
		protected $nome;

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
		   					throw new Exception("Erro: id deve receber um número inteiro.");
		   				}
					break;
					
					case 'nome':
						if(gettype($value) == "string" && strlen($value) <= 50){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: nome deve receber uma string.");
		   				}
					break;
					
					default:
						throw new Exception("Erro: a propriedade $property não existe");
					break;
				}
			}
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR OS TIPOS DE MATERIAIS ESPECIAIS NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
        function gravar(){
            
			$sql = "INSERT INTO tipomaterialespecial(nome) VALUES('$this->nome')";

			$conexao = DAO::conexaoMySQLi();
			//VALIDA DADOS ANTES DE SEREM MANDADOS PARA O BANCO
			if($this->validarInsercao($conexao)){
				$conexao->query($sql);
				if($conexao->affected_rows < 1){
					return false;
				}else{
					return true;
				}	
			}else{
				return false;
			}
			
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR VALIDAR INSERÇÃO NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
		function validarInsercao($conexao){
			//VERIFICANDO SE A PROPRIEDADE NOME SE ENCONTRA VAZIA
			$propriedades_faltando = array();
			if(empty($this->nome)){
				$propriedades_faltando[] = 'nome';
			}
            
			if(!empty($propriedades_faltando)){
				$this->erro = "A(s) propriedade(s) ".implode(", ", $propriedades_faltando)." são obrigatórias!";
				return false;
				
			}
            
            return true;

		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR RESGATAR OS TIPOS DE MATERIAIS ESPECIAIS GRAVADOS NO BANCO DE DADOS
        * @access public
        * @return mixed
        */ 
		function pegarTiposMaterialEspecial($id = false){
			//ARRAY QUE RECEBERÁ OS TIPOS DE MATERIAL ESPECIAL
			$conexao = DAO::conexaoMySQLi();
            
            if($id == false){
				//SELECT SELECIONARÁ TODOS OS REGISTROS...
				$sql = 'SELECT * FROM tipomaterialespecial';
			}else{
				//SE FOR INFORMADO SELECIONARÁ SÓ UM
				$sql = 'SELECT * FROM tipomaterialespecial WHERE id = ' . $id;
			}
            
			
            
			//EXECUTANDO QUERY NO BANCO
			$res = $conexao->query($sql);
            
            if($id == false){
                $tipos_material_especial = array();
                //WHILE QUE PERCORRERÁ A RESPOSTA, E CRIARÁ OS OBJETOS MATERIAL ESPECIAL
			     while($row = $res->fetch_assoc()){
                    $tipo_material_especial = new TipoMaterialEspecial();
                    $tipo_material_especial->id = $row['id'];
                    $tipo_material_especial->nome = $row['nome'];

                    //COLOCANDO TIPO DE MATERIAL ESPECIAL NO ARRAY
                    $tipos_material_especial[] = $tipo_material_especial;
			     }
			     return $tipos_material_especial;
            }else{
                //REGISTRO SERÁ PEGO E GUARDADO NO PRÓPRIO OBJETO
				$row = $res->fetch_assoc();
				$this->id = (int) $row['id'];
				$this->nome = $row['nome'];
            }
            
			
		}
	}
?>