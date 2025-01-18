-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 07:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `muvi`
--

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `MovieID` int(11) NOT NULL,
  `Genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`MovieID`, `Genre`) VALUES
(1, 'Adventure'),
(1, 'Fantasy'),
(2, 'Adventure'),
(2, 'Fantasy'),
(3, 'Action'),
(3, 'Adventure'),
(4, 'Action'),
(4, 'Adventure'),
(5, 'Adventure'),
(5, 'Fantasy'),
(6, 'Adventure'),
(6, 'Fantasy'),
(7, 'Adventure'),
(7, 'Fantasy'),
(8, 'Adventure'),
(8, 'Fantasy'),
(9, 'Action'),
(9, 'Crime'),
(10, 'Action'),
(10, 'Fantasy'),
(11, 'Action'),
(11, 'Adventure'),
(12, 'Sci-Fi'),
(12, 'Thriller'),
(13, 'Action'),
(13, 'Comedy'),
(14, 'Action'),
(14, 'Adventure'),
(15, 'Adventure'),
(15, 'Fantasy'),
(16, 'Action'),
(16, 'Sci-Fi'),
(17, 'Action'),
(17, 'Adventure'),
(18, 'Action'),
(18, 'Fantasy'),
(19, 'Action'),
(19, 'Adventure'),
(20, 'Action'),
(20, 'Adventure');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movieid` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Release_date` date DEFAULT NULL,
  `Genre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movieid`, `Title`, `Description`, `Release_date`, `Genre`) VALUES
(1, 'Pirates of the Caribbean: The Curse of the Black Pearl', 'A swashbuckling adventure of a pirate and his quest to retrieve a cursed treasure.', '2003-07-09', 'Adventure'),
(2, 'Pirates of the Caribbean: Dead Man\'s Chest', 'Captain Jack Sparrow faces a new threat and seeks a way to escape his debt.', '2006-07-07', 'Adventure'),
(3, 'Star Wars: Episode IV - A New Hope', 'A young farm boy joins forces with a princess, a rogue, and a wizard to defeat an evil empire.', '1977-05-25', 'Sci-Fi'),
(4, 'Star Wars: Episode V - The Empire Strikes Back', 'The rebels face the wrath of the Empire and a deep secret is revealed.', '1980-05-21', 'Sci-Fi'),
(5, 'Harry Potter and the Sorcerer\'s Stone', 'A young boy discovers he is a wizard and begins his journey at Hogwarts School of Witchcraft and Wizardry.', '2001-11-16', 'Fantasy'),
(6, 'Harry Potter and the Chamber of Secrets', 'Harry returns to Hogwarts and uncovers dark secrets about the school.', '2002-11-15', 'Fantasy'),
(7, 'The Lord of the Rings: The Fellowship of the Ring', 'A hobbit and a group of allies embark on a quest to destroy a powerful ring.', '2001-12-19', 'Fantasy'),
(8, 'The Lord of the Rings: The Two Towers', 'The fellowship is divided, and the battle against the dark lord continues.', '2002-12-18', 'Fantasy'),
(9, 'The Dark Knight', 'Batman faces the Joker, a criminal mastermind who seeks to plunge Gotham City into chaos.', '2008-07-18', 'Action'),
(10, 'Wonder Woman', 'The story of Diana Prince, an Amazonian princess, and her journey to becoming a superhero.', '2017-06-02', 'Action'),
(11, 'Guardians of the Galaxy', 'A group of intergalactic misfits must band together to save the universe.', '2014-08-01', 'Sci-Fi'),
(12, 'Inception', 'A skilled thief is offered a chance to have his past crimes forgiven if he can implant an idea into someone\'s mind.', '2010-07-16', 'Sci-Fi'),
(13, 'Deadpool', 'A wisecracking mercenary with a dark sense of humor becomes an antihero.', '2016-02-12', 'Action'),
(14, 'Justice League', 'Batman, Wonder Woman, and other heroes team up to save the world from an impending threat.', '2017-11-17', 'Action'),
(15, 'The Hobbit: An Unexpected Journey', 'Bilbo Baggins embarks on an adventure with a group of dwarves to reclaim their homeland.', '2012-12-14', 'Fantasy'),
(16, 'The Matrix', 'A computer hacker learns about the true nature of reality and joins a rebellion against its controllers.', '1999-03-31', 'Sci-Fi'),
(17, 'Spider-Man: Homecoming', 'Peter Parker tries to balance his life as a high school student and a superhero.', '2017-07-07', 'Action'),
(18, 'Thor: Ragnarok', 'Thor must escape from a distant planet and prevent the destruction of Asgard.', '2017-11-03', 'Action'),
(19, 'Black Panther', 'The new king of Wakanda must face challenges to his rule and protect his nation.', '2018-02-16', 'Action'),
(20, 'Aquaman', 'Arthur Curry, the human-Atlantean hybrid, must reclaim his birthright and save Atlantis.', '2018-12-21', 'Action');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `RatingID` int(11) NOT NULL,
  `RatingValue` int(11) DEFAULT NULL CHECK (`RatingValue` between 1 and 10),
  `UserID` int(11) DEFAULT NULL,
  `MovieID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`RatingID`, `RatingValue`, `UserID`, `MovieID`) VALUES
