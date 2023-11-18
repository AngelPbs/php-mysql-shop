-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 07-Set-2023 às 09:12
-- Versão do servidor: 5.7.24
-- versão do PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `nome`, `senha`, `role`) VALUES
(1, 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `detalhes_encomenda`
--

CREATE TABLE `detalhes_encomenda` (
  `detalhe_id` int(11) NOT NULL,
  `encomenda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_total_produto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `detalhes_encomenda`
--

INSERT INTO `detalhes_encomenda` (`detalhe_id`, `encomenda_id`, `produto_id`, `quantidade`, `preco_total_produto`) VALUES
(27, 7, 4, 1, '1.10'),
(28, 8, 4, 1, '1.10'),
(29, 9, 4, 1, '1.10'),
(52, 15, 4, 6, '6.60'),
(53, 15, 3, 4, '4.80'),
(54, 15, 3, 1, '1.20'),
(55, 15, 3, 1, '1.20'),
(56, 15, 3, 1, '1.20'),
(57, 15, 3, 1, '1.20'),
(58, 15, 3, 1, '1.20'),
(59, 15, 3, 1, '1.20'),
(60, 15, 2, 4, '4.00'),
(61, 15, 2, 1, '1.00'),
(62, 15, 2, 1, '1.00'),
(63, 15, 2, 1, '1.00'),
(64, 15, 4, 1, '1.10'),
(65, 15, 4, 1, '1.10'),
(66, 15, 4, 1, '1.10'),
(67, 15, 4, 1, '1.10'),
(68, 15, 4, 1, '1.10'),
(69, 15, 4, 1, '1.10'),
(70, 15, 3, 1, '1.20'),
(71, 15, 3, 1, '1.20'),
(72, 15, 3, 1, '1.20'),
(73, 15, 2, 1, '1.00'),
(74, 15, 2, 1, '1.00'),
(75, 15, 2, 1, '1.00'),
(76, 15, 2, 1, '1.00'),
(77, 15, 2, 1, '1.00'),
(78, 15, 13, 7, '84.00'),
(79, 16, 3, 3, '3.60'),
(80, 16, 3, 1, '1.20'),
(81, 16, 3, 1, '1.20'),
(82, 16, 3, 1, '1.20'),
(83, 16, 3, 1, '1.20'),
(84, 16, 3, 1, '1.20'),
(85, 16, 3, 1, '1.20'),
(86, 16, 2, 3, '3.00'),
(87, 16, 2, 1, '1.00'),
(88, 16, 2, 1, '1.00'),
(89, 16, 2, 1, '1.00'),
(90, 16, 4, 1, '1.10'),
(91, 16, 3, 1, '1.20'),
(92, 16, 3, 1, '1.20'),
(93, 16, 3, 1, '1.20'),
(94, 16, 2, 1, '1.00'),
(95, 16, 2, 1, '1.00'),
(96, 16, 2, 1, '1.00'),
(97, 16, 2, 1, '1.00'),
(98, 16, 2, 1, '1.00'),
(99, 16, 13, 6, '72.00'),
(100, 16, 4, 1, '1.10'),
(101, 16, 4, 1, '1.10'),
(102, 16, 4, 1, '1.10'),
(103, 16, 4, 1, '1.10'),
(104, 16, 4, 1, '1.10'),
(105, 16, 4, 1, '1.10'),
(106, 16, 4, 1, '1.10'),
(107, 16, 4, 1, '1.10'),
(108, 16, 4, 1, '1.10'),
(109, 16, 4, 1, '1.10'),
(114, 19, 1, 2, '10.00'),
(115, 19, 3, 2, '2.40'),
(116, 19, 4, 3, '3.30'),
(117, 19, 7, 3, '6.30'),
(118, 19, 13, 3, '6.00'),
(119, 20, 1, 2, '10.00'),
(120, 20, 3, 2, '2.40'),
(121, 20, 4, 3, '3.30'),
(122, 20, 7, 3, '6.30'),
(123, 20, 13, 3, '6.00'),
(124, 20, 8, 1, '1.90'),
(125, 21, 4, 1, '1.10'),
(126, 21, 3, 2, '2.40'),
(127, 21, 6, 1, '1.50'),
(128, 21, 7, 1, '2.10'),
(129, 21, 8, 7, '13.30'),
(130, 22, 3, 2, '2.40'),
(131, 23, 3, 2, '2.40'),
(132, 24, 3, 2, '2.40'),
(133, 25, 3, 2, '2.40'),
(134, 26, 3, 2, '2.40'),
(135, 27, 3, 2, '2.40'),
(136, 28, 3, 2, '2.40'),
(137, 28, 1, 1, '5.00'),
(138, 29, 3, 2, '2.40'),
(139, 29, 1, 5, '25.00'),
(140, 30, 3, 2, '2.40'),
(141, 30, 1, 5, '25.00'),
(142, 31, 3, 3, '3.60'),
(143, 31, 13, 7, '14.00'),
(144, 32, 3, 3, '3.60');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `encomenda_id` int(11) NOT NULL,
  `utilizador_id` int(11) DEFAULT NULL,
  `nome_cliente` varchar(255) NOT NULL,
  `data_nascimento_cliente` date NOT NULL,
  `morada_cliente` text NOT NULL,
  `data_encomenda` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`encomenda_id`, `utilizador_id`, `nome_cliente`, `data_nascimento_cliente`, `morada_cliente`, `data_encomenda`) VALUES
(7, 0, 'Paulo Vieira', '1222-12-12', 'Rua do outeiro 58 1º esq', '2023-08-21 18:17:27'),
(8, 0, 'Paulo Vieira', '1222-12-12', 'Rua do outeiro 58 1º esq', '2023-08-21 18:17:30'),
(9, 0, 'errdasdasd', '1222-12-12', 'Rua do outeiro 58 1º esq', '2023-08-21 18:17:39'),
(15, NULL, 'vanessa', '1992-10-20', 'vizela', '2023-08-22 14:50:03'),
(16, NULL, 'rute', '1931-10-30', 'lisboa', '2023-08-22 15:05:13'),
(19, NULL, 'Last Test', '1992-09-01', 'Master D', '2023-09-01 14:11:05'),
(20, NULL, 'admin', '1992-12-12', 'rua do porto', '2023-09-01 14:18:56'),
(21, NULL, 'Pedro', '1990-12-12', 'Lousada', '2023-09-05 16:26:38'),
(22, NULL, 'teste Alface', '1990-10-10', 'testing', '2023-09-05 16:33:56'),
(23, NULL, 'again', '1000-10-10', 'porto', '2023-09-05 16:36:39'),
(24, NULL, 'Paulo Vieira', '1211-12-12', 'nobo', '2023-09-05 16:37:19'),
(25, NULL, '111', '1111-11-11', '11', '2023-09-05 16:38:15'),
(26, NULL, '22', '1222-11-11', '222', '2023-09-05 16:44:01'),
(27, NULL, '33', '0320-03-31', '123', '2023-09-05 16:47:14'),
(28, NULL, '44', '0044-04-04', '4', '2023-09-05 16:48:40'),
(29, NULL, '55', '0055-05-05', '5', '2023-09-05 16:49:13'),
(30, NULL, '66', '0066-06-06', '6', '2023-09-05 16:50:29'),
(31, NULL, 'Paulo Soares', '1990-12-12', 'riasiasdjasd', '2023-09-06 09:20:51'),
(32, NULL, 'gg', '0011-11-11', '24545', '2023-09-06 09:42:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `quantidade`, `preco`, `imagem`) VALUES
(1, 'Abacate', 15, '5.00', '../imagens/1.png'),
(2, 'Agua', 2, '1.00', '../imagens/2.png'),
(3, 'Alface', 6, '1.20', '../imagens/3.png'),
(4, 'Bananas', 5, '1.10', '../imagens/4.png'),
(5, 'Cenouras', 30, '0.90', '../imagens/5.png'),
(6, 'Laranjas', 30, '1.50', '../imagens/6.png'),
(7, 'Maça Verde', 27, '2.10', '../imagens/7.png'),
(8, 'Maça Vermelha', 28, '1.90', '../imagens/8.png'),
(9, 'Melancia', 0, '3.00', '../imagens/9.png'),
(10, 'Pão', 40, '0.25', '../imagens/10.png'),
(11, 'Peras', 40, '1.80', '../imagens/11.png'),
(12, 'morangos', 0, '1.00', '../imagens/14.png'),
(13, 'limao', 6, '2.00', '../imagens/13.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `detalhes_encomenda`
--
ALTER TABLE `detalhes_encomenda`
  ADD PRIMARY KEY (`detalhe_id`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`encomenda_id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_produto_id` (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `detalhes_encomenda`
--
ALTER TABLE `detalhes_encomenda`
  MODIFY `detalhe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `encomenda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
