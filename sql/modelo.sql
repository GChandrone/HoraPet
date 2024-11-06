-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Nov-2024 às 01:45
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `modelo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id_agendamento` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o agendamento',
  `horario` time NOT NULL COMMENT 'Horário do agendamento, armazenado no formato de hora',
  `data` date NOT NULL COMMENT 'Data do agendamento',
  `situacao` int(11) NOT NULL COMMENT 'Situação do agendamento: | 1 - Agendado | 2 - Em Atendimento | 3 - Atendido | 4 - Cancelado |',
  `id_pet` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao pet que será atendido',
  `id_cliente` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao cliente que realizou o agendamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL COMMENT '?',
  `Descricao` varchar(80) NOT NULL COMMENT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `Descricao`) VALUES
(1, 'Camisa'),
(2, 'Calça'),
(3, 'Calçado'),
(4, 'Acessórios');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o cliente',
  `nome` varchar(100) NOT NULL COMMENT 'Nome completo do cliente',
  `telefone` varchar(15) NOT NULL COMMENT 'Número de telefone do cliente',
  `email` varchar(150) NOT NULL COMMENT 'Endereço de email do cliente',
  `estado` varchar(2) NOT NULL COMMENT 'Sigla do estado onde o cliente reside (Ex: SP, RJ)',
  `cidade` varchar(100) NOT NULL COMMENT 'Nome da cidade onde o cliente reside',
  `bairro` varchar(100) NOT NULL COMMENT 'Nome do bairro onde o cliente reside',
  `rua` varchar(150) NOT NULL COMMENT 'Nome da rua onde o cliente reside',
  `numero` int(11) DEFAULT NULL COMMENT 'Número da residência do cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `execucao`
--

