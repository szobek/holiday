-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Feb 20. 15:04
-- Kiszolgáló verziója: 10.1.28-MariaDB
-- PHP verzió: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `holiday`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_companies`
--

CREATE TABLE `miwrk3hzm7_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_companies`
--

INSERT INTO `miwrk3hzm7_companies` (`id`, `name`, `address`, `short_name`, `tax`) VALUES
(1, 'MŰSZERFAL Informatikai Tanácsadó Korlátolt Felelősségű Társaság', '4025 Debrecen, Hatvan utca 56. tetőtér 13.', 'Műszerfal kft.', '24217482-2-09'),
(2, 'Versenyhajó Értékteremtési és Tanácsadó Korlátolt Felelősségű Társaság', '8623 Balatonföldvár, József Attila u. 13.', 'Versenyhajó kft.', '14517884-2-14'),
(3, 'EGYÁRBOCOS Kft.', '4362 Nyírgelse, Ady Endre u. 13.', 'EGYÁRBOCOS Kft.', '14890024-2-15'),
(4, 'Tőkesúly Kft.', '8623 Balatonföldvár, József Attila u. 13.', 'Tőkesúly Kft.', '22697747-2-14'),
(5, 'Bolygó Szociális Szövetkezet', '8623 Balatonföldvár, József Attila u. 13/A.', 'Bolygó Szociális Szövetkezet', '24386481-2-14'),
(6, 'Pillér Szolgáltató Szociális Szövetkezet', '4362 Nyírgelse, Ady Endre u. 13.', 'Pillér Szolgáltató Szociális Szövetkezet', '24386625-2-15'),
(7, 'Beauty Capsule', '8626 Földvár, Kiss utca 14.', 'Beauty', '1454878-88-8');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_companies_user`
--

CREATE TABLE `miwrk3hzm7_companies_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `companies_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_companies_user`
--

INSERT INTO `miwrk3hzm7_companies_user` (`id`, `user_id`, `companies_id`, `created_at`, `updated_at`) VALUES
(102, 5, 4, '2018-01-18 07:47:33', '2018-01-18 07:47:33'),
(103, 9, 1, '2018-01-18 09:13:43', '2018-01-18 09:13:43'),
(104, 9, 2, '2018-01-18 09:13:43', '2018-01-18 09:13:43'),
(105, 9, 3, '2018-01-18 09:13:43', '2018-01-18 09:13:43'),
(113, 2, 4, '2018-01-18 11:57:07', '2018-01-18 11:57:07'),
(114, 2, 5, '2018-01-18 11:57:07', '2018-01-18 11:57:07'),
(115, 4, 3, '2018-01-18 11:58:02', '2018-01-18 11:58:02'),
(116, 4, 4, '2018-01-18 11:58:02', '2018-01-18 11:58:02'),
(117, 3, 4, '2018-01-18 12:01:26', '2018-01-18 12:01:26'),
(152, 17, 1, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(153, 17, 2, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(154, 17, 3, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(155, 17, 4, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(156, 17, 5, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(157, 17, 6, '2018-02-02 12:14:32', '2018-02-02 12:14:32'),
(158, 18, 1, '2018-02-19 07:46:35', '2018-02-19 07:46:35'),
(159, 19, 1, '2018-02-19 07:48:27', '2018-02-19 07:48:27'),
(160, 1, 1, '2018-02-19 07:53:18', '2018-02-19 07:53:18'),
(161, 1, 2, '2018-02-19 07:53:18', '2018-02-19 07:53:18'),
(162, 1, 3, '2018-02-19 07:53:18', '2018-02-19 07:53:18'),
(163, 1, 4, '2018-02-19 07:53:18', '2018-02-19 07:53:18'),
(164, 1, 5, '2018-02-19 07:53:18', '2018-02-19 07:53:18'),
(165, 1, 6, '2018-02-19 07:53:18', '2018-02-19 07:53:18');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_migrations`
--