(1, 5, 16, 12),
(2, 3, 18, 18),
(3, 4, 18, 3),
(4, 4, 20, 3),
(5, 4, 20, 4),
(6, 4, 21, 1),
(7, 3, 21, 4),
(8, 5, 21, 19),
(9, 5, 21, 20),
(10, 4, 22, 3),
(11, 3, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Test` text DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `MovieID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewID`, `Date`, `Test`, `UserID`, `MovieID`) VALUES
(1, '2024-09-01', 'An exhilarating start to an epic series!', 1, 1),
(2, '2024-09-02', 'A thrilling continuation with more depth.', 2, 2),
(3, '2024-09-03', 'A timeless classic that defined a genre.', 3, 3),
(4, '2024-09-04', 'A darker, more intense sequel with great character development.', 4, 4),
(5, '2024-09-05', 'A magical introduction to a beloved series.', 5, 5),
(6, '2024-09-06', 'An engaging follow-up with plenty of twists.', 6, 6),
(7, '2024-09-07', 'A grand adventure with stunning visuals.', 7, 7),
(8, '2024-09-08', 'An epic continuation that raises the stakes.', 8, 8),
(9, '2024-09-09', 'A fantastic and complex portrayal of Gotham.', 9, 9),
(10, '2024-09-10', 'A refreshing and bold superhero film.', 10, 10),
(11, '2024-09-14', 'Very good Movie', NULL, 3),
(12, '2024-09-20', 'back when thor movies used to be good', 18, 18),
(13, '2024-09-20', 'The SoundTrack is 11/10', 18, 3),
(14, '2024-09-20', 'Verry Good Movie, i luv it 🫶🏻', 20, 3),
(15, '2024-09-20', 'Very good movie I luv it', 20, 4),
(16, '2024-09-20', 'DIsney Ruined this franches :(', 21, 1),
(17, '2024-09-20', 'Too Long Didnt Watch', 21, 8),
(18, '2024-09-20', 'Good Movie, Kendrick Lamar is Fireeeee', 21, 19),
(19, '2024-09-20', 'Shouldve taken Jhonny depp instead as aquaman', 21, 20),
(20, '2024-09-20', '4gragrqegrga', 17, 1),
(21, '2024-09-22', 'very cute', 22, 1),
(22, '2024-09-22', 'Very dark', 22, 4),
(23, '2024-09-22', 'Cat Cat Cat', 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `Mail`, `Password`, `isAdmin`) VALUES
(1, 'john_doe', 'john@example.com', 'password123', 0),
(2, 'jane_smith', 'jane@example.com', 'securepassword', 0),
(3, 'admin_user', 'admin@example.com', 'adminpassword', 1),
(4, 'movie_buff', 'buff@example.com', 'movielover', 0),
(5, 'cinephile', 'cinephile@example.com', 'cinema2024', 0),
(6, 'film_critic', 'critic@example.com', 'critique2024', 0),
(7, 'star_wars_fan', 'starwarsfan@example.com', 'starwars2024', 0),
(8, 'potterhead', 'potterhead@example.com', 'potter2024', 0),
(9, 'pirates_lover', 'pirateslover@example.com', 'pirates2024', 0),
(10, 'dc_comics_fan', 'dcfan@example.com', 'dc2024', 0),
(11, 'mahee', '123@gmail.coom', '1010', 0),
(12, 'nigga', '123@email.com', '1111', 0),
(16, 'Maru Soru', 'marsor@gmail.com', '123', 0),
(17, 'mewmwe', '123@gmail.com', '123', 0),
(18, 'mew', 'mew@g.com', '123', 0),
(19, 'Ishrat Aureen', 'hapihapi@gmail.com', 'iluvmaidul', 0),
(20, 'PewPew', 'hapi@gmail.com', '123', 0),
(21, 'unhappy_mew', 'mew@gmail.com', '123', 0),
(22, 'Mahrufa', '10@suvmail.com', '123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `UserID` int(11) NOT NULL,
  `MovieID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`UserID`, `MovieID`, `Date`, `Status`) VALUES
