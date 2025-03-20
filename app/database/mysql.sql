CREATE DATABASE  medprime;

CREATE TABLE medprime.tbUsuarios(
	usuario_id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    atualizado_em timestamp NOT NULL,
    atualizado_por INT,
    
    PRIMARY KEY(usuario_id),
	FOREIGN KEY (atualizado_por) REFERENCES medprime.tbUsuarios(usuario_id)
);

CREATE TABLE medprime.tbConsultaTipo (
	consulta_tipo_id INT NOT NULL AUTO_INCREMENT,
	descricao VARCHAR(200) NOT NULL UNIQUE,
    
    PRIMARY KEY(consulta_tipo_id)
);

CREATE TABLE medprime.tbPessoaTipo (
	pessoa_tipo_id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR (200) NOT NULL UNIQUE,
    
    PRIMARY KEY(pessoa_tipo_id)
    
);

CREATE TABLE medprime.tbPessoas(
	pessoa_id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    nascimento DATE NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    pessoa_tipo_id INT NOT NULL,
    atualizado_por INT NOT NULL,
    atualizado_em DATE NOT NULL,
    
    PRIMARY KEY(pessoa_id),
	FOREIGN KEY (pessoa_tipo_id) REFERENCES medprime.tbPessoaTipo(pessoa_tipo_id),
	FOREIGN KEY (atualizado_por) REFERENCES medprime.tbUsuarios(usuario_id)
);

CREATE TABLE medprime.tbConsulta(
	consulta_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    paciente_id INT,
    datahora TIMESTAMP NOT NULL UNIQUE,
    consulta_tipo_id INT NOT NULL,
    medico_id INT NOT NULL,
    laudo VARCHAR(255),
    atualizado_por INT NOT NULL,
    atualizado_em TIMESTAMP NOT NULL,
    
    PRIMARY KEY(consulta_id),
    FOREIGN KEY (paciente_id) REFERENCES medprime.tbPessoas(pessoa_id),
	FOREIGN KEY (consulta_tipo_id) REFERENCES medprime.tbConsultaTipo(consulta_tipo_id),
    FOREIGN KEY (medico_id) REFERENCES medprime.tbPessoas(pessoa_id)
);

