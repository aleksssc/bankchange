-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15-Out-2021 às 00:37
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bankchange`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `crypto_currencies`
--

CREATE TABLE `crypto_currencies` (
  `id_crypto` int(11) NOT NULL,
  `name_crypto` varchar(30) NOT NULL,
  `symbol_crypto` varchar(3) DEFAULT NULL,
  `price_crypto` int(11) NOT NULL,
  `stock_crypto` int(11) NOT NULL,
  `image_crypto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `crypto_currencies`
--

INSERT INTO `crypto_currencies` (`id_crypto`, `name_crypto`, `symbol_crypto`, `price_crypto`, `stock_crypto`, `image_crypto`) VALUES
(1, 'Bitcoin', 'BTC', 49647, 0, 'bitcoin_wall.jpg'),
(2, 'Ethereum', 'ETH', 3248, 0, 'ethereum_wall.jpg'),
(3, 'Binance', 'BNB', 404, 0, 'binance_wall.jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `crypto_wallet`
--

CREATE TABLE `crypto_wallet` (
  `id_crypto_wallet` int(11) NOT NULL,
  `FK_id_wallet` int(11) NOT NULL,
  `FK_id_crypto` int(11) NOT NULL,
  `price_paid_crypto` int(11) NOT NULL,
  `data_crypto_bought` datetime NOT NULL,
  `waiting_sell` varchar(3) DEFAULT 'no',
  `waiting_since_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `crypto_wallet`
--

INSERT INTO `crypto_wallet` (`id_crypto_wallet`, `FK_id_wallet`, `FK_id_crypto`, `price_paid_crypto`, `data_crypto_bought`, `waiting_sell`, `waiting_since_date`) VALUES
(185, 50, 1, 49777, '2021-10-14 22:20:15', 'no', NULL),
(186, 50, 2, 3264, '2021-10-14 22:20:15', 'no', NULL),
(187, 50, 3, 404, '2021-10-14 23:35:41', 'no', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `transfer_logs`
--

CREATE TABLE `transfer_logs` (
  `id_log` int(11) NOT NULL,
  `desc_log` varchar(50) NOT NULL,
  `FK_id_user_from` int(11) NOT NULL,
  `FK_id_cripto` int(11) NOT NULL,
  `price_paid_log` int(11) DEFAULT NULL,
  `FK_id_user_to` int(11) DEFAULT NULL,
  `date_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `transfer_logs`
--

INSERT INTO `transfer_logs` (`id_log`, `desc_log`, `FK_id_user_from`, `FK_id_cripto`, `price_paid_log`, `FK_id_user_to`, `date_log`) VALUES
(15, 'Bought From', 1, 3, 404, 32, '2021-10-14 21:21:57'),
(16, 'Bought From', 32, 3, 403, 1, '2021-09-14 21:24:54'),
(17, 'Announced on the market', 1, 3, NULL, NULL, '2021-10-14 21:28:39'),
(18, 'Bought From', 1, 3, 403, 32, '2021-08-14 21:32:53'),
(19, 'Announced on the market', 32, 3, NULL, NULL, '2021-10-14 21:34:36'),
(20, 'Bought From', 32, 3, 403, 32, '2021-05-14 21:34:38'),
(21, 'Announced on the market', 32, 3, NULL, NULL, '2021-10-14 21:36:34'),
(22, 'Bought From', 32, 3, 402, 1, '2021-10-14 22:00:38'),
(23, 'Announced on the market', 1, 3, NULL, NULL, '2021-10-14 22:02:17'),
(24, 'Bought From', 1, 3, 402, 32, '2021-10-14 22:02:24'),
(25, 'Announced on the market', 32, 3, NULL, NULL, '2021-10-14 23:31:39'),
(26, 'Bought From', 32, 3, 404, 1, '2021-10-14 23:35:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `l_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `FK_id_user_type` int(1) NOT NULL DEFAULT 3,
  `password` varchar(255) NOT NULL,
  `balance` int(11) DEFAULT 2500,
  `image` varchar(255) DEFAULT 'default.png',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `l_name`, `email`, `FK_id_user_type`, `password`, `balance`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Alexandre', 'Cardinha', 'alexcardinha14@gmail.com', 4, '202cb962ac59075b964b07152d234b70', -50036500, 'bico de pato.png', '2021-10-07 14:50:42', '2021-10-11 21:56:21'),
(32, 'Teste', 'Dos Testes', 'teste@gmail.com', 4, '202cb962ac59075b964b07152d234b70', 0, 'default.png', '2021-10-14 21:18:26', '2021-10-14 21:18:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_types`
--

CREATE TABLE `user_types` (
  `id_user_type` int(11) NOT NULL,
  `name_user_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user_types`
--

INSERT INTO `user_types` (`id_user_type`, `name_user_type`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Undefined'),
(4, 'Free User'),
(5, 'Learner'),
(6, 'Investor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` int(11) NOT NULL,
  `name_wallet` varchar(30) NOT NULL,
  `desc_wallet` varchar(100) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status_wallet` varchar(10) NOT NULL DEFAULT 'active',
  `FK_id_user` int(11) NOT NULL,
  `using` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `name_wallet`, `desc_wallet`, `amount`, `status_wallet`, `FK_id_user`, `using`) VALUES
(49, 'Primeira Carteira Teste', 'Primeira Carteira Teste', 2097, 'active', 32, 1),
(50, 'teste', 'teste', 50000000, 'active', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  ADD PRIMARY KEY (`id_crypto`);

--
-- Índices para tabela `crypto_wallet`
--
ALTER TABLE `crypto_wallet`
  ADD PRIMARY KEY (`id_crypto_wallet`),
  ADD KEY `FK_id_crypto` (`FK_id_crypto`),
  ADD KEY `FK_id_wallet` (`FK_id_wallet`);

--
-- Índices para tabela `transfer_logs`
--
ALTER TABLE `transfer_logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `FK_id_user_from` (`FK_id_user_from`),
  ADD KEY `FK_id_user_to` (`FK_id_user_to`),
  ADD KEY `FK_id_cripto` (`FK_id_cripto`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_user_type` (`FK_id_user_type`);

--
-- Índices para tabela `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id_user_type`);

--
-- Índices para tabela `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_wallet`),
  ADD KEY `FK_id_user` (`FK_id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `crypto_currencies`
--
ALTER TABLE `crypto_currencies`
  MODIFY `id_crypto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `crypto_wallet`
--
ALTER TABLE `crypto_wallet`
  MODIFY `id_crypto_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de tabela `transfer_logs`
--
ALTER TABLE `transfer_logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `crypto_wallet`
--
ALTER TABLE `crypto_wallet`
  ADD CONSTRAINT `crypto_wallet_ibfk_1` FOREIGN KEY (`FK_id_crypto`) REFERENCES `crypto_currencies` (`id_crypto`),
  ADD CONSTRAINT `crypto_wallet_ibfk_2` FOREIGN KEY (`FK_id_wallet`) REFERENCES `wallet` (`id_wallet`);

--
-- Limitadores para a tabela `transfer_logs`
--
ALTER TABLE `transfer_logs`
  ADD CONSTRAINT `transfer_logs_ibfk_1` FOREIGN KEY (`FK_id_user_from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transfer_logs_ibfk_2` FOREIGN KEY (`FK_id_user_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transfer_logs_ibfk_3` FOREIGN KEY (`FK_id_cripto`) REFERENCES `crypto_currencies` (`id_crypto`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`FK_id_user_type`) REFERENCES `user_types` (`id_user_type`);

--
-- Limitadores para a tabela `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`FK_id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
