<?php
     /* @autor BRUNO MENDES PIMENTA
     * CLASSE MODEL RESPONSÁVEL POR CRUD DA TABELA LIVRO
     */

	require_once('../model/DAO.php');
	require_once('../model/Editora.php');
	require_once('../model/AbstractInformacional.php');
    require_once('../model/AutoresLivros.php');

	class Livro extends AbstractInformacional{
        /*
        *RECEBE O ISBN DO LIVRO
        @access protected 
        @name $isbn
        */
		protected $isbn;
        /*
        *RECEBE O DE PUBLICAÇÃO ANO DO LIVRO
        @access protected 
        @name $ano
        */
		protected $ano;
        /*
        *RECEBE O VOLUME DO LIVRO
        @access protected 
        @name $volume
        */
		protected $volume;
        /*
        *RECEBE A EDIÇÃO DO LIVRO
        @access protected 
        @name $edicao
        */
		protected $edicao;
        /*
        *RECEBE OS AUTORES DO LIVRO
        @access protected 
        @name $autores
        */
		protected $autores = array();
        /*
        *RECEBE A EDITORA DO LIVRO
        @access protected 
        @name $editora
        */
		protected $editora;
        /*
        *RECEBE EVENTUAIS ERROS QUE PODEM OCORRER NO OBJETO
        @access protected
        @name $erro
        */
		protected $erro;

		public function __construct(){
			$editora = new Editora();
		}

		public function __get($property){
			
			$propriedades = get_class_vars('Livro');
			$existe = false;
			foreach ($propriedades as $key => $value) {
				if($property == $key){
					$existe = true;
				}
			}
			if($existe){
				return $this->$property;
			}else{
				echo $property;
				return parent::$property;
			}
			
		}

		public function __set($property, $value){
			
				switch ($property) {
					case 'isbn':
						if(gettype($value) == "string" && strlen($value) == 13){
			   				$this->$property = $value;
			   			}else{
			   				$this->erro = "Erro: ISBN deve receber uma string de 13 caracteres!";
			   			}
			   			
					break;

					case 'ano':
						if(gettype($value) == "integer" && strlen($value) == 4){
			   				$this->$property = $value;
			   			}else{
			   				$this->erro = "Erro: Ano deve receber um número de 4 digitos!";
			   			}
					break;

					case 'volume':
						if(gettype($value) == "integer"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: volume deve receber um inteiro.");
			   			}
					break;

					case 'edicao':
						if(gettype($value) == "integer"){
			   				$this->$property = $value;
			   			}else{
			   				throw new Exception("Erro: edicao deve receber um inteiro.");
			   			}
					break;

					case 'autores':
		   				if(gettype($value) == "array" || get_class($value) == "Autor"){
		   					//$property[] = $value;
		   					array_push($this->$property, $value);
		   				}else{
		   					throw new Exception("Erro: autores deve receber objetos Autor.");
		   				}
		   			break;

		   			case 'editora':
		   				if(gettype($value) == "object" && get_class($value) == "Editora"){
		   					$this->$property = $value;
		   				}else{
		   					throw new Exception("Erro: editora deve receber uma Editora.");
		   				}
		   			break;
					
					default:
							parent::__set($property, $value);
					break;
				}
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR O LIVRO NO BANCO DE DADOS
        * @access public
        * @return Boolean
        */ 
		function gravar(){
				
			$idEditora = (string) $this->editora->id;
			$sql = "CALL add_livro('$this->isbn', $idEditora, $this->volume, $this->ano, $this->edicao, '$this->titulo', '$this->codBarras', $this->estante, $this->exemplares, @gravado, @erro)";

			$conexao = DAO::conexaoMySQLi();
			//VALIDA DADOS ANTES DE SEREM MANDADOS PARA O BANCO
			if($this->validarInsercao($conexao)){
				$conexao->query($sql);
				$gravado = $conexao->query('SELECT @gravado');
				$gravado = $gravado->fetch_array();
				$this->erro = ($conexao->query('SELECT @erro'))->fetch_array()[0];
				if((int) $gravado[0] == 0){
					return false;
				}else{
					if ($this->gravarAutoresLivro($conexao)){
						return true;
					}else{
						$erro = 'Ocorreu um erro ao gravar os autores';
						return false;
					}
				}	
			}else{
				return false;
			}
			
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR GRAVAR OS AUTORES DO LIVRO
        * @access public
        * @param mysqli $conexao
        * @return Boolean
        */ 
		function gravarAutoresLivro($conexao){
			foreach ($this->autores as $key => $autor) {
				$sql = "INSERT INTO autoreslivros(id_livro, id_autor) VALUES($this->isbn, $autor->id)";
				$conexao->query($sql);
                if($conexao->affected_rows == 0){
                    $erro = "Inconsistência Grave Ocorrida: Erro ao salvar os autores do livro! Integridade dos dados comprometida!";
                    return false;
                }
			}
            return true;
		}

        /* 
        * FUNÇÃO RESPONSÁVEL POR VALIDAR INSERÇÃO ANTES DE MANDAR DADOS PARA O BANCO
        * @access public
        * @param mysqli $conexao
        * @return Boolean
        */ 
		function validarInsercao($conexao){
			//VERIFICANDO SE AS PROPRIEDADES ISBN, EDITORA E AUTORES SE ENCONTRAM VÁZIAS
			$propriedades_faltando = array();
			if(empty($this->isbn)){
				$propriedades_faltando[] = 'isbn';
			}
			if(empty($this->editora)){
				$propriedades_faltando[] = 'editora';
			}
			if(empty($this->autores)){
				$propriedades_faltando[] = 'autores';
			}

			if(!empty($propriedades_faltando)){
				$this->erro = "A(s) propriedade(s) ".implode(", ", $propriedades_faltando)." são obrigatórias!";
				return false;
				
			}


			//VERIFICA EXISTÊNCIA E DUPLICIDADE DOS DADOS INFORMADOS PELO USUÁRIO
			//DECLARANDO COMANDOS SQL QUE SERÃO USADOS NA VALIDAÇÃO
			$sql_valida_isbn = "SELECT COUNT(*) FROM livro WHERE isbn = $this->isbn";
			$id_editora = $this->editora->id;
			$sql_valida_editora = "SELECT COUNT(*) FROM editora WHERE id = $id_editora";
			$sql_valida_autores = array();
			//FOREACH PERCORRERÁ PROPRIEDADE AUTORES PARA CRIAR COMANDOS SQL QUE SERÃO USADOS PARA AVERIGUAR A EXISTÊNCIA DOS AUTORES INFORMADOS
			foreach ($this->autores as $key => $autor) {
				array_push($sql_valida_autores, "SELECT COUNT(*) FROM autor WHERE id = $autor->id");
			}

			//VALIDANDO ISBN DUPLICADO
			$res_valida_isbn = ($conexao->query($sql_valida_isbn))->fetch_array()[0];
			if((int) $res_valida_isbn == 0){
				//VALIDANDO EDITORA
				$res_valida_editora = ($conexao->query($sql_valida_editora))->fetch_array()[0];
				if((int) $res_valida_editora > 0){
					//VALIDANDO AUTORES
					foreach ($sql_valida_autores as $key => $sql_valida_autor) {
						$res_valida_autores[$key] = ($conexao->query($sql_valida_autor))->fetch_array()[0];
					}

					//VERIFICA SE HÁ ALGUM AUTOR INEXISTENTE
					if(!in_array("0", $res_valida_autores)){
							//RETORNA VERDADEIRO CASO TODOS OS DADOS SEJAM VÁLIDOS
							return true;
						}else{
							$this->erro = "Um dos autores informados não existe!";
						}
				}else{
					$this->erro = 'A editora não existe na base de dados!';
				}
			}else{
				$this->erro = 'ISBN já cadastrado!';
			}

			
			
		}
        
        /* 
        * FUNÇÃO RESPONSÁVEL POR RESGATAR OS LIVROS DO BANCO DE DADOS
        * @access public
        * @return Array
        */ 
		function pegarLivros(){
			//ARRAY QUE RECEBERÁ OS LIVROS
			$conexao = DAO::conexaoMySQLi();
			$livros = array();
			//QUERY SQL
			$sql = 'SELECT * FROM livro';
			//EXECUTANDO QUERY NO BANCO
			$res = $conexao->query($sql);
			//WHILE QUE PERCORRERÁ A RESPOSTA, E CRIARÁ OS OBJETOS LIVRO
			while($row = $res->fetch_assoc()){
				$livro = new Livro();
				$livro->isbn = $row['isbn'];
				$livro->ano = $row['ano'];
				$livro->volume = $row['volume'];
				$livro->edicao = $row['edicao'];
				$livro->titulo = $row['titulo'];
				$livro->codBarras = $row['codigobarras'];
				$livro->estante = $row['estante'];
				$livro->exemplares = $row['exemplares'];
				$livro->disponiveis = $row['disponiveis'];
				//COLOCANDO EDITORA
				$editora = new Editora();
				$editora->id = (int) $row['id_editora'];
				$livro->editora = $editora;
				//MANDANDO OBJETO EDITORA SE COMPLETAR
				$livro->editora->pegarEditoras($livro->editora->id);
                
                $autoresLivros = new AutoresLivros();
                $livro->autores = $autoresLivros->pegarAutoresLivros($livro->isbn);

				//COLOCANDO LIVRO NO ARRAY
				$livros[] = $livro;
			}
			return $livros;
		}
        
	}

?>