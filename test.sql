-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
--
-- Хост: localhost
-- Версия сервера: 5.5.28
-- Версия PHP: 5.3.10-1ubuntu3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `active`) VALUES
(1, 'Категория 1', 1),
(2, 'Категория2', 0),
(3, 'Категория 3', 1),
(4, '4', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `active`) VALUES
(1, 'Товар 1', 1),
(2, 'Товар 2', 1),
(3, 'Товар 3', 1),
(4, 'Товар 4', 1),
(5, 'Товар 5', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `product_to_category`
--

CREATE TABLE IF NOT EXISTS `product_to_category` (
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_to_category`
--

INSERT INTO `product_to_category` (`product_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(4, 1),
(4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `product_to_tag`
--

CREATE TABLE IF NOT EXISTS `product_to_tag` (
  `product_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  KEY `product_id` (`product_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_to_tag`
--

INSERT INTO `product_to_tag` (`product_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 3),
(2, 5),
(4, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`id`, `name`, `active`) VALUES
(1, 'Тег 1', 0),
(2, 'Тег 2', 0),
(3, 'Тег 3', 1),
(4, 'Тег 4', 1),
(5, 'Тег 5', 1),
(6, 'Тег 6', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
