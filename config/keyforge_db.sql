-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 01 2025 г., 19:47
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `keyforge`
--

-- --------------------------------------------------------

--
-- Структура таблицы `game_keys`
--

CREATE TABLE `game_keys` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `status` enum('available','sold') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `stripe_payment_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price_eur` decimal(10,2) NOT NULL,
  `platform` enum('Steam','Origin','Ubisoft Connect') NOT NULL,
  `genre` enum('FPS','RPG','RTS','Simulator','Sports','Horror','Survival') NOT NULL,
  `number_of_keys` int(11) NOT NULL DEFAULT 0,
  `main_image_path` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `image_alt` varchar(255) DEFAULT NULL,
  `cpu` varchar(255) NOT NULL,
  `gpu` varchar(255) NOT NULL,
  `ram` varchar(255) NOT NULL,
  `storage` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price_eur`, `platform`, `genre`, `number_of_keys`, `main_image_path`, `image_alt`, `cpu`, `gpu`, `ram`, `storage`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Star Wars Outlaws', 'Iepazīsties ar pirmo atvērtās pasaules Star Wars™ spēli! Dodieties uz zināmām un jaunām planētām un iepazīstieties ar burvīgo piedzīvojumu meklētāju Kay Wess, kurš ilgojas pēc brīvības un iespējas sākt jaunu dzīvi.', 9.99, 'Steam', 'RPG', 0, 'assets/images/products/683c848900aba.jpeg', 'Star Wars Outlaws', 'Intel i5', 'GTX 1050', '8GB', '30GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:23:39'),
(2, 'Cyberpunk 2077', 'Cyberpunk 2077 ir atvērtās pasaules darbības-piedzīvojumu stāsts, kas notiek Night City - megalopolī, kurā valda vara, glamurs un ķermeņa modifikācijas.', 29.99, 'Steam', 'RPG', 0, 'assets/images/products/683c848f28683.jpg', 'Cyberpunk 2077', 'Intel i7', 'RTX 2060', '16GB', '70GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:23:56'),
(3, 'Battlefield 2042', 'Battlefield 2042 ir pirmās personas šāvējspēle, kas atzīmē atgriešanos pie franšīzes ikoniskā visaptverošā kara.', 29.99, 'Origin', 'FPS', 0, 'assets/images/products/683c8496728dc.jpg', 'Battlefield 2042', 'Intel i5', 'RTX 3060', '16GB', '100GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:24:06'),
(4, 'Assassin\'s Creed Valhalla', 'Kļūsti par Eivoru, leģendāru vikingu reideri, kurš meklē slavu. Izpēti Anglijas tumšos laikus, reidējot ienaidniekus, attīstot savu apmetni un veidojot politisko varu.', 49.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c849cb26f3.jpg', 'Assassin\'s Creed Valhalla', 'Intel i7', 'RTX 2070', '16GB', '125GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:24:15'),
(5, 'The Witcher 3: Wild Hunt', 'Kamēr karš plosās Ziemeļu valstīs, tu uzņemies savu lielāko līgumu - izsekot Pravietības Bērnam, dzīvam ierocim, kas var mainīt pasaules formu.', 8.99, 'Steam', 'RPG', 0, 'assets/images/products/683c84a46d07d.jpg', 'The Witcher 3', 'Intel i5', 'GTX 1060', '8GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:24:24'),
(6, 'FIFA 24', 'Piedzīvo futbola virsotni ar FIFA 24, kas ietver FIFA Pasaules kausu™ un sieviešu klubu futbolu.', 49.99, 'Origin', 'Sports', 0, 'assets/images/products/683c84ab4c8b9.jpg', 'FIFA 24', 'Intel i5', 'GTX 1660', '8GB', '100GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:24:40'),
(7, 'Far Cry 6', 'Laipni lūgti Jara, tropiskajā paradīzē, kas iesaldēts laikā. Kā Jaras diktators, Antons Kastiljo ir apņēmies atjaunot savu nāciju tās bijušajā krāšņumā ar jebkādiem līdzekļiem.', 39.99, 'Ubisoft Connect', 'FPS', 0, 'assets/images/products/683c84b6587b4.jpg', 'Far Cry 6', 'Intel i7', 'RTX 2070', '16GB', '60GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:24:50'),
(8, 'Red Dead Redemption 2', 'Amerika, 1899. Sākās mežonīgā rietumu laikmeta beigas. Pēc neveiksmīga laupīšanas rietumu pilsētā Blackwater, Artūrs Morgans un Van der Linde banda ir spiesta bēgt.', 39.99, 'Steam', 'RPG', 0, 'assets/images/products/683c84bd9fb14.jpg', 'Red Dead Redemption 2', 'Intel i7', 'RTX 2060', '16GB', '150GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:25:03'),
(9, 'Rainbow Six Siege', 'Apgūsti iznīcināšanas un ierīču mākslu Tom Clancy\'s Rainbow Six Siege. Sastopies ar intensīvu tuvcīņas kauju, augstu letalitāti, taktisku lēmumu pieņemšanu, komandas spēli un sprādzienbīstamu darbību.', 7.99, 'Ubisoft Connect', 'FPS', 0, 'assets/images/products/683c857aeee0e.jpg', 'Rainbow Six Siege', 'Intel i5', 'GTX 1050', '8GB', '61GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:25:20'),
(10, 'Elden Ring', 'JAUNĀ FANTĀZIJAS DARBĪBU RPG. Celies, Aptumšotais, un ļaujies vadīt žēlastībai, lai izmantotu Elden Ring spēku un kļūtu par Elden Lord Zemes Starpā.', 34.99, 'Steam', 'RPG', 0, 'assets/images/products/683c8582c2e56.jpg', 'Elden Ring', 'Intel i7', 'RTX 2070', '16GB', '60GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:25:35'),
(11, 'The Sims 4', 'Izveido unikālus tēlus, būvē sapņu mājas un ļauj haosam notikt. Piedzīvo radīšanas un kontroles spēku The Sims 4.', 8.99, 'Origin', 'Simulator', 0, 'assets/images/products/683c859055916.webp', 'The Sims 4', 'Intel i5', 'GTX 1050', '8GB', '25GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:25:45'),
(12, 'Watch Dogs: Legion', 'Izveido pretestību no gandrīz jebkura cilvēka, kuru redzi, kamēr hakerē, infiltrējies un cīnies, lai atgūtu gandrīz nākotnes Londonu, kas saskaras ar sabrukumu.', 19.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c859b6ac73.webp', 'Watch Dogs Legion', 'Intel i7', 'RTX 2060', '16GB', '45GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:25:58'),
(13, 'Need for Speed Heat', 'Dienā strādā un naktī riskē ar visu Need for Speed Heat, aizraujošā sacensību pieredzē, kas tevi stāda pretī nelegālajai policijai.', 9.99, 'Origin', 'Simulator', 0, 'assets/images/products/683c85af4463c.webp', 'Need for Speed Heat', 'Intel i5', 'GTX 1050', '8GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:26:08'),
(14, 'For Honor', 'Ieej kara haosā kā drosmīgs bruņinieks, brutāls vikings vai nāvējošs samurajs, trīs no lielākajiem kareivju mantojumiem. For Honor ir ātrs un ieskaujošs piedzīvojums.', 5.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c85c2590d0.jpg', 'For Honor', 'Intel i5', 'GTX 1050', '8GB', '40GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:26:17'),
(15, 'Baldur\'s Gate 3', 'Savāc savu komandu un atgriezies Aizmirstajās zemēs stāstā par draudzību un nodevību, upuri un izdzīvošanu, un absolūtās varas vilinājumu.', 59.99, 'Steam', 'RPG', 0, 'assets/images/products/683c85ce7e8bf.webp', 'Baldur\'s Gate 3', 'Intel i7', 'RTX 2060', '16GB', '150GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:26:25'),
(16, 'Star Wars Jedi: Survivor', 'Kal Kestisa stāsts turpinās Star Wars Jedi: Survivinājums, galaktiku aptverošā, trešās personas, darbības-piedzīvojumu spēlē.', 29.99, 'Origin', 'RPG', 0, 'assets/images/products/683c85d930da8.jpg', 'Star Wars Jedi Survivor', 'Intel i7', 'RTX 2070', '16GB', '155GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:26:37'),
(17, 'The Division 2', 'Cīnies, lai atjaunotu Vašingtonu, D.C. pēc nāvējoša vīrusa izplatīšanas, un pilsēta ir pārņemta ar bīstamām frakcijām.', 7.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c869d5e710.webp', 'The Division 2', 'Intel i7', 'RTX 2060', '16GB', '90GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:26:50'),
(18, 'Mass Effect', 'Mass Effect Legendary Edition ietver vienotāja režīma pamatsaturs un vairāk nekā 40 DLC no Mass Effect, Mass Effect 2 un Mass Effect 3.', 3.97, 'Origin', 'RPG', 0, 'assets/images/products/683c86a4c907f.jpg', 'Mass Effect', 'Intel i7', 'RTX 2060', '16GB', '120GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:27:00'),
(19, 'Anno 1800', 'Vadi Rūpnieciskās revolūcijas sākumu! Piedzīvo rūpnieciskā laikmeta sākumu, veidojot savu impēriju 19. gadsimtā.', 8.99, 'Ubisoft Connect', 'RTS', 0, 'assets/images/products/683c86ac3f80e.png', 'Anno 1800', 'Intel i5', 'GTX 1060', '8GB', '60GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:27:09'),
(20, 'Dishonored', 'Dishonored ir aizraujoša pirmās personas asa sižeta spēle, kurā tu spēlē pārdabisku slepkavu, kuru vada atriebība. Izmantojot Dishonored elastīgo kaujas sistēmu, radoši likvidējiet savus mērķus, kombinējot jūsu rīcībā esošās pārdabiskās spējas un ieročus.', 7.99, 'Steam', 'RPG', 0, 'assets/images/products/6822577a113e4.jpg', 'dishonored', '3.0 GHz dual core or better', 'NVIDIA GeForce GTX 460 / ATI Radeon HD 5850', '4GB', '9GB', 'active', '2025-04-09 19:25:54', '2025-06-01 17:31:04'),
(21, 'Dead Space', 'Zinātniskās fantastikas izdzīvošanas šausmu klasika atgriežas, pilnībā pārbūvēta no pamatiem ar apbrīnojamu vizuālo efektu, audio un spēles procesa uzlabojumiem.', 19.99, 'Origin', 'Horror', 0, 'assets/images/products/683c86b4e7fa8.jpg', 'Dead Space', 'Intel i7', 'RTX 2070', '16GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:16:18'),
(22, 'Immortals Fenyx Rising', 'Spēlē kā Fenyx, jaunu spārnainu pusdievu, kurš dodas uz misiju, lai izglābtu grieķu dievus un viņu mājas no tumšā lāsta.', 29.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c86bbd4dbc.jpg', 'Immortals Fenyx Rising', 'Intel i5', 'GTX 1060', '8GB', '30GB', 'active', '2025-06-01 16:42:23', '2025-06-01 16:58:35'),
(23, 'Stray', 'Pazudis, vientuļš un atdalīts no ģimenes, klaidonis kaķis ir jāatrisina senlaiku noslēpums, lai izbēgtu no sen aizmirstas kiberpilsētas un atrastu ceļu mājās.', 8.99, 'Steam', 'RPG', 0, 'assets/images/products/683c86c5ea117.webp', 'Stray', 'Intel i5', 'GTX 1050', '8GB', '10GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:27:21'),
(24, 'Dragon Age: Inquisition', 'Kad debesis atveras un lej haosu, pasaulei vajag varoņus. Kļūsti par Thedas glābēju ambiciozākajā Dragon Age spēlē jebkad.', 29.99, 'Origin', 'RPG', 0, 'assets/images/products/683c86d16cef2.jpg', 'Dragon Age Inquisition', 'Intel i5', 'GTX 1060', '8GB', '26GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:27:31'),
(25, 'Sekiro: Shadows Die Twice', 'Izgriez savu gudro ceļu uz atriebību kritiķu atzinīgajā piedzīvojumā no izstrādātājiem FromSoftware, Dark Souls sērijas veidotājiem.', 59.99, 'Steam', 'RPG', 0, 'assets/images/products/683c86da95617.jpg', 'Sekiro', 'Intel i7', 'GTX 1060', '8GB', '25GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:27:41'),
(26, 'Resident Evil 4', 'Izdzīvošana ir tikai sākums. Sešus gadus pēc bioloģiskās katastrofas Raccoon City. Leons S. Kenedijs, viens no izdzīvojušajiem, izseko prezidenta nolaupīto meitu uz noslēgtu Eiropas ciematu.', 59.99, 'Steam', 'Horror', 0, 'assets/images/products/683c878b1b444.jpg', 'Resident Evil 4', 'Intel i7', 'RTX 2060', '16GB', '60GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:28:01'),
(27, 'Titanfall 2', 'Respawn Entertainment dod tev vismodernāko titānu kauju šajā pirmās personas šāvējspēlē.', 8.99, 'Origin', 'FPS', 0, 'assets/images/products/683c87957a75c.jpg', 'Titanfall 2', 'Intel i5', 'GTX 1060', '8GB', '45GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:28:19'),
(28, 'Riders Republic', 'Ielēc milzīgajā daudzspēlētāju spēļu laukumā! Brauc ar velosipēdu, slēpo, snovbordo vai lido ar spārnu tērpu pa atvērtās pasaules sporta paradīzi.', 39.99, 'Ubisoft Connect', 'Sports', 0, 'assets/images/products/683c879de848f.jpg', 'Riders Republic', 'Intel i7', 'RTX 2060', '16GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:02:21'),
(29, 'God of War', 'Viņa atriebība pret Olimpa dieviem ir aiz muguras, Kratos tagad dzīvo kā cilvēks Ziemeļu dievu un briesmoņu pasaulē.', 9.99, 'Steam', 'RPG', 0, 'assets/images/products/683c87a69df20.jpg', 'God of War', 'Intel i7', 'RTX 2070', '16GB', '70GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:28:37'),
(30, 'Battlefield V', 'Ieej cilvēces lielākajā konfliktā ar Battlefield V, kad sērija atgriežas pie savām saknēm nekad iepriekš neredzētā Otrā pasaules kara attēlojumā.', 29.99, 'Origin', 'FPS', 0, 'assets/images/products/683c87af81064.jpg', 'Battlefield V', 'Intel i5', 'GTX 1060', '8GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:28:51'),
(31, 'The Crew 2', 'Laipni lūgti Motornation, milzīgā, daudzveidīgā, darbību pilnā un skaistā spēļu laukumā, kas veidots motosportam visā ASV!', 29.99, 'Ubisoft Connect', 'Simulator', 0, 'assets/images/products/683c87badde3c.jpg', 'The Crew 2', 'Intel i5', 'GTX 1060', '8GB', '25GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:29:11'),
(32, 'Horizon Zero Dawn', 'Piedzīvo Alojas leģendāro misiju atklāt nākotnes Zemes noslēpumus, kurā valda Mašīnas.', 49.99, 'Steam', 'RPG', 0, 'assets/images/products/683c87c6b5a45.webp', 'Horizon Zero Dawn', 'Intel i7', 'RTX 2060', '16GB', '100GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:03:02'),
(33, 'Star Wars: Squadrons', 'Apgūsti zvaigžņu kuģu pilotēšanas mākslu autentiskajā pilotēšanas pieredzē Star Wars: Squadrons.', 29.99, 'Origin', 'Simulator', 0, 'assets/images/products/683c87d1391b3.jpg', 'Star Wars Squadrons', 'Intel i5', 'GTX 1060', '8GB', '40GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:29:24'),
(34, 'Ghost Recon Breakpoint', 'Kļūsti par elitāro specvienību karavīru un cīnies par izdzīvošanu pret Vilkiem, nelegālu specvienību komandu, kas ir pārņēmusi Auroa.', 29.99, 'Ubisoft Connect', 'Survival', 0, 'assets/images/products/683c89d3f21ac.webp', 'Ghost Recon Breakpoint', 'Intel i7', 'RTX 2060', '16GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:29:47'),
(35, 'Monster Hunter: World', 'Laipni lūgti jaunā pasaulē! Uzņemies mednieka lomu un nogalini niknos briesmoņus dzīvā, elpojošā ekosistēmā.', 29.99, 'Steam', 'RPG', 0, 'assets/images/products/683c89dd9ae8e.jpg', 'Monster Hunter World', 'Intel i5', 'GTX 1060', '8GB', '48GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:30:00'),
(36, 'It Takes Two', 'Uzsāc savas dzīves trakāko ceļojumu It Takes Two, žanru pārkāpjošā platformas piedzīvojumā, kas izveidots tikai kooperatīvai spēlei.', 39.99, 'Origin', 'RPG', 0, 'assets/images/products/683c89e46e055.png', 'It Takes Two', 'Intel i5', 'GTX 1050', '8GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:30:12'),
(37, 'Death Stranding', 'No leģendārā spēļu veidotāja Hideo Kojima nāk žanru pārkāpjošs piedzīvojums, kas tagad ir paplašināts šajā galīgajā versijā.', 49.99, 'Steam', 'Survival', 0, 'assets/images/products/683c89ed410da.jpg', 'Death Stranding', 'Intel i7', 'RTX 2060', '16GB', '80GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:30:22'),
(38, 'Madden NFL 24', 'Piedzīvo reālāko NFL spēles procesu ar Madden NFL 24. Sajūti nākamo līmeni ar FieldSENSE.', 59.99, 'Origin', 'Sports', 0, 'assets/images/products/683c89f6d2234.jpeg', 'Madden NFL 24', 'Intel i5', 'GTX 1060', '8GB', '50GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:12:22'),
(39, 'Rayman Legends', 'Rayman, Globox un Teensies klīst pa burvīgo mežu, kad viņi atklāj noslēpumainu telti, kas piepildīta ar aizraujošu gleznu sēriju.', 19.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c89ffa626c.jpg', 'Rayman Legends', 'Intel i5', 'GTX 1050', '8GB', '5GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:30:31'),
(40, 'Child of Light', 'Child of Light ir moderns klasiskas pasakas interpretācija. Ar roku krāsotie mākslas darbi un animācijas atdzīvina Lemurijas pasauli.', 14.99, 'Ubisoft Connect', 'RPG', 0, 'assets/images/products/683c8a0ddacb4.jpg', 'Child of Light', 'Intel i5', 'GTX 1050', '4GB', '3GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:12:45'),
(41, 'Portal 2', '\"Mūžīgās testēšanas iniciatīva\" ir paplašināta, lai ļautu tev veidot kooperatīvas mīklas tev un tavam draugam!', 3.99, 'Steam', 'RTS', 0, 'assets/images/products/683c8a24555c4.jpg', 'Portal 2', 'Intel i5', 'GTX 1050', '8GB', '8GB', 'active', '2025-06-01 16:42:23', '2025-06-01 17:30:39');

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'admin', 'Administrator with full access', '2025-03-19 19:12:06'),
(2, 'client', 'Regular client user', '2025-03-19 19:12:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','blocked') DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `status`, `remember_token`, `last_login`, `created_at`, `updated_at`) VALUES
(3, 1, 'Admin User', 'admin@keyforge.test', '$2y$10$/ieoPfjvnWRQA3UFRNwF8.fcIi106SIsiKGvQfAOj7B58JQw1fz2K', 'active', NULL, '2025-06-01 17:44:07', '2025-03-23 22:47:04', '2025-06-01 17:44:07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `game_keys`
--
ALTER TABLE `game_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `game_keys`
--
ALTER TABLE `game_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `game_keys`
--
ALTER TABLE `game_keys`
  ADD CONSTRAINT `game_keys_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `remember_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
