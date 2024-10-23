-- -----------------------------------------------------
-- Script de Criação do Banco de Dados
-- -----------------------------------------------------

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema horapet
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema horapet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS horapet DEFAULT CHARACTER SET utf8mb4 ;
USE horapet ;

-- -----------------------------------------------------
-- Table horapet.cliente
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.cliente (
  id_cliente INT          NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o cliente',
  nome 		 VARCHAR(100) NOT NULL 				  COMMENT 'Nome completo do cliente',
  telefone   VARCHAR(15)  NOT NULL 				  COMMENT 'Número de telefone do cliente',
  email      VARCHAR(150) NOT NULL 				  COMMENT 'Endereço de email do cliente',
  estado 	 VARCHAR(2)   NOT NULL 				  COMMENT 'Sigla do estado onde o cliente reside (Ex: SP, RJ)',
  cidade 	 VARCHAR(100) NOT NULL 				  COMMENT 'Nome da cidade onde o cliente reside',
  bairro 	 VARCHAR(100) NOT NULL 				  COMMENT 'Nome do bairro onde o cliente reside',
  rua 		 VARCHAR(150) NOT NULL 				  COMMENT 'Nome da rua onde o cliente reside',
  numero 	 INT              NULL 				  COMMENT 'Número da residência do cliente',
  PRIMARY KEY (id_cliente))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.raca
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.raca (
  id_raca  INT 			NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única a raça',
  nome     VARCHAR(100) NOT NULL 				COMMENT 'Nome da raça do pet',
  foto     VARCHAR(255) NOT NULL 				COMMENT 'Caminho do arquivo de imagem representando a raça',
  tipo_pet INT 			NOT NULL 				COMMENT 'Tipo do animal a que pertence a raça: | 1 - Cachorro | 2 - Gato |',
  PRIMARY KEY (id_raca))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.pet
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.pet (
  id_pet 	 INT 		  NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o pet',
  tipo_pet 	 INT 		  NOT NULL 				  COMMENT 'Tipo do pet: | 1 - Cachorro | 2 - Gato |',
  nome 		 VARCHAR(100) NOT NULL 				  COMMENT 'Nome do pet',
  altura 	 DECIMAL(5,2) NOT NULL 				  COMMENT 'Altura do pet, armazenada em centímetros (Ex: 50 cm)',
  peso 		 DECIMAL(5,2) NOT NULL 				  COMMENT 'Peso do pet, armazenado em quilos (Ex: 12.50 kg)',
  porte      INT 		  NOT NULL 				  COMMENT 'Porte do pet: | 1 - Mini | 2 - Pequeno | 3 - Médio | 4 - Grande | 5 - Gigante |',
  foto       VARCHAR(255) NOT NULL 				  COMMENT 'Caminho do arquivo da foto do pet',
  id_cliente INT 		  NOT NULL 				  COMMENT 'Chave estrangeira que faz referência ao cliente (dono do pet)',
  id_raca    INT 		  NOT NULL 				  COMMENT 'Chave estrangeira que faz referência à raça do pet',
  PRIMARY KEY (id_pet),
  INDEX id_cliente (id_cliente ASC),
  INDEX id_raca (id_raca ASC),
  CONSTRAINT cliente_pet_id_cliente
    FOREIGN KEY (id_cliente)
    REFERENCES horapet.cliente (id_cliente)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT raca_pet_id_raca
    FOREIGN KEY (id_raca)
    REFERENCES horapet.raca (id_raca)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.agendamento
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.agendamento (
  id_agendamento INT  NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o agendamento',
  horario 		 TIME NOT NULL 			      COMMENT 'Horário do agendamento, armazenado no formato de hora',
  data 			 DATE NOT NULL 			      COMMENT 'Data do agendamento',
  situacao 		 INT  NOT NULL 			      COMMENT 'Situação do agendamento: | 1 - Agendado | 2 - Em Atendimento | 3 - Atendido | 4 - Cancelado |',
  id_pet 		 INT  NOT NULL 			      COMMENT 'Chave estrangeira que faz referência ao pet que será atendido',
  id_cliente 	 INT  NOT NULL 			      COMMENT 'Chave estrangeira que faz referência ao cliente que realizou o agendamento',
  PRIMARY KEY (id_agendamento),
  INDEX id_pet (id_pet ASC),
  INDEX id_cliente (id_cliente ASC),
  CONSTRAINT pet_agendamento_id_pet
    FOREIGN KEY (id_pet)
    REFERENCES horapet.pet (id_pet)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT cliente_agendamento_id_cliente
    FOREIGN KEY (id_cliente)
    REFERENCES horapet.cliente (id_cliente)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.servico
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.servico (
  id_servico INT 		  NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o serviço',
  nome 		 VARCHAR(100) NOT NULL 				  COMMENT 'Nome do serviço oferecido',
  descricao  VARCHAR(255) 	  NULL                COMMENT 'Descrição detalhada do serviço',
  valor 	 DECIMAL(6,2) NOT NULL                COMMENT 'Valor do serviço, armazenado no formato decimal (Ex: 150.00)',
  duracao 	 TIME 		  NOT NULL                COMMENT 'Duração prevista para o serviço, armazenada no formato de hora',
  PRIMARY KEY (id_servico))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.funcionario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.funcionario (
  id_funcionario  INT 		   NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o funcionário',
  nome 			  VARCHAR(100) NOT NULL 			   COMMENT 'Nome completo do funcionário',
  data_nascimento DATE 		   NOT NULL 			   COMMENT 'Data de nascimento do funcionário',
  telefone 		  VARCHAR(15)  NOT NULL 			   COMMENT 'Número de telefone do funcionário',
  email 		  VARCHAR(150) NOT NULL 			   COMMENT 'Endereço de email do funcionário',
  PRIMARY KEY (id_funcionario))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.execucao
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.execucao (
  id_execucao    INT 		  NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única a execução de um serviço',
  situacao 	     INT 		  NOT NULL 				  COMMENT 'Situação da execução do serviço: | 1 - Planejado | 2 - Executando | 3 - Executado | 4 - Cancelado |',
  descricao      VARCHAR(255) 	  NULL 				  COMMENT 'Descrição da execução do serviço',
  valor          DECIMAL(6,2) NOT NULL 				  COMMENT 'Valor cobrado pela execução do serviço, armazenado no formato decimal',
  duracao 	     TIME 		  NOT NULL 				  COMMENT 'Duração real da execução do serviço, armazenada no formato de hora',
  id_servico     INT 		  NOT NULL 				  COMMENT 'Chave estrangeira que faz referência ao serviço executado',
  id_agendamento INT 		  NOT NULL 				  COMMENT 'Chave estrangeira que faz referência ao agendamento correspondente',
  id_funcionario INT 	      NOT NULL 				  COMMENT 'Chave estrangeira que faz referência ao funcionário responsável pela execução',
  PRIMARY KEY (id_execucao),
  INDEX id_servico (id_servico ASC),
  INDEX id_agendamento (id_agendamento ASC),
  INDEX id_funcionario (id_funcionario ASC),
  CONSTRAINT servico_execucao_id_servico
    FOREIGN KEY (id_servico)
    REFERENCES horapet.servico (id_servico)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT agendamento_execucao_id_agendamento
    FOREIGN KEY (id_agendamento)
    REFERENCES horapet.agendamento (id_agendamento)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT funcionario_execucao_id_funcionario
    FOREIGN KEY (id_funcionario)
    REFERENCES horapet.funcionario (id_funcionario)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table horapet.usuario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS horapet.usuario (
  id_usuario INT 		  NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o usuário',
  tipo 		 INT 		  NOT NULL 				  COMMENT 'Tipo de usuário no sistema: | 1 - Admin | 2 - Funcionário | 3 - Cliente |',
  login 	 VARCHAR(100) NOT NULL 				  COMMENT 'E-mail utilizado para login no sistema',
  senha 	 VARCHAR(255) NOT NULL 				  COMMENT 'Senha do usuário para acesso ao sistema',
  id_origem  INT 		  NOT NULL 				  COMMENT 'Faz referência ao cliente ou funcionário correspondente',
  PRIMARY KEY (id_usuario))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