CREATE TABLE `execucao` (
  `id_execucao` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única a execução de um serviço',
  `situacao` int(11) NOT NULL COMMENT 'Situação da execução do serviço: | 1 - Planejado | 2 - Executando | 3 - Executado | 4 - Cancelado |',
  `descricao` varchar(255) DEFAULT NULL COMMENT 'Descrição da execução do serviço',
  `valor` decimal(6,2) NOT NULL COMMENT 'Valor cobrado pela execução do serviço, armazenado no formato decimal',
  `duracao` time NOT NULL COMMENT 'Duração real da execução do serviço, armazenada no formato de hora',
  `id_servico` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao serviço executado',
  `id_agendamento` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao agendamento correspondente',
  `id_funcionario` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao funcionário responsável pela execução'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o funcionário',
  `nome` varchar(100) NOT NULL COMMENT 'Nome completo do funcionário',
  `data_nascimento` date NOT NULL COMMENT 'Data de nascimento do funcionário',
  `telefone` varchar(15) NOT NULL COMMENT 'Número de telefone do funcionário',
  `email` varchar(150) NOT NULL COMMENT 'Endereço de email do funcionário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pet`
--

CREATE TABLE `pet` (
  `id_pet` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o pet',
  `tipo_pet` int(11) NOT NULL COMMENT 'Tipo do pet: | 1 - Cachorro | 2 - Gato |',
  `nome` varchar(100) NOT NULL COMMENT 'Nome do pet',
  `altura` decimal(5,2) NOT NULL COMMENT 'Altura do pet, armazenada em centímetros (Ex: 50 cm)',
  `peso` decimal(5,2) NOT NULL COMMENT 'Peso do pet, armazenado em quilos (Ex: 12.50 kg)',
  `porte` int(11) NOT NULL COMMENT 'Porte do pet: | 1 - Pequeno | 2 - Médio | 3 - Grande | ',
  `foto` varchar(255) NOT NULL COMMENT 'Caminho do arquivo da foto do pet',
  `id_cliente` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência ao cliente (dono do pet)',
  `id_raca` int(11) NOT NULL COMMENT 'Chave estrangeira que faz referência à raça do pet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(11) NOT NULL COMMENT '?',
  `idCategoria` int(11) NOT NULL COMMENT '?',
  `Descricao` varchar(80) DEFAULT NULL COMMENT '?',
  `Quantidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`idProduto`, `idCategoria`, `Descricao`, `Quantidade`) VALUES
(1, 1, 'Camisa Brasil', 9),
(2, 3, 'Sapato 44', 12),
(3, 3, 'Sapato 36', 2),
(4, 4, 'Gravata borboleta', 4),
(5, 4, 'Pulseira', 25),
(6, 4, 'Anel', 50),
(7, 2, 'Calça Amarela do Restart', 2),
(8, 1, 'Camiseta JEC Passeio', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `raca`
--

CREATE TABLE `raca` (
  `id_raca` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única a raça',
  `nome` varchar(50) NOT NULL COMMENT 'Nome da raça do pet',
  `tipo_pet` int(11) NOT NULL COMMENT 'Tipo do animal a que pertence a raça: | 1 - Cachorro | 2 - Gato |'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `raca`
--

INSERT INTO `raca` (`id_raca`, `nome`, `tipo_pet`) VALUES
(1, 'Pit Bull', 2),
(2, 'Pastor Alemão', 1),
(3, 'Labrador Retriever', 1),
(4, 'Bulldog Francês', 1),
(5, 'Poodle', 1),
(6, 'Golden Retriever', 1),
(7, 'Dachshund', 1),
(9, 'Rottweiler', 1),
(10, 'Yorkshire Terrier', 1),
(12, 'Persa', 2),
(13, 'Siamês', 2),
(14, 'Gato Oriental', 2),
(15, 'British Shorthair', 2),
(17, 'Raça indefinida', 1),
(18, 'Raça indefinida', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o serviço',
  `nome` varchar(100) NOT NULL COMMENT 'Nome do serviço oferecido',
  `descricao` varchar(255) DEFAULT NULL COMMENT 'Descrição detalhada do serviço',
  `valor_pequeno` decimal(6,2) NOT NULL COMMENT 'Valor do serviço para o porte pequeno, armazenado no formato decimal (Ex: 150.00)',
  `valor_medio` decimal(6,2) NOT NULL COMMENT 'Valor do serviço para o porte médio, armazenado no formato decimal (Ex: 150.00)',
  `valor_grande` decimal(6,2) NOT NULL COMMENT 'Valor do serviço para o porte grande, armazenado no formato decimal (Ex: 150.00)',
  `duracao_pequeno` time NOT NULL COMMENT 'Duração prevista para o serviço para o porte pequeno, armazenada no formato de hora',
  `duracao_medio` time NOT NULL COMMENT 'Duração prevista para o serviço para o porte medio, armazenada no formato de hora',
  `duracao_grande` time NOT NULL COMMENT 'Duração prevista para o serviço para o porte grande, armazenada no formato de hora',
  `ativo` int(1) NOT NULL COMMENT 'Define o status do registro | 0 - Inativo | 1 - Ativo |'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipousuario`
--

CREATE TABLE `tipousuario` (
  `idTipoUsuario` int(11) NOT NULL COMMENT 'PK - Código identificador do tipo de usuário',
  `Descricao` varchar(50) NOT NULL COMMENT 'Descrição do tipo de usuário',
  `Ativo` char(1) NOT NULL COMMENT 'Tipo de usuário ativo: S-Sim / N-Não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabela para armazenar os tipos de usuário';

--
-- Extraindo dados da tabela `tipousuario`
--

INSERT INTO `tipousuario` (`idTipoUsuario`, `Descricao`, `Ativo`) VALUES
(1, 'Admin', 'S'),
(2, 'Empresa', 'S'),
(3, 'Comum', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL COMMENT 'Chave primária que identifica de forma única o usuário',
  `tipo` int(11) NOT NULL COMMENT 'Tipo de usuário no sistema: | 1 - Admin | 2 - Funcionário | 3 - Cliente |',
  `login` varchar(100) NOT NULL COMMENT 'E-mail utilizado para login no sistema',
  `senha` varchar(255) NOT NULL COMMENT 'Senha do usuário para acesso ao sistema',
  `id_origem` int(11) NOT NULL COMMENT 'Faz referência ao cliente ou funcionário correspondente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL COMMENT 'PK - Código identificador do usuário',
  `idTipoUsuario` int(11) NOT NULL COMMENT 'FK - Código identificador do tipo de usuário',
  `Login` varchar(80) NOT NULL COMMENT 'Login de acesso (e-mail)',
  `Senha` varchar(32) NOT NULL COMMENT 'Senha md5',
  `Nome` varchar(80) NOT NULL COMMENT 'Nome do usuário',
  `Foto` varchar(200) DEFAULT NULL COMMENT 'Imagem do usuário',
  `FlgAtivo` char(1) NOT NULL COMMENT 'Usuário ativo: S-Sim / N-Não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idTipoUsuario`, `Login`, `Senha`, `Nome`, `Foto`, `FlgAtivo`) VALUES
(2, 2, 'emp@teste.com', '202cb962ac59075b964b07152d234b70', 'Teste Joao 2', 'dist/img/b9fb9d37bdf15a699bc071ce49baea53.jpg', 'S'),
(4, 1, 'j@teste.com', '202cb962ac59075b964b07152d234b70', 'Joao', 'dist/img/teste/f0f04b85f737f502c1e4352d5fc51485.png', 'S'),
(5, 1, '123@34', '3dd48ab31d016ffcbf3314df2b3cb9ce', 'Gabriel Da Cunha', 'dist/img/c411ef8e0bfd830f140f209426ba88bd.png', 'S'),
(6, 3, 'teste@comum', '202cb962ac59075b964b07152d234b70', 'teste', NULL, 'S');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `id_pet` (`id_pet`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `execucao`
--
ALTER TABLE `execucao`
  ADD PRIMARY KEY (`id_execucao`),
  ADD KEY `id_servico` (`id_servico`),
  ADD KEY `id_agendamento` (`id_agendamento`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`);

--
-- Índices para tabela `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id_pet`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_raca` (`id_raca`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `fk_Categoria` (`idCategoria`);

--
-- Índices para tabela `raca`
--
ALTER TABLE `raca`
  ADD PRIMARY KEY (`id_raca`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`);

--
-- Índices para tabela `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `fk_TipoUsuario` (`idTipoUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o agendamento';

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT COMMENT '?', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o cliente';

--
-- AUTO_INCREMENT de tabela `execucao`
--
ALTER TABLE `execucao`
  MODIFY `id_execucao` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única a execução de um serviço';

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o funcionário';

--
-- AUTO_INCREMENT de tabela `pet`
--
ALTER TABLE `pet`
  MODIFY `id_pet` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o pet';

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT COMMENT '?', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `raca`
--
ALTER TABLE `raca`
  MODIFY `id_raca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única a raça', AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o serviço';

--
-- AUTO_INCREMENT de tabela `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK - Código identificador do tipo de usuário', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária que identifica de forma única o usuário';

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK - Código identificador do usuário', AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `cliente_agendamento_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pet_agendamento_id_pet` FOREIGN KEY (`id_pet`) REFERENCES `pet` (`id_pet`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `execucao`
--
ALTER TABLE `execucao`
  ADD CONSTRAINT `agendamento_execucao_id_agendamento` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamento` (`id_agendamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `funcionario_execucao_id_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `servico_execucao_id_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `cliente_pet_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `raca_pet_id_raca` FOREIGN KEY (`id_raca`) REFERENCES `raca` (`id_raca`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`);

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tipousuario` (`idTipoUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
