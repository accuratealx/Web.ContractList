SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS `contract` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `contract`;

CREATE TABLE `history` (
  `ID` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `SignDate` datetime NOT NULL,
  `PreparationDate` datetime NOT NULL,
  `ContractAmount` int NOT NULL,
  `Commentary` varchar(255) NOT NULL,
  `ActSignDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Список активных контрактов';

CREATE TABLE `work` (
  `ID` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `SignDate` datetime NOT NULL,
  `PreparationDate` datetime NOT NULL,
  `ContractAmount` int NOT NULL,
  `Commentary` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Список активных контрактов';

ALTER TABLE `history`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `work`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `history`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `work`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
