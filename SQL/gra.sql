-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Wrz 2021, 18:39
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gra`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bronie`
--

CREATE TABLE `bronie` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `atak` int(11) NOT NULL,
  `typ` int(11) NOT NULL,
  `opis` text COLLATE utf8mb4_polish_ci NOT NULL,
  `rzadkosc` varchar(15) COLLATE utf8mb4_polish_ci NOT NULL,
  `obraz` varchar(24) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `bronie`
--

INSERT INTO `bronie` (`id`, `nazwa`, `atak`, `typ`, `opis`, `rzadkosc`, `obraz`) VALUES
(1, 'Piła ręczna', 2, 1, '', 'Pospolity', '1'),
(2, 'Starożytna Włócznia', 13, 1, '', 'Rzadki', '3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ekwipunek`
--

CREATE TABLE `ekwipunek` (
  `id` int(11) NOT NULL,
  `bron_glowna` int(11) DEFAULT NULL,
  `bron_pomocnicza` int(11) DEFAULT NULL,
  `przedmiot_1` int(11) DEFAULT NULL,
  `przedmiot_2` int(11) DEFAULT NULL,
  `przedmiot_3` int(11) DEFAULT NULL,
  `przedmiot_4` int(11) DEFAULT NULL,
  `przedmiot_5` int(11) DEFAULT NULL,
  `przedmiot_6` int(11) DEFAULT NULL,
  `przedmiot_7` int(11) DEFAULT NULL,
  `przedmiot_8` int(11) DEFAULT NULL,
  `przedmiot_9` int(11) DEFAULT NULL,
  `przedmiot_10` int(11) DEFAULT NULL,
  `przedmiot_11` int(11) DEFAULT NULL,
  `przedmiot_12` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `ekwipunek`
--

INSERT INTO `ekwipunek` (`id`, `bron_glowna`, `bron_pomocnicza`, `przedmiot_1`, `przedmiot_2`, `przedmiot_3`, `przedmiot_4`, `przedmiot_5`, `przedmiot_6`, `przedmiot_7`, `przedmiot_8`, `przedmiot_9`, `przedmiot_10`, `przedmiot_11`, `przedmiot_12`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konsumpcyjne`
--

CREATE TABLE `konsumpcyjne` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `opis` text COLLATE utf8mb4_polish_ci NOT NULL,
  `leczenie_punkt` int(11) DEFAULT NULL,
  `leczenie_procent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `konsumpcyjne`
--

INSERT INTO `konsumpcyjne` (`id`, `nazwa`, `opis`, `leczenie_punkt`, `leczenie_procent`) VALUES
(1, 'Jabłko', 'Zwyczajne jabłko z drzewa', 8, NULL),
(2, 'Udko', 'Ciepłe, pieczone na ognisku udko z kurczaka', 13, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

CREATE TABLE `konta` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8mb4_polish_ci NOT NULL,
  `haslo` text COLLATE utf8mb4_polish_ci NOT NULL,
  `mail` text COLLATE utf8mb4_polish_ci NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `liczba_losowan` int(11) NOT NULL,
  `liczba_wygranych` int(11) NOT NULL,
  `gra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `konta`
--

INSERT INTO `konta` (`id`, `login`, `haslo`, `mail`, `money`, `liczba_losowan`, `liczba_wygranych`, `gra`) VALUES
(9, 'SyriuszB', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'dach109@wp.pl', '100.00', 0, 0, 3),
(17, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'projektbronowicki@gmail.com', '3222.00', 213, 11, 4),
(18, '123', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'bronowicki.kuba@wp.pl', '42.00', 1, 1, 5),
(19, 'Syriusz', '707e16464c07ee6c44ee1743834c2bbe8551d614', 'mail@wp.pl', '0.00', 2, 0, 6),
(20, 'mail', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mail', '5388.00', 39, 1, 7),
(21, '1234', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mail1@mail.com', '700.00', 0, 0, 1),
(22, '12345', '8cb2237d0679ca88db6464eac60da96345513964', '12345', '4.00', 87, 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta_gry`
--

CREATE TABLE `konta_gry` (
  `id` int(11) NOT NULL,
  `id_gracza` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `bron_1` int(11) NOT NULL,
  `bron_2` int(11) NOT NULL,
  `exp` float NOT NULL,
  `max_exp` float NOT NULL DEFAULT 120,
  `hp` float NOT NULL,
  `max_hp` float NOT NULL,
  `ekwipunek_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `konta_gry`
--

INSERT INTO `konta_gry` (`id`, `id_gracza`, `lvl`, `bron_1`, `bron_2`, `exp`, `max_exp`, `hp`, `max_hp`, `ekwipunek_id`) VALUES
(1, 21, 1, 0, 0, 0, 120, 60, 60, 1),
(2, 22, 1, 0, 0, 48, 120, 60, 60, 2),
(3, 9, 1, 0, 0, 0, 120, 60, 60, 3),
(4, 17, 2, 1, 2, 184, 252, 60, 63.6, 4),
(5, 18, 1, 0, 0, 0, 120, 60, 60, 5),
(6, 19, 1, 0, 0, 0, 120, 60, 60, 6),
(7, 20, 1, 0, 0, 0, 120, 60, 60, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `tresc` text COLLATE utf8mb4_polish_ci NOT NULL,
  `od_kogo` int(11) NOT NULL,
  `do_kogo` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `wyswietlona` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `neutralne`
--

CREATE TABLE `neutralne` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `opis` text COLLATE utf8mb4_polish_ci NOT NULL,
  `lvl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `overworld_chat`
--

CREATE TABLE `overworld_chat` (
  `id` int(11) NOT NULL,
  `kto_id` int(11) NOT NULL,
  `kto_nick` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `tresc` text COLLATE utf8mb4_polish_ci NOT NULL,
  `data` datetime NOT NULL,
  `sek_od_wiado` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `postacie`
--

CREATE TABLE `postacie` (
  `id` int(11) NOT NULL,
  `konto_id` int(11) NOT NULL,
  `nick` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `profesja` varchar(15) COLLATE utf8mb4_polish_ci NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `lotto_id` int(11) NOT NULL,
  `razem_exp` int(11) NOT NULL,
  `aktualny_exp` int(11) NOT NULL,
  `poziom_exp` int(11) NOT NULL,
  `ekwipunek` int(11) NOT NULL,
  `hp` decimal(10,2) NOT NULL,
  `max_hp` decimal(10,2) NOT NULL,
  `lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `postacie`
--

INSERT INTO `postacie` (`id`, `konto_id`, `nick`, `profesja`, `money`, `lotto_id`, `razem_exp`, `aktualny_exp`, `poziom_exp`, `ekwipunek`, `hp`, `max_hp`, `lvl`) VALUES
(1, 17, 'SyriuszBlack', 'Mag', '1000.00', 0, 36, 36, 120, 0, '60.00', '60.00', 1),
(2, 17, 'MariaMagdalena', 'Wojownik', '1000.00', 0, 228, 108, 252, 0, '63.60', '63.60', 2),
(3, 9, 'MagicznyKox', 'Paladyn', '1000.00', 0, 0, 0, 120, 0, '60.00', '60.00', 1),
(4, 9, 'Remus', 'Mag', '1000.00', 0, 0, 0, 120, 0, '60.00', '60.00', 1),
(5, 17, 'Hades', 'Paladyn', '1000.00', 0, 132, 12, 252, 0, '63.60', '63.60', 2),
(7, 17, 'Elizabeth Swann', 'Mag', '1000.00', 0, 16, 16, 120, 0, '60.00', '60.00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przeciwnicy`
--

CREATE TABLE `przeciwnicy` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL,
  `lvl` int(11) NOT NULL,
  `min_atak` int(11) NOT NULL,
  `max_atak` int(11) NOT NULL,
  `ck_procent` float NOT NULL,
  `punkty_zdrowia` int(11) NOT NULL,
  `bron_1` int(11) NOT NULL,
  `bron_2` int(11) NOT NULL,
  `powiedzenie` text COLLATE utf8mb4_polish_ci DEFAULT NULL,
  `trudnosc` varchar(15) COLLATE utf8mb4_polish_ci NOT NULL,
  `obraz` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `doświadczenie` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `przeciwnicy`
--

INSERT INTO `przeciwnicy` (`id`, `nazwa`, `lvl`, `min_atak`, `max_atak`, `ck_procent`, `punkty_zdrowia`, `bron_1`, `bron_2`, `powiedzenie`, `trudnosc`, `obraz`, `doświadczenie`) VALUES
(1, 'Kaczka', 1, 4, 10, 4, 54, 0, 0, 'Kwa, kwa... KWA!', 'Łatwy', '1', 8),
(2, 'Mike Tyson', 4, 46, 53, 20, 194, 0, 0, 'Help yourself...', 'Trudny', '2', 26),
(3, 'Vin Diesel', 4, 52, 61, 23, 203, 0, 0, NULL, 'Trudny', '3', 29),
(4, 'CJ', 1, 11, 17, 5, 43, 0, 0, NULL, 'Łatwy', '5', 12),
(5, 'Franklin, Michael, Trevor', 10, 87, 121, 43, 496, 0, 0, NULL, 'Niemożliwy', '6', 174),
(6, 'Trevor Philips', 2, 39, 52, 11, 146, 0, 0, NULL, 'Średni', '7', 19),
(7, 'Franklin Clinton', 3, 19, 31, 9, 240, 0, 0, NULL, 'Średni', '8', 24),
(8, 'Michael De Santa', 2, 31, 38, 11, 110, 0, 0, NULL, 'Łatwy', '9', 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typy_broni`
--

CREATE TABLE `typy_broni` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `typy_broni`
--

INSERT INTO `typy_broni` (`id`, `nazwa`) VALUES
(1, 'jednoręczna'),
(2, 'dwuręczna'),
(3, 'dystansowa');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bronie`
--
ALTER TABLE `bronie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ekwipunek`
--
ALTER TABLE `ekwipunek`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `konsumpcyjne`
--
ALTER TABLE `konsumpcyjne`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `konta_gry`
--
ALTER TABLE `konta_gry`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `neutralne`
--
ALTER TABLE `neutralne`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `overworld_chat`
--
ALTER TABLE `overworld_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `postacie`
--
ALTER TABLE `postacie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `przeciwnicy`
--
ALTER TABLE `przeciwnicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `typy_broni`
--
ALTER TABLE `typy_broni`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `bronie`
--
ALTER TABLE `bronie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `ekwipunek`
--
ALTER TABLE `ekwipunek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `konsumpcyjne`
--
ALTER TABLE `konsumpcyjne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `konta_gry`
--
ALTER TABLE `konta_gry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `neutralne`
--
ALTER TABLE `neutralne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `overworld_chat`
--
ALTER TABLE `overworld_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `postacie`
--
ALTER TABLE `postacie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `przeciwnicy`
--
ALTER TABLE `przeciwnicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `typy_broni`
--
ALTER TABLE `typy_broni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
