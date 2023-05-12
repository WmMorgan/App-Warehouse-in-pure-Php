-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Май 12 2023 г., 11:29
-- Версия сервера: 5.7.39
-- Версия PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sklad-na-php`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cm_category`
--

CREATE TABLE `cm_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `cm_category`
--

INSERT INTO `cm_category` (`id`, `name`, `description`, `created_at`) VALUES
(3, 'Kategoriya 02', 'Test uchun description', 1683631244),
(4, 'Product 001', NULL, 1683637269),
(6, 'Xizmatlar', '', 1683889117);

-- --------------------------------------------------------

--
-- Структура таблицы `cm_product`
--

CREATE TABLE `cm_product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `measure` int(11) NOT NULL,
  `image` text,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cm_product`
--

INSERT INTO `cm_product` (`id`, `category_id`, `name`, `quantity`, `price`, `measure`, `image`, `created_at`) VALUES
(9, 4, 'Mahsulot 002', 1565, 55000, 1, 'images/mahsulot-002-645b7c06a09bd.png', 1683717126),
(11, 4, 'Mahsulot 004', 2, 0, 4, 'images/mahsulot-004-645b7ea5f3bb0.png', 1683717248),
(12, 4, 'Mahsulot 022', 1, 0, 1, 'images/mahsulot-022-645b7ef7471e1.png', 1683717879),
(13, 4, 'Mahsulot 022', 5, 0, 1, 'images/mahsulot-022-645b7f9ce769b.png', 1683718020),
(14, 4, 'Mahsulot 022', 110, 0, 3, '', 1683795095);

-- --------------------------------------------------------

--
-- Структура таблицы `cm_product_coming`
--

CREATE TABLE `cm_product_coming` (
  `id` int(11) NOT NULL,
  `comings` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cm_product_coming`
--

INSERT INTO `cm_product_coming` (`id`, `comings`, `status`, `created_at`) VALUES
(1, 'a:4:{i:9;a:1:{s:8:\"quantity\";i:1;}i:12;a:1:{s:8:\"quantity\";i:1;}i:11;a:1:{s:8:\"quantity\";i:2;}i:16;a:1:{s:8:\"quantity\";i:1;}}', 2, 1683806018),
(2, 'a:1:{i:16;a:1:{s:8:\"quantity\";i:1;}}', 2, 1683880175),
(3, 'a:1:{i:16;a:1:{s:8:\"quantity\";i:2;}}', 2, 1683880487),
(4, 'a:3:{i:10;a:1:{s:8:\"quantity\";i:1;}i:9;a:1:{s:8:\"quantity\";i:1;}i:8;a:1:{s:8:\"quantity\";i:1;}}', 2, 1683888602);

-- --------------------------------------------------------

--
-- Структура таблицы `cm_sklad`
--

CREATE TABLE `cm_sklad` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cm_sklad`
--

INSERT INTO `cm_sklad` (`id`, `name`, `created_at`) VALUES
(17, 'Sklad 02', 1683620552),
(22, 'SKlad 01', 1683621079),
(27, 'SKlad 03', 1683629049),
(28, 'Morgan', 1683629548),
(29, 'Test', 1683888541),
(30, 'Hello', 1683890162);

-- --------------------------------------------------------

--
-- Структура таблицы `cm_user`
--

CREATE TABLE `cm_user` (
  `id` int(11) NOT NULL,
  `login` varchar(200) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `active_hex` varchar(32) NOT NULL,
  `status` int(1) NOT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cm_user`
--

INSERT INTO `cm_user` (`id`, `login`, `pass`, `salt`, `active_hex`, `status`, `role`) VALUES
(1, 'admin@gmail.com', '59229c500bc9d305dc1efaaf1e28c1ca', '7b93c971', '0f71bd5e7b253daa031e59dd93f9a28c', 1, 10);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cm_category`
--
ALTER TABLE `cm_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cm_product`
--
ALTER TABLE `cm_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `cm_product_coming`
--
ALTER TABLE `cm_product_coming`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cm_sklad`
--
ALTER TABLE `cm_sklad`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cm_user`
--
ALTER TABLE `cm_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cm_category`
--
ALTER TABLE `cm_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `cm_product`
--
ALTER TABLE `cm_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `cm_product_coming`
--
ALTER TABLE `cm_product_coming`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cm_sklad`
--
ALTER TABLE `cm_sklad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `cm_user`
--
ALTER TABLE `cm_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cm_product`
--
ALTER TABLE `cm_product`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `cm_category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
