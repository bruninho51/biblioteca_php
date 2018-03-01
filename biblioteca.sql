DROP DATABASE biblioteca;
CREATE DATABASE biblioteca;
USE biblioteca;
CREATE TABLE pessoa(
	id INT AUTO_INCREMENT,
    cpf LONG,
    nome VARCHAR(50),
    telefone VARCHAR(10),
    PRIMARY KEY(id)
);

CREATE TABLE autor(
	id INT AUTO_INCREMENT,
    nome VARCHAR(25),
    sobrenome VARCHAR(25),
    PRIMARY KEY(id)
);

CREATE TABLE editora(
	id INT AUTO_INCREMENT,
    nome VARCHAR(50),
    tipo INT,
    PRIMARY KEY(id)
);

CREATE TABLE livro(
    id_editora INT,
	isbn VARCHAR(13),
    ano INT,
    volume INT,
    edicao INT,
    titulo VARCHAR(50),
    codigobarras VARCHAR(13),
    estante INT,
    exemplares INT,
    disponiveis INT,
    CONSTRAINT fk_id_editora FOREIGN KEY (id_editora) REFERENCES editora(id),
    PRIMARY KEY(isbn)
);
CREATE TABLE autoreslivros(
	id_livro VARCHAR(13),
    id_autor INT,
    CONSTRAINT fk_id_livro FOREIGN KEY (id_livro) REFERENCES livro(isbn),
    CONSTRAINT fk_id_autor FOREIGN KEY (id_autor) REFERENCES autor(id)
);

CREATE TABLE periodico(
	issn VARCHAR(8),
    volume INT,
    ano INT,
    descricao VARCHAR(250),
    titulo VARCHAR(50),
    codigobarras VARCHAR(13),
    estante INT,
    exemplares INT,
    disponiveis INT,
    PRIMARY KEY(issn)
);

CREATE TABLE tipomaterialespecial(
	id INT AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE materialespecial(
	id_material_especial INT AUTO_INCREMENT,
    id_tipo_material_especial INT,
    titulo VARCHAR(50),
    codigobarras VARCHAR(13),
    estante INT,
    exemplares INT,
    disponiveis INT,
	descricao VARCHAR(250),
	CONSTRAINT fk_id_tipomaterialespecial FOREIGN KEY (id_tipo_material_especial) REFERENCES tipomaterialespecial(id),
    PRIMARY KEY(id_material_especial)
);

CREATE TABLE emprestimo_material_especial(
	id_material_especial INT,
    id_pessoa INT,
	id INT AUTO_INCREMENT,
    dataemprestimo DATE,
    datadevolucao DATE NULL,
    devolvido BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id),
    CONSTRAINT fk_id_material_especial_emprestimo_material_especial FOREIGN KEY (id_material_especial) REFERENCES materialespecial(id_material_especial),
    CONSTRAINT fk_id_pessoa_emprestimo_material_especial FOREIGN KEY (id_pessoa) REFERENCES pessoa(id)
);
CREATE TABLE emprestimo_livro(
	id_livro VARCHAR(13),
    id_pessoa INT,
	id INT AUTO_INCREMENT,
    dataemprestimo DATE,
    datadevolucao DATE NULL,
    devolvido BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id),
    CONSTRAINT fk_id_livro_emprestimo_livro FOREIGN KEY (id_livro) REFERENCES livro(isbn),
    CONSTRAINT fk_id_pessoa_emprestimo_livro FOREIGN KEY (id_pessoa) REFERENCES pessoa(id)
);
CREATE TABLE emprestimo_periodico(
	id_periodico VARCHAR(8),
    id_pessoa INT,
	id INT AUTO_INCREMENT,
    dataemprestimo DATE,
    datadevolucao DATE NULL,
    devolvido BOOLEAN DEFAULT FALSE,
    PRIMARY KEY(id),
    CONSTRAINT fk_id_periodico_emprestimo_periodico FOREIGN KEY (id_periodico) REFERENCES periodico(issn),
    CONSTRAINT fk_id_pessoa_emprestimo_periodico FOREIGN KEY (id_pessoa) REFERENCES pessoa(id)
);