(1, 1, '2024-09-01', 'Watched'),
(2, 2, '2024-09-02', 'Watched'),
(3, 3, '2024-09-03', 'Watched'),
(4, 4, '2024-09-04', 'Watched'),
(5, 5, '2024-09-05', 'Watched'),
(6, 6, '2024-09-06', 'Watched'),
(7, 7, '2024-09-07', 'Watched'),
(8, 8, '2024-09-08', 'Watched'),
(9, 9, '2024-09-09', 'Watched'),
(10, 10, '2024-09-10', 'Watched'),
(16, 1, '2024-09-20', 'watched'),
(16, 2, '2024-09-20', 'unwatched'),
(16, 3, '2024-09-20', 'unwatched'),
(16, 4, '2024-09-20', 'unwatched'),
(16, 5, '2024-09-20', 'unwatched'),
(16, 6, '2024-09-20', 'unwatched'),
(16, 7, '2024-09-20', 'unwatched'),
(16, 8, '2024-09-20', 'unwatched'),
(17, 17, '2024-09-21', 'unwatched'),
(17, 19, '2024-09-21', 'unwatched'),
(18, 1, '2024-09-20', 'unwatched'),
(18, 3, '2024-09-20', 'watched'),
(18, 18, '2024-09-20', 'unwatched'),
(20, 3, '2024-09-20', 'watched'),
(20, 4, '2024-09-20', 'watched'),
(20, 6, '2024-09-20', 'watched'),
(21, 1, '2024-09-20', 'unwatched'),
(21, 2, '2024-09-20', 'unwatched'),
(21, 3, '2024-09-20', 'unwatched'),
(21, 8, '2024-09-20', 'unwatched'),
(21, 17, '2024-09-20', 'unwatched'),
(21, 18, '2024-09-20', 'unwatched'),
(21, 19, '2024-09-20', 'unwatched'),
(22, 1, '2024-09-22', 'unwatched'),
(22, 2, '2024-09-22', 'unwatched'),
(22, 17, '2024-09-22', 'unwatched'),
(22, 18, '2024-09-22', 'unwatched'),
(22, 19, '2024-09-22', 'unwatched');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`MovieID`,`Genre`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movieid`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `Mail` (`Mail`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`UserID`,`MovieID`),
  ADD KEY `MovieID` (`MovieID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `genre`
--
ALTER TABLE `genre`
  ADD CONSTRAINT `genre_ibfk_1` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`movieid`) ON DELETE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userid`) ON DELETE SET NULL,
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`movieid`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userid`) ON DELETE SET NULL,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`movieid`) ON DELETE CASCADE;

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`MovieID`) REFERENCES `movie` (`movieid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
