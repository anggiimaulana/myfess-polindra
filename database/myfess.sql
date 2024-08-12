-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 08 Jul 2024 pada 00.00
-- Versi server: 11.3.2-MariaDB-log
-- Versi PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfess`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` int(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `unique_id`, `nama`, `nip`, `email`, `password`, `img`, `status`) VALUES
(4, 1087778569, 'Anggi Maulana S.Tr.Kom', 461939113, 'anggabos120@gmail.com', '$2y$10$erWvEw7o3qkYNUmM/0.jyuUkX55tzk6ccDK50qg.W4y.hGMe.Wzi6', '1720396829_anggi.jpg', 'Active now');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `unique_comment` int(200) NOT NULL,
  `post_unique` int(200) NOT NULL,
  `users_unique` int(255) NOT NULL,
  `isi_komen` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comment`
--

INSERT INTO `comment` (`comment_id`, `unique_comment`, `post_unique`, `users_unique`, `isi_komen`) VALUES
(16, 360264177, 513710046, 1242914750, 'waduhh bro semangat yaaa!'),
(17, 65668364, 990692962, 1242914750, 'hhhhkhkhkh'),
(18, 809498547, 674853906, 1242914750, 'gvjgjbjb'),
(19, 95942458, 771843344, 54803329, 'p'),
(20, 1223553287, 461932076, 1206894388, 'hey'),
(43, 1581267714, 478203690, 1402016952, 'hai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(101, 1242914750, 1206894388, 'p'),
(102, 1242914750, 1206894388, 'kenalan dong'),
(103, 1206894388, 1242914750, 'boleh'),
(122, 1118960962, 1009494524, 'halo pak'),
(128, 1118960962, 1009494524, 'asdasd\''),
(129, 1118960962, 1009494524, 'asd'),
(130, 1118960962, 1009494524, 'as'),
(131, 1118960962, 1009494524, 'sd'),
(132, 1118960962, 1009494524, 'asd'),
(133, 1118960962, 1009494524, 's'),
(136, 1118960962, 1193834390, 'hai gaes'),
(138, 1118960962, 1193834390, 'oke'),
(139, 1009494524, 1402016952, 'ppp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `unique_post` int(200) NOT NULL,
  `post_content` varchar(5000) NOT NULL,
  `user_post` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `post`
--

INSERT INTO `post` (`post_id`, `unique_post`, `post_content`, `user_post`) VALUES
(345, 990692962, 'knkknihinkk', 1242914750),
(346, 674853906, 'jhohoho', 1242914750),
(347, 771843344, ',sghabgf', 54803329),
(349, 461932076, 'kjagsnkagt', 1206894388),
(360, 478203690, 'hai gaes', 1193834390);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(200) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(400) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `nim`, `prodi`, `kelas`, `email`, `password`, `img`, `status`) VALUES
(49, 875656078, 'Erwan', 'Kurniawan', '2307065', 'D4 Sistem Informasi Kota Cerdas', 'D4SIKC1A', 'erwankurniawan49@gmail.com', '$2y$10$dp/EjlR6T43SfzGQxtw/C.gS/yJLYtcl3KOm0II0f1EoIsgbNRnxa', '1719904316_IMG-20240702-WA0020.jpg', 'Aktif'),
(50, 1193834390, 'rafli', 'rafli21', '2307071', 'D3 Teknik Mesin', 'D3TM1A', 'raf@gmail.com', '$2y$10$MH6i6aW0QzYPtyYeA7K8uuWv2tRB6OE8cOFjwHIjRR7EsViIOwsJu', '1720090010_Polcar.jpg', 'Aktif'),
(51, 1402016952, 'Anggi', 'Maulana', '2307059', 'D4 Sistem Informasi Kota Cerdas', 'D4SIKC1C', 'anggabos120@gmail.com', '$2y$10$T4.UF1urWTwpXij6xPqXVeHJcT9dgmRD/22CnnPFI9N67lTYZwpnC', '1720236967_anggii.jpg', 'Aktif'),
(53, 1278546607, 'Anggi', 'Maulana', '2307058', 'D4 Rekayasa Perangkat Lunak', 'D4RPL1A', 'anggabos12@gmail.com', '$2y$10$YV5Gt8t/4DDz86X0TkTxrO2TxHJSXbvuYz9Bfa9mcixYRdjvvobl2', '1720237969_bencana.jpeg', 'Offline'),
(55, 1515141152, 'vanes', 'hasan', '2307088', 'D4 Perancangan Manufaktur', 'D4PM1A', 'vanes@gmail.com', '$2y$10$Vhserl0z0n5xPysFpMJmpep9KKFXWW4GEZ2ekuzTydG3M7/3Y8TU.', '1720395568_Appetizer.jpg', 'Offline');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indeks untuk tabel `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT untuk tabel `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