#PROCEDURES DE PERIÓDICOS
#########################
DELIMITER $$
CREATE PROCEDURE add_emprestimo_periodico(IN _id_periodico VARCHAR(8), IN _id_pessoa INT, IN _data_devolucao DATE, OUT _disponivel BOOLEAN)
BEGIN
DECLARE periodicos_disponiveis INT;
SET periodicos_disponiveis = (SELECT disponiveis
FROM periodico
WHERE issn = _id_periodico);
IF periodicos_disponiveis >0 THEN
INSERT INTO emprestimo_periodico(id_periodico, id_pessoa, dataemprestimo, datadevolucao) VALUES(_id_periodico, _id_pessoa, NOW(), _data_devolucao);
UPDATE periodico SET disponiveis = (periodicos_disponiveis -1) WHERE issn = _id_periodico;
SET _disponivel = TRUE;
ELSE
SET _disponivel = false;
END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_periodico(IN _issn VARCHAR(8), IN _volume INT, IN _ano INT, IN _descricao VARCHAR(50), IN _titulo VARCHAR(20), IN _codigobarras VARCHAR(13), IN _estante INT, IN _exemplares INT, OUT _gravado BOOLEAN)
#PROCEDURE RESPONSÁVEL POR ADICIONAR PERIÓDICOS AO BANCO DE DADOS
#UMA DAS FUNÇÕES É CERTIFICAR QUE O NÚMERO DE EXEMPLARES ADICIONADOS 
#SEJA IGUAL AO NÚMERO DE EXEMPLARES DISPONÍVEIS
BEGIN
SET _gravado = FALSE;
INSERT INTO periodico(issn, ano, volume, descricao, titulo, codigobarras, estante, exemplares, disponiveis)
VALUES(_issn, _ano, _volume, _descricao, _titulo, _codigobarras, _estante, _exemplares, _exemplares);
SET _gravado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_exemplares_periodico(IN _issn VARCHAR(8), IN qtde_add INT, OUT _atualizado BOOLEAN)
BEGIN
DECLARE $exemplares, $disponiveis INT;
SET _atualizado = FALSE;
SET $exemplares = (SELECT exemplares FROM periodico WHERE issn = _issn);
SET $disponiveis = (SELECT disponiveis FROM periodico WHERE issn = _issn);
UPDATE periodico SET  exemplares = (qtde_add + $exemplares), disponiveis = (qtde_add + $disponiveis) WHERE issn = _issn;
SET _atualizado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE devolucao_periodico(IN _id_periodico VARCHAR(8), IN _id_pessoa INT, IN _id_emprestimo INT, OUT _devolucao_efetuada BOOLEAN, OUT _existe_emprestimo BOOLEAN)
BEGIN
DECLARE periodicos_disponiveis, num_linhas INT;
DECLARE var_devolvido BOOLEAN; 
SET periodicos_disponiveis = (SELECT disponiveis FROM periodico WHERE issn = _id_periodico);
SET num_linhas = (SELECT COUNT(*) FROM emprestimo_periodico WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
SET var_devolvido = (SELECT devolvido FROM emprestimo_periodico WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
#SE O EMPRESTIMO EXISTIR NO BANCO DE DADOS...
IF num_linhas > 0 THEN
#ELE VERÁ SE A DEVOLUÇÃO JÁ FOI FEITA...'
IF var_devolvido = FALSE THEN
#SE NÃO TIVER SIDO REALIZADA, O PERIÓDICO SERÁ DEVOLVIDO E DISPONIBILIZADO PARA NOVOS EMPRÉSTIMOS'
UPDATE emprestimo_periodico
SET devolvido = TRUE
WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa;
UPDATE periodico
SET disponiveis = (periodicos_disponiveis + 1)
WHERE issn = _id_periodico;
SET _devolucao_efetuada = TRUE;
SET _existe_emprestimo = TRUE;
#SE JÁ FOI DEVOLVIDO, O PROCEDIMENTO RETORNARÁ FALSO'
ELSE
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = TRUE;
END IF;
ELSE
#SE O EMPRÉSTIMO NÃO EXISTIR'
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = FALSE;
END IF;
END$$
DELIMITER ;


#PROCEDURES DE LIVROS
#####################
DELIMITER $$
CREATE PROCEDURE add_emprestimo_livro(IN _id_livro VARCHAR(13), IN _id_pessoa INT, IN _data_devolucao DATE, OUT _disponivel BOOLEAN)
BEGIN
DECLARE livros_disponiveis INT;
SET livros_disponiveis = (SELECT disponiveis
FROM livro
WHERE isbn = _id_livro);
IF livros_disponiveis >0 THEN
INSERT INTO emprestimo_livro(id_livro, id_pessoa, dataemprestimo, datadevolucao) VALUES(_id_livro, _id_pessoa, NOW(), _data_devolucao);
UPDATE livro SET disponiveis = (livros_disponiveis -1) WHERE isbn = _id_livro;
SET _disponivel = TRUE;
ELSE
SET _disponivel = FALSE;
END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_livro(IN _isbn VARCHAR(13), IN _id_editora INT, IN _volume INT, IN _ano INT, IN _edicao INT, IN _titulo VARCHAR(20), IN _codigobarras VARCHAR(13), IN _estante INT, IN _exemplares INT, OUT _gravado BOOLEAN, OUT _erro VARCHAR(30))
#PROCEDURE RESPONSÁVEL POR ADICIONAR LIVROS AO BANCO DE DADOS
#UMA DAS FUNÇÕES É CERTIFICAR QUE O NÚMERO DE EXEMPLARES ADICIONADOS 
#SEJA IGUAL AO NÚMERO DE EXEMPLARES DISPONÍVEIS
BEGIN
DECLARE res VARCHAR(30);
SET _gravado = FALSE;
SET res = (SELECT COUNT(*) FROM livro WHERE isbn = _isbn);
IF res = 0 THEN
INSERT INTO livro(isbn, id_editora, ano, volume, edicao, titulo, codigobarras, estante, exemplares, disponiveis)
VALUES(_isbn, _id_editora, _ano, _volume, _edicao, _titulo, _codigobarras, _estante, _exemplares, _exemplares);
SET _gravado = TRUE;
ELSE
SET _erro = 'isbn existente';
END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_exemplares_livro(IN _isbn VARCHAR(13), IN qtde_add INT, OUT _atualizado BOOLEAN)
BEGIN
DECLARE $exemplares, $disponiveis INT;
SET _atualizado = FALSE;
SET $exemplares = (SELECT exemplares FROM livro WHERE isbn = _isbn);
SET $disponiveis = (SELECT disponiveis FROM livro WHERE isbn = _isbn);
UPDATE livro SET  exemplares = (qtde_add + $exemplares), disponiveis = (qtde_add + $disponiveis) WHERE isbn = _isbn;
SET _atualizado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE devolucao_livro(IN _id_livro VARCHAR(30), IN _id_pessoa INT, IN _id_emprestimo INT, OUT _devolucao_efetuada BOOLEAN, OUT _existe_emprestimo BOOLEAN)
BEGIN
DECLARE livros_disponiveis, num_linhas INT;
DECLARE var_devolvido BOOLEAN; 
SET livros_disponiveis = (SELECT disponiveis FROM livro WHERE isbn = _id_livro);
SET num_linhas = (SELECT COUNT(*) FROM emprestimo_livro WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
SET var_devolvido = (SELECT devolvido FROM emprestimo_livro WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
#SE O EMPRESTIMO EXISTIR NO BANCO DE DADOS...
IF num_linhas > 0 THEN
#ELE VERÁ SE A DEVOLUÇÃO JÁ FOI FEITA...'
IF var_devolvido = FALSE THEN
#SE NÃO TIVER SIDO REALIZADA, O LIVRO SERÁ DEVOLVIDO E DISPONIBILIZADO PARA NOVOS EMPRÉSTIMOS'
UPDATE emprestimo_livro
SET devolvido = TRUE
WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa;
UPDATE livro
SET disponiveis = (livros_disponiveis + 1)
WHERE isbn = _id_livro;
SET _devolucao_efetuada = TRUE;
SET _existe_emprestimo = TRUE;
#SE JÁ FOI DEVOLVIDO, O PROCEDIMENTO RETORNARÁ FALSO'
ELSE
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = TRUE;
END IF;
ELSE
#SE O EMPRÉSTIMO NÃO EXISTIR'
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = FALSE;
END IF;
END$$
DELIMITER ;

#PROCEDURES DE MATERIAL ESPECIAL
################################
DELIMITER $$
CREATE PROCEDURE add_emprestimo_material_especial(IN _id_material_especial INT, IN _id_pessoa INT, IN _data_devolucao DATE, OUT _disponivel BOOLEAN)
BEGIN
DECLARE material_especial_disponiveis INT;
SET material_especial_disponiveis = (SELECT disponiveis
FROM materialespecial
WHERE id_material_especial = _id_material_especial);
IF material_especial_disponiveis >0 THEN
INSERT INTO emprestimo_material_especial(id_material_especial, id_pessoa, dataemprestimo, datadevolucao) VALUES(_id_material_especial, _id_pessoa, NOW(), _data_devolucao);
UPDATE materialespecial SET disponiveis = (material_especial_disponiveis -1) WHERE id_material_especial = _id_material_especial;
SET _disponivel = TRUE;
ELSE
SET _disponivel = FALSE;
END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_material_especial(IN _id_tipo_material_especial INT, IN _titulo VARCHAR(20), IN _codigobarras VARCHAR(13), IN _estante INT, IN _exemplares INT, IN _descricao VARCHAR(250), OUT _gravado BOOLEAN)
#PROCEDURE RESPONSÁVEL POR ADICIONAR MATERIAIS ESPECIAIS AO BANCO DE DADOS
#UMA DAS FUNÇÕES É CERTIFICAR QUE O NÚMERO DE EXEMPLARES ADICIONADOS 
#SEJA IGUAL AO NÚMERO DE EXEMPLARES DISPONÍVEIS
BEGIN
SET _gravado = FALSE;
INSERT INTO materialespecial(id_tipo_material_especial, titulo, codigobarras, estante, exemplares, disponiveis, descricao)
VALUES(_id_tipo_material_especial, _titulo, _codigobarras, _estante, _exemplares, _exemplares, _descricao);
SET _gravado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_exemplares_material_especial(IN _id_material_especial INT, IN qtde_add INT, OUT _atualizado BOOLEAN)
BEGIN
DECLARE $exemplares, $disponiveis INT;
SET _atualizado = FALSE;
SET $exemplares = (SELECT exemplares FROM materialespecial WHERE id_material_especial = _id_material_especial);
SET $disponiveis = (SELECT disponiveis FROM materialespecial WHERE id_material_especial = _id_material_especial);
UPDATE materialespecial SET  exemplares = (qtde_add + $exemplares), disponiveis = (qtde_add + $disponiveis) WHERE id_material_especial = _id_material_especial;
SET _atualizado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE devolucao_material_especial(IN _id_material_especial INT, IN _id_pessoa INT, IN _id_emprestimo INT, OUT _devolucao_efetuada BOOLEAN, OUT _existe_emprestimo BOOLEAN)
BEGIN
DECLARE material_especial_disponiveis, num_linhas INT;
DECLARE var_devolvido BOOLEAN; 
SET material_especial_disponiveis = (SELECT disponiveis FROM materialespecial WHERE id_material_especial = _id_material_especial);
SET num_linhas = (SELECT COUNT(*) FROM emprestimo_material_especial WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
SET var_devolvido = (SELECT devolvido FROM emprestimo_material_especial WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa);
#SE O EMPRESTIMO EXISTIR NO BANCO DE DADOS...
IF num_linhas > 0 THEN
#ELE VERÁ SE A DEVOLUÇÃO JÁ FOI FEITA...'
IF var_devolvido = FALSE THEN
#SE NÃO TIVER SIDO REALIZADA, O MATERIAL ESPECIAL SERÁ DEVOLVIDO E DISPONIBILIZADO PARA NOVOS EMPRÉSTIMOS'
UPDATE emprestimo_material_especial
SET devolvido = TRUE
WHERE id = _id_emprestimo AND id_pessoa = _id_pessoa;
UPDATE materialespecial
SET disponiveis = (material_especial_disponiveis + 1)
WHERE id_material_especial = _id_material_especial;
SET _devolucao_efetuada = TRUE;
SET _existe_emprestimo = TRUE;
#SE JÁ FOI DEVOLVIDO, O PROCEDIMENTO RETORNARÁ FALSO'
ELSE
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = TRUE;
END IF;
ELSE
#SE O EMPRÉSTIMO NÃO EXISTIR'
SET _devolucao_efetuada = FALSE;
SET _existe_emprestimo = FALSE;
END IF;
END$$
DELIMITER ;