CREATE TABLE `miwrk3hzm7_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_migrations`
--

INSERT INTO `miwrk3hzm7_migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2017_10_03_162027_create_companies', 1),
(16, '2017_10_04_140518_create_holiday_types', 1),
(18, '2017_10_05_085415_create_non_working', 2),
(19, '2018_01_16_093345_create_usercompanies_table', 3),
(24, '2018_01_17_130952_create_permission_rules', 4),
(25, '2018_01_17_131632_create_permissions_user_table', 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_non-working`
--

CREATE TABLE `miwrk3hzm7_non-working` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) CHARACTER SET utf8 NOT NULL DEFAULT 'holiday'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_non-working`
--

INSERT INTO `miwrk3hzm7_non-working` (`id`, `name`, `year`, `date`, `description`, `type`) VALUES
(1, 'Nemzeti Ünnep 56', '2017', '2017-10-23', 'Október 23-i ünnep', 'holiday'),
(7, 'karácsony', '2017', '2017-12-26', '…', 'holiday'),
(8, 'karácsony', '2017', '2017-12-25', '…', 'holiday'),
(9, 'karácsony', '2017', '2017-12-24', '…', 'holiday'),
(10, 'Halottak napja', '2017', '2017-11-01', '…', 'holiday'),
(11, 'Karácsony', '2018', '2018-12-25', 'Karácsony', 'holiday'),
(12, 'Karácsony', '2018', '2018-12-26', 'Karácsony 2. nap', 'holiday'),
(13, 'Nemzeti ünnep', '2018', '2018-03-15', 'Márc 15', 'holiday'),
(14, 'Május 1 ledolgozás', '2017', '2018-04-28', 'EZ a nap a ledolgozása a május 1ének', 'holiday'),
(15, 'Május 1', '2018', '2018-04-28', 'szombati ledolgozás május 1-ének', 'holiday');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_password_resets`
--

CREATE TABLE `miwrk3hzm7_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_password_resets`
--

