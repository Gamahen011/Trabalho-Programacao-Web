-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 26/10/2026 às 21:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `delivery_web`
--

-- --------------------------------------------------------


CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `produtos` (`id`, `nome`, `preco`, `imagem`, `categoria`) VALUES
(1, 'Hambúrguer', 35.00, 'xis.jpeg', 'Lanches'),
(2, 'Cachorro Quente', 20.00, 'hotdog.jpeg', 'Lanches'),
(3, 'Pizza', 80.00, 'pizza.jpeg', 'Lanches'),
(4, 'Pastel', 18.00, 'pastel.avif', 'Lanches'),
(5, 'Porção de Fritas', 30.00, 'batata--frita.jpeg', 'Lanches'),
(6, 'Strogonoff', 25.00, 'strogonoff.avif', 'Marmitas'),
(7, 'Frango', 20.00, 'frango.webp', 'Marmitas'),
(8, 'Almôndegas', 30.00, 'almondegas.avif', 'Marmitas'),
(9, 'Espaguete Bolonhesa', 25.00, 'espaguete.webp', 'Marmitas'),
(10, 'Peixe', 20.00, 'peixe.jpg', 'Marmitas');


CREATE TABLE `usuarios` (
  `cpf` char(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `usuarios` (`cpf`, `nome`, `login`, `senha`, `data_nascimento`, `email`) VALUES
('gama', 'gama', 'gama', '$2y$10$a6Dg4aLIDD0g5048Qs431e6bfL2MARCSXSP0eD0mfQlUnqf1HMDj.', '2026-10-23', 'gama@gama'),
('gerager', 'gargt', 'gergre', '$2y$10$GcCjDnBIqgmlLqgxc6EUju5n0zf70wI7XqieiCeJ/EvRbgTplLWEe', '2026-10-20', 'gergaerg@gdag');


ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cpf`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
