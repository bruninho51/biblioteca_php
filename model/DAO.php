<?php
    /* @autor BRUNO MENDES PIMENTA
     * CLASSE DATA ACCESS OBJECT
     * RESPONSÁVEL POR ESTABELECER
     * CONEXÃO COM O BANCO DE DADOS 
     * DA BIBLIOTECA FEITO EM MYSQL
     */

	class DAO{
        /*
        *RECEBE O URL DO SERVIDOR DE BANCO DE DADOS
        @access private 
        @name HOST
        */
		private const HOST = '127.0.0.1:8080';
        /*
        *RECEBE O NOME DE USUÁRIO DO BANCO DE DADOS
        @access private 
        @name USUARIO
        */
		private const USUARIO = 'root';
        /*
        *RECEBE A SENHA DO USUÁRIO DO BANCO DE DADOS
        @access private
        @name SENHA
        */
		private const SENHA = '';
        /*
        *RECEBE O NOME DO BANCO DE DADOS A SER ACESSADO
        @access private
        @name BANCO
        */
		private const BANCO = 'biblioteca';

        /* 
        * FUNÇÃO RESPONSÁVEL POR ESTABELECER A CONEXÃO USANDO A BIBLIOTECA MYSQLi
        * @access static
        * @return mysqli
        */ 
		static function conexaoMySQLi(){
			$conexao = new mysqli(self::HOST, self::USUARIO, self::SENHA, self::BANCO) or die($conexao->connect_errno());
            //MODIFICA O CHARSET PARA UTF8, PARA NÃO HAVER PROBLEMA DE CODIFICAÇÃO 
            //AO RESGATAR OU PERSISTIR DADOS NO BANCO POR MEIO DA CONEXÃO A SER RETORNADA
			$conexao->query("SET CHARACTER SET utf8");
			return $conexao;
		}
	}


?>