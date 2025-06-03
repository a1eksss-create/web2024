-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 28 2025 г., 14:58
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `menu`
--

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `product_id`, `user_name`, `comment`, `created_at`) VALUES
(1, 1, 'Алексей', 'Отличная видеокарта! Всё летает', '2025-05-21 18:35:39'),
(2, 3, 'Артём', 'К сожалению, не потянула игры....', '2025-05-21 18:54:00'),
(3, 3, 'Иван', 'Фильмы смотреть и в интернете лазить - пойдёт', '2025-05-21 18:54:25');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `description`) VALUES
(1, 'Видеокарта Gigabyte GeForce RTX 3070 Aorus Master', 'uploads/1.png', '327652.00', 'GeForce RTX 3070 с памятью 8 ГБ и пропускной способностью памяти 4-48 ГБ/с имеет 5-888 ядра CUDA, ядра трассировки лучей второго поколения и тензорные ядра третьего поколения, работающие параллельно. Это наиболее подходящее решение для тех, кто занимается играми, рендерингом и разработкой технологий искусственного интеллекта.'),
(2, 'Видеокарта MSI GeForce RTX 5080 16G Ventus 3X OC Plus', 'uploads/2.png', '143375.00', 'Видеокарта MSI GeForce RTX 5080 VENTUS OC PLUS - это профессиональное решение для тех, кто ищет высокую производительность и качество изображения. Она работает на архитектуре NVIDIA Blackwell и поддерживает технологию DLSS 4, что обеспечивает высокую производительность и реалистичность изображения.'),
(3, 'Видеокарта GIGABYTE GeForce RTX 3050 OC 6Gb', 'uploads/3.png', '24107.00', 'Видеокарта Gigabyte PCI-E 4.0 GV-N3050OC-6GL NVIDIA GeForce RTX 3050 8Gb 128bit GDDR6 1822/14000 HDMIx2 DPx2 HDCP Ret.Видеокарта GIGABYTE GeForce RTX 3050 OC оснащена 6 ГБ видеопамяти стандарта GDDR6 и работает на частоте 1477 МГц. Она поддерживает технологию трассировки лучей и искусственного интеллекта NVIDIA DLSS, что обеспечивает высокую производительность и качество графики в современных играх и приложениях.');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
