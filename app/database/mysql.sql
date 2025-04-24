CREATE DATABASE  medprime;

CREATE TABLE medprime.tbPerfil (
	perfil_id INT NOT NULL AUTO_INCREMENT,
    descricao VARCHAR (200) NOT NULL UNIQUE,
    
    PRIMARY KEY(perfil_id)
);

INSERT INTO medprime.tbPerfil (descricao) VALUES 
('admin'),
('médico'),
('paciente');

CREATE TABLE medprime.tbUsuarios(
	usuario_id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    perfil_id INT NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    nascimento DATE,
    login VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255),
    telefone VARCHAR(20),
	ativo TINYINT(1) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    atualizado_por INT DEFAULT NULL,
    
    PRIMARY KEY(usuario_id),
    FOREIGN KEY (perfil_id) REFERENCES medprime.tbPerfil(perfil_id),
    FOREIGN KEY (atualizado_por) REFERENCES medprime.tbUsuarios(usuario_id)
);

INSERT INTO medprime.tbUsuarios(nome, perfil_id, login, cpf, nascimento, email, telefone, ativo, senha, atualizado_em, atualizado_por) 
VALUES 
('Administrator', 1, 'admin', NULL, NULL, NULL, NULL, 1, '$2y$10$41I.w1YkgV6hNraRJc1MQuPxhSE5L9kXeqB2DY5nnRtkr/BITJ7.O', CURRENT_TIMESTAMP, NULL);

CREATE TABLE medprime.tbConsultaTipo (
	consulta_tipo_id INT NOT NULL AUTO_INCREMENT,
	descricao VARCHAR(200) NOT NULL UNIQUE,
    
    PRIMARY KEY(consulta_tipo_id)
);

INSERT INTO medprime.tbConsultaTipo (descricao) VALUES
('Ortopedia'),
('Oftalmologia'),
('Urologia'),
('Neurologia'),
('Endocrinologia'),
('Reumatologia'),
('Nutrição'),
('Fisioterapia'),
('Otorrinolaringologia'),
('Infectologia'),
('Clínico Geral Domiciliar'),
('Pré-Natal'),
('Avaliação Cirúrgica'),
('Acompanhamento de Medicação'),
('Emissão de Atestado Médico');

CREATE TABLE medprime.tbConsulta (
	consulta_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    paciente_id INT,
    datahora TIMESTAMP NOT NULL UNIQUE,
    consulta_tipo_id INT NOT NULL,
    medico_id INT NOT NULL,
    laudo VARCHAR(255),
    atualizado_por INT NOT NULL,
    atualizado_em TIMESTAMP NOT NULL,
    
    PRIMARY KEY(consulta_id),
    FOREIGN KEY (paciente_id) REFERENCES medprime.tbUsuarios(usuario_id),
	FOREIGN KEY (consulta_tipo_id) REFERENCES medprime.tbConsultaTipo(consulta_tipo_id),
    FOREIGN KEY (medico_id) REFERENCES medprime.tbUsuarios(usuario_id)
);