INSERT INTO `miwrk3hzm7_password_resets` (`email`, `token`, `created_at`) VALUES
('123@456.com', '$2y$10$T1nvGZ0pRVesPtZXZ0ur7eHAEX7G6FM3zQhCy5N6d3t0Qa82KTBZu', '2018-02-19 07:50:56');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_permissions`
--

CREATE TABLE `miwrk3hzm7_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_permissions`
--

INSERT INTO `miwrk3hzm7_permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Bármilyen szabadságot', 'Bárki nevében felvihet szabadságot', NULL, '2018-01-17 13:28:13'),
(2, 'Minden szabadság', 'Mindenkinek látja a szabadságát', NULL, NULL),
(3, 'profil megtekintés', 'Más profilját megtekintheti', NULL, NULL),
(4, 'Profil szerkesztés', 'Más profilját szerkesztheti', NULL, NULL),
(5, 'Jog admin\r\n', 'Jogok szerkesztése', NULL, NULL),
(6, 'céges szabadságok', 'Csak a saját cégeinek a szabadságait látja', NULL, '2018-01-18 07:59:15'),
(7, 'saját profil ', 'Saját profil szerkesztése', NULL, NULL),
(8, 'Új felhasználó felvitel', 'Új felhasználó létrehozása', NULL, NULL),
(9, 'Profil lista', 'Felhasznélók listázása', NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_permission_user`
--

CREATE TABLE `miwrk3hzm7_permission_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_permission_user`
--

INSERT INTO `miwrk3hzm7_permission_user` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(3, 2, 3, NULL, NULL),
(16, 3, 1, '2018-01-17 16:27:59', '2018-01-17 16:27:59'),
(17, 3, 2, '2018-01-17 16:28:00', '2018-01-17 16:28:00'),
(18, 3, 3, '2018-01-17 16:28:02', '2018-01-17 16:28:02'),
(21, 4, 3, '2018-01-17 18:48:42', '2018-01-17 18:48:42'),
(27, 4, 2, '2018-01-18 07:34:30', '2018-01-18 07:34:30'),
(34, 1, 5, NULL, NULL),
(42, 2, 6, '2018-01-18 09:25:11', '2018-01-18 09:25:11'),
(44, 2, 2, '2018-01-18 11:56:35', '2018-01-18 11:56:35'),
(45, 2, 4, '2018-01-18 11:56:38', '2018-01-18 11:56:38'),
(46, 2, 5, '2018-01-18 11:56:40', '2018-01-18 11:56:40'),
(47, 2, 1, '2018-01-18 11:57:33', '2018-01-18 11:57:33'),
(51, 1, 2, '2018-01-18 13:23:06', '2018-01-18 13:23:06'),
(52, 1, 3, '2018-01-18 13:35:53', '2018-01-18 13:35:53'),
(54, 1, 8, '2018-01-18 13:54:24', '2018-01-18 13:54:24'),
(55, 17, 7, '2018-01-18 15:20:12', '2018-01-18 15:20:12'),
(56, 1, 1, '2018-01-29 07:19:47', '2018-01-29 07:19:47'),
(57, 1, 4, '2018-01-29 07:19:49', '2018-01-29 07:19:49'),
(58, 1, 6, '2018-01-29 07:19:51', '2018-01-29 07:19:51'),
(59, 1, 7, '2018-01-29 07:19:52', '2018-01-29 07:19:52'),
(61, 1, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_types`
--

CREATE TABLE `miwrk3hzm7_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_types`
--

INSERT INTO `miwrk3hzm7_types` (`id`, `name`) VALUES
(1, 'Normál'),
(2, 'Betegség'),
(3, 'Egyéb'),
(4, 'cheat');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_users`
--

CREATE TABLE `miwrk3hzm7_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holidays` int(11) DEFAULT NULL,
  `telephone` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_users`
--

INSERT INTO `miwrk3hzm7_users` (`id`, `name`, `email`, `password`, `holidays`, `telephone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kunszt Norbert', 'kunszt.norbert@gmail.com', '$2y$10$X0SF.eb4PRvGaOVdW6aN2u8Ok0mMC4d0vqabk9Y7opmfx8HJW8nY6', NULL, '+36205340145', '406NW8bEajAojXb75N0YZ487vKH4myssPaCbbJtcYRRGtKfpTBTSTjt1SmBJ', '2017-10-04 13:21:09', '2018-02-19 07:53:18'),
(3, 'Ulviczki Attila', 'ulviczki@gmail.com', '$2y$10$3gEDF9IrfTnzSn87mcWtYu5J4LaHRQtdeJ0t1WxwuEyQYTldzlHLO', NULL, NULL, 't1H5rqjOeYzAsX7o7qiDeoocdk4HhneUUj51AiVUGeCYMyfYO9J5JwlX4AWu', '2017-10-04 13:21:09', '2018-01-15 10:32:42'),
(4, 'Bárdos Mihály', 'miso470@gmail.com', '$2y$10$Yfwm2uXesYp1fqPEbgfEKe2bzuKGrP8Kytrltej6FNG.SmKTt2q3a', 15, '06704178757', NULL, '2017-10-04 13:21:09', '2018-01-17 15:04:20'),
(10, 'asd', 'info@egyarbocos.hu', '$2y$10$gUhxSBijOPdeOfhSEzHqweixZ4b71cDzRhhV3txJqLgqjc6N3BLoy', 0, '203381888', NULL, '2018-01-18 12:48:19', '2018-01-18 12:48:19'),
(12, 'asd', 'info@egyarbocos1.hu', '$2y$10$WWex5WkFCU8qiTkb8Wf.heWtq66B/03jlzC1iRh0ZLFeQSouDCYhC', 0, '203381888', NULL, '2018-01-18 13:58:01', '2018-01-18 13:58:01'),
(17, 'asdasdasd', 'muszerfal.fejlesztok@gmail.com', '$2y$10$CliDvl61Vt83kn9NQ5bNX.WZovoFTaUhfFD6oVsG7nXF9kldRgCqm', 4, '0', NULL, '2018-01-18 15:18:47', '2018-02-02 12:12:59'),
(21, 'Norbert Kunszt', 'asd@asd.hu', '$2y$10$KgVm3/1hHHMjDOtq8s/H5u5wWLKqJop8Gs2qdtQIA8M.K/UurvGFW', 0, '205340145', NULL, '2018-02-19 08:02:34', '2018-02-19 08:02:34');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `miwrk3hzm7_user_holidays`
--

CREATE TABLE `miwrk3hzm7_user_holidays` (
  `id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `google_id` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `miwrk3hzm7_user_holidays`
--

INSERT INTO `miwrk3hzm7_user_holidays` (`id`, `from_date`, `to_date`, `user_id`, `type_id`, `company_id`, `google_id`, `created_at`, `updated_at`) VALUES
(1, '2018-02-09', '2018-02-10', 1, 1, 0, '6144nega9cdhlf46tjnlgjjtoo', NULL, NULL),
(2, '2018-02-11', '2018-02-11', 1, 1, 0, NULL, NULL, NULL),
(3, '2018-02-11', '2018-02-11', 3, 1, 0, NULL, NULL, NULL),
(4, '2018-12-27', '2018-03-03', 3, 1, 1, NULL, '2018-02-05 08:58:01', '2018-02-05 08:58:01'),
(5, '2018-12-27', '2018-03-03', 3, 1, 1, NULL, '2018-02-05 08:58:29', '2018-02-05 08:58:29'),
(6, '2018-12-27', '2018-03-03', 3, 1, 1, NULL, '2018-02-05 09:07:22', '2018-02-05 09:07:22'),
(7, '2018-12-27', '2018-03-03', 3, 1, 1, NULL, '2018-02-05 09:20:59', '2018-02-05 09:20:59');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `miwrk3hzm7_companies`
--
ALTER TABLE `miwrk3hzm7_companies`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `miwrk3hzm7_companies_user`
--
ALTER TABLE `miwrk3hzm7_companies_user`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `miwrk3hzm7_migrations`
--
ALTER TABLE `miwrk3hzm7_migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `miwrk3hzm7_non-working`
--
ALTER TABLE `miwrk3hzm7_non-working`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `miwrk3hzm7_password_resets`
--
ALTER TABLE `miwrk3hzm7_password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- A tábla indexei `miwrk3hzm7_permissions`
--
ALTER TABLE `miwrk3hzm7_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_id_index` (`id`);

--
-- A tábla indexei `miwrk3hzm7_permission_user`
--
ALTER TABLE `miwrk3hzm7_permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_id_index` (`id`);

--
-- A tábla indexei `miwrk3hzm7_types`
--
ALTER TABLE `miwrk3hzm7_types`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `miwrk3hzm7_users`
--
ALTER TABLE `miwrk3hzm7_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A tábla indexei `miwrk3hzm7_user_holidays`
--
ALTER TABLE `miwrk3hzm7_user_holidays`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_companies`
--
ALTER TABLE `miwrk3hzm7_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_companies_user`
--
ALTER TABLE `miwrk3hzm7_companies_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_migrations`
--
ALTER TABLE `miwrk3hzm7_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_non-working`
--
ALTER TABLE `miwrk3hzm7_non-working`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_permissions`
--
ALTER TABLE `miwrk3hzm7_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_permission_user`
--
ALTER TABLE `miwrk3hzm7_permission_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_types`
--
ALTER TABLE `miwrk3hzm7_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_users`
--
ALTER TABLE `miwrk3hzm7_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `miwrk3hzm7_user_holidays`
--
ALTER TABLE `miwrk3hzm7_user_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
