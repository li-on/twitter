--
-- Struktura tabeli dla tabeli `twitter_status`
--

CREATE TABLE `twitter_status` (
  `id` int(11) NOT NULL,
  `status` char(2) DEFAULT NULL,
  `komunikat` text,
  `czas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `twitter_tweet`
--

CREATE TABLE `twitter_tweet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `twitter_user`
--

CREATE TABLE `twitter_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `screen_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura widoku `twitter_tweet_c_v`
--

CREATE VIEW `twitter_tweet_c_v`  AS  (select `twitter_tweet`.`user_id` AS `user_id`,count(1) AS `ilosc` from `twitter_tweet` group by `twitter_tweet`.`user_id`) ;

--
-- Indeksy dla tabel
--

--
-- Indexes for table `twitter_status`
--
ALTER TABLE `twitter_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ostatni` (`czas`);

--
-- Indexes for table `twitter_tweet`
--
ALTER TABLE `twitter_tweet`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `twitter_user`
--
ALTER TABLE `twitter_user`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT dla tabeli `twitter_status`
--
ALTER TABLE `twitter_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;