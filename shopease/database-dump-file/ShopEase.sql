-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 28, 2024 at 08:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ShopEase`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `adminID` int(11) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES
(1, 'Appliances'),
(2, 'Computers & Tablets'),
(3, 'TVs & Home Theater'),
(4, 'Gaming Consoles & Accessories'),
(7, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryName`) VALUES
('Australia'),
('Brazil'),
('Canada'),
('China'),
('Germany'),
('France'),
('United Kingdom'),
('India'),
('Japan'),
('United States');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `line1` varchar(60) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(2) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `emailAddress`, `password`, `firstName`, `lastName`, `line1`, `city`, `province`, `postalCode`, `phone`) VALUES
(7, 'tony.stark@starkindustries.com', 'IronMan123!', 'Tony', 'Stark', '10880 Malibu Point', 'Malibu', 'CA', '90265', '555-123-4567'),
(8, 'steve.rogers@avengers.com', 'Cap4America!', 'Steve', 'Rogers', '569 Leaman Place', 'Brooklyn', 'NY', '11222', '555-987-6543'),
(9, 'bruce.banner@science.com', 'HulkSmash!789', 'Bruce', 'Banner', '177A Bleecker St', 'New York', 'NY', '10012', '555-876-5432'),
(10, 'natasha.romanoff@shield.com', 'BlackWidow007', 'Natasha', 'Romanoff', '1400 Defense St', 'Washington', 'DC', '20500', '555-654-3210'),
(11, 'peter.parker@dailybugle.com', 'Spidey4Life', 'Peter', 'Parker', '20 Ingram St', 'Queens', 'NY', '11375', '555-432-1098'),
(12, 'carol.danvers@airforce.com', 'CaptainMarvel!', 'Carol', 'Danvers', 'Cree Base Alpha', 'Los Angeles', 'CA', '90001', '555-567-8901');

-- --------------------------------------------------------

--
-- Table structure for table `orderItems`
--

CREATE TABLE `orderItems` (
  `itemID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `itemPrice` decimal(10,2) NOT NULL,
  `discountAmount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `orderDate` datetime NOT NULL,
  `shipAmount` decimal(10,2) NOT NULL,
  `taxAmount` decimal(10,2) NOT NULL,
  `shipDate` datetime DEFAULT NULL,
  `shipAddressID` int(11) NOT NULL,
  `cardType` char(1) NOT NULL,
  `cardNumber` char(16) NOT NULL,
  `cardExpires` char(7) NOT NULL,
  `billingAddressID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `listPrice` decimal(10,2) NOT NULL,
  `discountPercent` decimal(10,1) NOT NULL DEFAULT 0.0,
  `stock` varchar(10) DEFAULT NULL,
  `imageName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `categoryID`, `productCode`, `productName`, `description`, `listPrice`, `discountPercent`, `stock`, `imageName`) VALUES
(25, 1, 'A004', 'Dishwasher', 'Quiet dishwasher with stainless steel tub.', 599.99, 8.0, '30', 'dishwasher.jpeg'),
(27, 2, 'C001', 'Gaming Laptop', 'High-performance gaming laptop with RTX 3080.', 1999.99, 5.0, '10', 'laptop.jpg'),
(28, 2, 'C002', 'Desktop PC', 'Powerful desktop with Intel i9 processor.', 1499.99, 10.0, '15', 'pc-desktop.webp'),
(29, 2, 'C003', 'Tablet', '10-inch tablet with 128GB storage.', 399.99, 8.0, '100', 'tablet.jpeg'),
(38, 4, 'G002', 'Xbox Series X', '4K gaming console with 1TB SSD.', 499.99, 0.0, '60', 'xbox.webp'),
(39, 4, 'G003', 'Nintendo Switch', 'Hybrid gaming console with detachable Joy-Con.', 299.99, 5.0, '100', 'nintendo-switch.jpg'),
(40, 4, 'G004', 'VR Headset', 'The PlayStation VR2 offers 4K HDR virtual reality visuals for a detailed and realistic 110-degree field-of-view, with fast and high-end graphic rendering capabilities for a truly immersive experience. Setup is as easy as plugging one cable into the PlayStation 5 console. With eye-tracking, 3D audio, and intuitive controls, you will be immersed in the ultimate gaming experience.', 399.99, 10.0, '50', 'vr-headset.jpeg'),
(50, 3, 'TV02', '4K ULTRA HD LG SmartTV', 'Great tv', 1200.00, 20.0, '30', 'tv.webp'),
(51, 4, 'GA1001', 'Play Station 5', 'Next-gen gaming console with 825GB SSD.', 599.50, 35.0, '20', 'Gaming-Consoles1.jpg'),
(52, 1, 'A001', 'Insignia 18 Cu. Ft. Top Freezer Refrigerator; Electric Range; Dishwasher; Cookware Set - Stainless', 'Transform your kitchen into a sleek and stylish one with this bundle from Insignia. It includes the Insignia  18 cu. ft. top freezer refrigerator,5.0 cu. ft. freestanding electric range, and built-in dishwasher with stainless steel tub. Plus, you get the Meyer Nouvelle ten-piece cookware set.', 1899.99, 25.0, '5', 'kitchen.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`);

--
-- Indexes for table `orderItems`
--
ALTER TABLE `orderItems`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `productCode` (`productCode`),
  ADD KEY `categoryID` (`categoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orderItems`
--
ALTER TABLE `orderItems`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
