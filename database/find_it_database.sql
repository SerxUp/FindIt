-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2023 a las 13:11:01
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `find_it`
--
CREATE DATABASE IF NOT EXISTS `find_it` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `find_it`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_comments`
--

CREATE TABLE `fi_comments` (
  `comment_id` int(8) NOT NULL,
  `topic_id` int(8) NOT NULL,
  `user_id` int(5) NOT NULL,
  `date_created` int(11) NOT NULL,
  `content` varchar(250) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_comments_reports`
--

CREATE TABLE `fi_comments_reports` (
  `report_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `comment_id` int(8) NOT NULL,
  `solved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_countries`
--

CREATE TABLE `fi_countries` (
  `country_id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `accronym` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fi_countries`
--

INSERT INTO `fi_countries` (`country_id`, `name`, `accronym`) VALUES
(35, 'Afghanistan', NULL),
(36, 'Albania', NULL),
(37, 'Algeria', NULL),
(38, 'American Samoa', NULL),
(39, 'Andorra', NULL),
(40, 'Angola', NULL),
(41, 'Anguilla', NULL),
(42, 'Antarctica', NULL),
(43, 'Antigua and Barbuda', NULL),
(44, 'Argentina', NULL),
(45, 'Armenia', NULL),
(46, 'Aruba', NULL),
(47, 'Australia', NULL),
(48, 'Austria', NULL),
(49, 'Azerbaijan', NULL),
(50, 'Bahamas', NULL),
(51, 'Bahrain', NULL),
(52, 'Bangladesh', NULL),
(53, 'Barbados', NULL),
(54, 'Belarus', NULL),
(55, 'Belgium', NULL),
(56, 'Belize', NULL),
(57, 'Benin', NULL),
(58, 'Bermuda', NULL),
(59, 'Bhutan', NULL),
(60, 'Bolivia', NULL),
(61, 'Bosnia and Herzegowina', NULL),
(62, 'Botswana', NULL),
(63, 'Bouvet Island', NULL),
(64, 'Brazil', NULL),
(65, 'British Indian Ocean Territory', NULL),
(66, 'Brunei Darussalam', NULL),
(67, 'Bulgaria', NULL),
(68, 'Burkina Faso', NULL),
(69, 'Burundi', NULL),
(70, 'Cambodia', NULL),
(71, 'Cameroon', NULL),
(72, 'Canada', NULL),
(73, 'Cape Verde', NULL),
(74, 'Cayman Islands', NULL),
(75, 'Central African Republic', NULL),
(76, 'Chad', NULL),
(77, 'Chile', NULL),
(78, 'China', NULL),
(79, 'Christmas Island', NULL),
(80, 'Cocos (Keeling) Islands', NULL),
(81, 'Colombia', NULL),
(82, 'Comoros', NULL),
(83, 'Congo', NULL),
(84, 'Congo, the Democratic Republic of the', NULL),
(85, 'Cook Islands', NULL),
(86, 'Costa Rica', NULL),
(87, 'Cote d\'Ivoire', NULL),
(88, 'Croatia (Hrvatska)', NULL),
(89, 'Cuba', NULL),
(90, 'Cyprus', NULL),
(91, 'Czech Republic', NULL),
(92, 'Denmark', NULL),
(93, 'Djibouti', NULL),
(94, 'Dominica', NULL),
(95, 'Dominican Republic', NULL),
(96, 'East Timor', NULL),
(97, 'Ecuador', NULL),
(98, 'Egypt', NULL),
(99, 'El Salvador', NULL),
(100, 'Equatorial Guinea', NULL),
(101, 'Eritrea', NULL),
(102, 'Estonia', NULL),
(103, 'Ethiopia', NULL),
(104, 'Falkland Islands (Malvinas)', NULL),
(105, 'Faroe Islands', NULL),
(106, 'Fiji', NULL),
(107, 'Finland', NULL),
(108, 'France', NULL),
(109, 'France Metropolitan', NULL),
(110, 'French Guiana', NULL),
(111, 'French Polynesia', NULL),
(112, 'French Southern Territories', NULL),
(113, 'Gabon', NULL),
(114, 'Gambia', NULL),
(115, 'Georgia', NULL),
(116, 'Germany', NULL),
(117, 'Ghana', NULL),
(118, 'Gibraltar', NULL),
(119, 'Greece', NULL),
(120, 'Greenland', NULL),
(121, 'Grenada', NULL),
(122, 'Guadeloupe', NULL),
(123, 'Guam', NULL),
(124, 'Guatemala', NULL),
(125, 'Guinea', NULL),
(126, 'Guinea-Bissau', NULL),
(127, 'Guyana', NULL),
(128, 'Haiti', NULL),
(129, 'Heard and Mc Donald Islands', NULL),
(130, 'Holy See (Vatican City State)', NULL),
(131, 'Honduras', NULL),
(132, 'Hong Kong', NULL),
(133, 'Hungary', NULL),
(134, 'Iceland', NULL),
(135, 'India', NULL),
(136, 'Indonesia', NULL),
(137, 'Iran (Islamic Republic of)', NULL),
(138, 'Iraq', NULL),
(139, 'Ireland', NULL),
(140, 'Israel', NULL),
(141, 'Italy', NULL),
(142, 'Jamaica', NULL),
(143, 'Japan', NULL),
(144, 'Jordan', NULL),
(145, 'Kazakhstan', NULL),
(146, 'Kenya', NULL),
(147, 'Kiribati', NULL),
(148, 'Korea, Democratic People\'s Republic of', NULL),
(149, 'Korea, Republic of', NULL),
(150, 'Kuwait', NULL),
(151, 'Kyrgyzstan', NULL),
(152, 'Lao, People\'s Democratic Republic', NULL),
(153, 'Latvia', NULL),
(154, 'Lebanon', NULL),
(155, 'Lesotho', NULL),
(156, 'Liberia', NULL),
(157, 'Libyan Arab Jamahiriya', NULL),
(158, 'Liechtenstein', NULL),
(159, 'Lithuania', NULL),
(160, 'Luxembourg', NULL),
(161, 'Macau', NULL),
(162, 'Macedonia, The Former Yugoslav Republic of', NULL),
(163, 'Madagascar', NULL),
(164, 'Malawi', NULL),
(165, 'Malaysia', NULL),
(166, 'Maldives', NULL),
(167, 'Mali', NULL),
(168, 'Malta', NULL),
(169, 'Marshall Islands', NULL),
(170, 'Martinique', NULL),
(171, 'Mauritania', NULL),
(172, 'Mauritius', NULL),
(173, 'Mayotte', NULL),
(174, 'Mexico', NULL),
(175, 'Micronesia, Federated States of', NULL),
(176, 'Moldova, Republic of', NULL),
(177, 'Monaco', NULL),
(178, 'Mongolia', NULL),
(179, 'Montserrat', NULL),
(180, 'Morocco', NULL),
(181, 'Mozambique', NULL),
(182, 'Myanmar', NULL),
(183, 'Namibia', NULL),
(184, 'Nauru', NULL),
(185, 'Nepal', NULL),
(186, 'Netherlands', NULL),
(187, 'Netherlands Antilles', NULL),
(188, 'New Caledonia', NULL),
(189, 'New Zealand', NULL),
(190, 'Nicaragua', NULL),
(191, 'Niger', NULL),
(192, 'Nigeria', NULL),
(193, 'Niue', NULL),
(194, 'Norfolk Island', NULL),
(195, 'Northern Mariana Islands', NULL),
(196, 'Norway', NULL),
(197, 'Oman', NULL),
(198, 'Pakistan', NULL),
(199, 'Palau', NULL),
(200, 'Panama', NULL),
(201, 'Papua New Guinea', NULL),
(202, 'Paraguay', NULL),
(203, 'Peru', NULL),
(204, 'Philippines', NULL),
(205, 'Pitcairn', NULL),
(206, 'Poland', NULL),
(207, 'Portugal', NULL),
(208, 'Puerto Rico', NULL),
(209, 'Qatar', NULL),
(210, 'Reunion', NULL),
(211, 'Romania', NULL),
(212, 'Russian Federation', NULL),
(213, 'Rwanda', NULL),
(214, 'Saint Kitts and Nevis', NULL),
(215, 'Saint Lucia', NULL),
(216, 'Saint Vincent and the Grenadines', NULL),
(217, 'Samoa', NULL),
(218, 'San Marino', NULL),
(219, 'Sao Tome and Principe', NULL),
(220, 'Saudi Arabia', NULL),
(221, 'Senegal', NULL),
(222, 'Seychelles', NULL),
(223, 'Sierra Leone', NULL),
(224, 'Singapore', NULL),
(225, 'Slovakia (Slovak Republic)', NULL),
(226, 'Slovenia', NULL),
(227, 'Solomon Islands', NULL),
(228, 'Somalia', NULL),
(229, 'South Africa', NULL),
(230, 'South Georgia and the South Sandwich Islands', NULL),
(231, 'Spain', NULL),
(232, 'Sri Lanka', NULL),
(233, 'St. Helena', NULL),
(234, 'St. Pierre and Miquelon', NULL),
(235, 'Sudan', NULL),
(236, 'Suriname', NULL),
(237, 'Svalbard and Jan Mayen Islands', NULL),
(238, 'Swaziland', NULL),
(239, 'Sweden', NULL),
(240, 'Switzerland', NULL),
(241, 'Syrian Arab Republic', NULL),
(242, 'Taiwan, Province of China', NULL),
(243, 'Tajikistan', NULL),
(244, 'Tanzania, United Republic of', NULL),
(245, 'Thailand', NULL),
(246, 'Togo', NULL),
(247, 'Tokelau', NULL),
(248, 'Tonga', NULL),
(249, 'Trinidad and Tobago', NULL),
(250, 'Tunisia', NULL),
(251, 'Turkey', NULL),
(252, 'Turkmenistan', NULL),
(253, 'Turks and Caicos Islands', NULL),
(254, 'Tuvalu', NULL),
(255, 'Uganda', NULL),
(256, 'Ukraine', NULL),
(257, 'United Arab Emirates', NULL),
(258, 'United Kingdom', NULL),
(259, 'United States', NULL),
(260, 'United States Minor Outlying Islands', NULL),
(261, 'Uruguay', NULL),
(262, 'Uzbekistan', NULL),
(263, 'Vanuatu', NULL),
(264, 'Venezuela', NULL),
(265, 'Vietnam', NULL),
(266, 'Virgin Islands (British)', NULL),
(267, 'Virgin Islands (U.S.)', NULL),
(268, 'Wallis and Futuna Islands', NULL),
(269, 'Western Sahara', NULL),
(270, 'Yemen', NULL),
(271, 'Yugoslavia', NULL),
(272, 'Zambia', NULL),
(273, 'Zimbabwe', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_countries_provinces`
--

CREATE TABLE `fi_countries_provinces` (
  `province_id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(3) NOT NULL DEFAULT 231
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fi_countries_provinces`
--

INSERT INTO `fi_countries_provinces` (`province_id`, `name`, `country_id`) VALUES
(83, 'Alava', 231),
(84, 'Albacete', 231),
(85, 'Alicante', 231),
(86, 'Almería', 231),
(87, 'Asturias', 231),
(88, 'Avila', 231),
(89, 'Badajoz', 231),
(90, 'Barcelona', 231),
(91, 'Burgos', 231),
(92, 'Cáceres', 231),
(93, 'Guipúzcoa', 231),
(94, 'Huelva', 231),
(95, 'Huesca', 231),
(96, 'Islas Baleares', 231),
(97, 'Jaén', 231),
(98, 'León', 231),
(99, 'Lérida', 231),
(100, 'Lugo', 231),
(101, 'Madrid', 231),
(102, 'Málaga', 231),
(103, 'Murcia', 231),
(104, 'Navarra', 231),
(105, 'Orense', 231),
(106, 'Palencia', 231),
(107, 'Las Palmas', 231),
(108, 'Pontevedra', 231),
(109, 'La Rioja', 231),
(110, 'Salamanca', 231),
(111, 'Segovia', 231),
(112, 'Sevilla', 231),
(113, 'Soria', 231),
(114, 'Tarragona', 231),
(115, 'Santa Cruz de Tenerife', 231),
(116, 'Teruel', 231),
(117, 'Toledo', 231),
(118, 'Valencia', 231),
(119, 'Valladolid', 231),
(120, 'Vizcaya', 231),
(121, 'Zamora', 231),
(122, 'Zaragoza', 231);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_tags`
--

CREATE TABLE `fi_tags` (
  `tag_id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon_name` varchar(50) DEFAULT 'bi bi-star-fill'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_tokens`
--

CREATE TABLE `fi_tokens` (
  `token_id` int(8) NOT NULL,
  `token_value` varchar(32) NOT NULL,
  `user_id` int(5) NOT NULL,
  `date_expired` int(11) NOT NULL,
  `verification` varchar(50) NOT NULL DEFAULT 'account',
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_topics`
--

CREATE TABLE `fi_topics` (
  `topic_id` int(8) NOT NULL,
  `user_id` int(5) NOT NULL,
  `tag_id` int(5) DEFAULT NULL,
  `topic_title` varchar(100) NOT NULL,
  `topic_content` varchar(500) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT current_timestamp(),
  `date_edited` int(11) DEFAULT NULL,
  `accent_color` varchar(8) NOT NULL DEFAULT '#000000',
  `visibility` int(1) NOT NULL DEFAULT 2,
  `disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_topics_likes`
--

CREATE TABLE `fi_topics_likes` (
  `topic_id` int(8) NOT NULL,
  `user_id` int(5) NOT NULL,
  `modifier` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_topics_saved`
--

CREATE TABLE `fi_topics_saved` (
  `topic_id` int(8) NOT NULL,
  `user_id` int(5) NOT NULL,
  `date_saved` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fi_users`
--

CREATE TABLE `fi_users` (
  `user_id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_access_time` int(11) DEFAULT current_timestamp(),
  `last_access_ip` varchar(50) DEFAULT NULL,
  `last_device_info` varchar(150) DEFAULT NULL,
  `login_failed_attempts` int(1) NOT NULL DEFAULT 0,
  `user_level` int(1) NOT NULL DEFAULT 1,
  `description` varchar(250) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `country_id` int(11) DEFAULT 34,
  `province_id` int(11) DEFAULT 1,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `picture_path` varchar(100) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `disabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Estructura de tabla para la tabla `fi_users_friends`
--

CREATE TABLE `fi_users_friends` (
  `user_id` int(5) NOT NULL,
  `friend_id` int(5) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT 0,
  `blocked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fi_comments`
--
ALTER TABLE `fi_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `fi_comments_reports`
--
ALTER TABLE `fi_comments_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `fi_countries`
--
ALTER TABLE `fi_countries`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `accronym` (`accronym`);

--
-- Indices de la tabla `fi_countries_provinces`
--
ALTER TABLE `fi_countries_provinces`
  ADD PRIMARY KEY (`province_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `country_id` (`country_id`);

--
-- Indices de la tabla `fi_tags`
--
ALTER TABLE `fi_tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indices de la tabla `fi_tokens`
--
ALTER TABLE `fi_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `fi_topics`
--
ALTER TABLE `fi_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indices de la tabla `fi_topics_likes`
--
ALTER TABLE `fi_topics_likes`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indices de la tabla `fi_topics_saved`
--
ALTER TABLE `fi_topics_saved`
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `fi_users`
--
ALTER TABLE `fi_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_email_unique` (`username`,`email`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indices de la tabla `fi_users_friends`
--
ALTER TABLE `fi_users_friends`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fi_comments`
--
ALTER TABLE `fi_comments`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fi_comments_reports`
--
ALTER TABLE `fi_comments_reports`
  MODIFY `report_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fi_countries`
--
ALTER TABLE `fi_countries`
  MODIFY `country_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT de la tabla `fi_countries_provinces`
--
ALTER TABLE `fi_countries_provinces`
  MODIFY `province_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `fi_tags`
--
ALTER TABLE `fi_tags`
  MODIFY `tag_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fi_tokens`
--
ALTER TABLE `fi_tokens`
  MODIFY `token_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `fi_topics`
--
ALTER TABLE `fi_topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `fi_users`
--
ALTER TABLE `fi_users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fi_comments`
--
ALTER TABLE `fi_comments`
  ADD CONSTRAINT `comments_topic_id_fk` FOREIGN KEY (`topic_id`) REFERENCES `fi_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_comments_reports`
--
ALTER TABLE `fi_comments_reports`
  ADD CONSTRAINT `reports_comment_id_fk` FOREIGN KEY (`comment_id`) REFERENCES `fi_comments` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_countries_provinces`
--
ALTER TABLE `fi_countries_provinces`
  ADD CONSTRAINT `provinces_country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `fi_countries` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_tokens`
--
ALTER TABLE `fi_tokens`
  ADD CONSTRAINT `tokens_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_topics`
--
ALTER TABLE `fi_topics`
  ADD CONSTRAINT `topics_tag_id_fk` FOREIGN KEY (`tag_id`) REFERENCES `fi_tags` (`tag_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_topics_likes`
--
ALTER TABLE `fi_topics_likes`
  ADD CONSTRAINT `likes_topic_id_fk` FOREIGN KEY (`topic_id`) REFERENCES `fi_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_topics_saved`
--
ALTER TABLE `fi_topics_saved`
  ADD CONSTRAINT `saved_topic_id_fk` FOREIGN KEY (`topic_id`) REFERENCES `fi_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saved_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fi_users_friends`
--
ALTER TABLE `fi_users_friends`
  ADD CONSTRAINT `friends_friend_id_fk` FOREIGN KEY (`friend_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `fi_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
