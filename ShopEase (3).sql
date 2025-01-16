-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 16, 2025 at 06:53 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `productID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `customerID`, `productID`, `productName`, `quantity`, `created_at`, `updated_at`) VALUES
(79, 13, 54, 'Charcoal Grey Fabric Sofa with Two Accent Pillows', 1, '2025-01-16 22:53:01', '2025-01-16 22:53:01');

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
(9, 'Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryCode` char(2) NOT NULL,
  `countryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryCode`, `countryName`) VALUES
('CA', 'Canada'),
('US', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstName` varchar(60) NOT NULL,
  `address` varchar(50) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(2) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `countryCode` char(2) NOT NULL,
  `cartID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `emailAddress`, `password`, `firstName`, `address`, `lastName`, `city`, `state`, `postalCode`, `phone`, `countryCode`, `cartID`) VALUES
(7, 'tonystark@starkindustries.com', 'ironman', 'Tony', '888 Avenger Lane', 'Stark', 'Malibu', 'CA', '90265', '286-123-4567', 'US', NULL),
(8, 'steverogers@avengers.com', 'cap', 'Steve', '6969 West Fifth Ave.', 'Rogers', 'Brooklyn', 'NY', '11222', '555-987-6543', 'US', NULL),
(9, 'bruce.banner@science.com', 'HulkSmash!789', 'Bruce', '169 Hulk Dr', 'Banner', 'New York', 'NY', '10012', '555-876-5432', 'CA', NULL),
(10, 'natasha.romanoff@shield.com', 'BlackWidow007', 'Natasha', '2312 Stark Lane', 'Romanoff', 'Washington', 'DC', '20500', '555-654-3210', 'US', NULL),
(11, 'peter.parker@dailybugle.com', 'Spidey4Life', 'Peter', '165 Spider Way', 'Parker', 'Queens', 'NY', '11375', '555-432-1098', 'CA', NULL),
(12, 'carol.danvers@airforce.com', 'marvel', 'Carol', '', 'Danvers', 'Los Angeles', 'CA', '90001', '555-567-8901', 'CA', NULL),
(13, 'justindema76@gmail.com', 'justin', 'Justin', '769 Galileo Dr', 'DeMatteis', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'CA', NULL),
(15, 'alexdema76@gmail.com', 'alex', 'Alex', '169 Galileo Dr', 'DeMatteis', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'CA', NULL),
(18, 'chloe@gmail.com', 'chloe', 'chloe', '169 Galileo Dr', 'DeMatteis', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'CA', NULL),
(22, 'prada@gmail.com', 'prada', 'prada', '169 Galileo Dr', 'DeMatteis', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'CA', NULL),
(23, 'gucci@gmail.com', 'gucci', 'gucci', '169 Galileo Dr', 'DeMatteis', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'US', NULL),
(31, 'ned@winter.com', '$2y$10$zjCp/N4Yg2g2SFdTTYg/zeGOfc/RViucBAcoJEorPvKu8Kq3F6Y3K', 'Ned', '169 Galileo Dr', 'Stark', 'Stoney Creek', 'ON', 'L8E0B6', '2896846773', 'CA', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `orderDate` datetime DEFAULT current_timestamp(),
  `totalAmount` decimal(10,2) NOT NULL,
  `orderStatus` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `customerID`, `orderDate`, `totalAmount`, `orderStatus`) VALUES
(1, 13, '2025-01-01 21:11:58', 599.50, 'Pending'),
(2, 13, '2025-01-01 21:14:16', 1999.99, 'Pending'),
(3, 13, '2025-01-01 21:17:12', 599.50, 'Pending'),
(4, 13, '2025-01-01 21:17:51', 399.99, 'Pending'),
(5, 13, '2025-01-01 21:18:56', 499.99, 'Pending'),
(6, 13, '2025-01-01 21:19:49', 1499.99, 'Pending'),
(7, 13, '2025-01-01 21:22:36', 299.99, 'Pending'),
(8, 13, '2025-01-02 07:47:48', 2399.98, 'Pending'),
(9, 31, '2025-01-10 07:58:22', 1499.99, 'Pending'),
(10, 13, '2025-01-10 10:25:45', 5995.99, 'Pending'),
(11, 13, '2025-01-10 10:28:38', 1999.99, 'Pending'),
(12, 13, '2025-01-10 10:31:20', 1899.99, 'Pending'),
(13, 13, '2025-01-10 10:47:33', 1899.99, 'Pending'),
(14, 13, '2025-01-10 11:09:09', 599.50, 'Pending'),
(15, 13, '2025-01-10 11:11:31', 599.50, 'Pending'),
(16, 12, '2025-01-16 18:30:08', 3799.98, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderItemID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderItemID`, `orderID`, `productID`, `quantity`, `price`) VALUES
(1, 1, 51, 1, 599.50),
(2, 2, 27, 1, 1999.99),
(3, 3, 51, 1, 599.50),
(4, 4, 40, 1, 399.99),
(5, 5, 38, 1, 499.99),
(6, 6, 28, 1, 1499.99),
(7, 7, 39, 1, 299.99),
(8, 8, 27, 1, 1999.99),
(9, 8, 40, 1, 399.99),
(10, 9, 28, 1, 1499.99),
(11, 10, 50, 1, 1200.00),
(12, 10, 27, 1, 1999.99),
(13, 10, 53, 2, 1398.00),
(14, 11, 27, 1, 1999.99),
(15, 12, 52, 1, 1899.99),
(16, 13, 52, 1, 1899.99),
(17, 14, 51, 1, 599.50),
(18, 15, 51, 1, 599.50),
(19, 16, 52, 2, 1899.99);

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
(27, 2, 'C001', 'Gaming Laptop', 'High-performance gaming laptop with RTX 3080.', 1999.99, 5.0, '9', 'laptop.jpg'),
(28, 2, 'C002', 'Desktop PC', 'Powerful desktop with Intel i9 processor.', 1499.99, 10.0, '14', 'pc-desktop.webp'),
(29, 2, 'C003', 'Tablet', '10-inch tablet with 128GB storage.', 399.99, 8.0, '100', 'tablet.jpeg'),
(38, 4, 'G002', 'Xbox Series X', '4K gaming console with 1TB SSD.', 499.99, 0.0, '60', 'xbox.webp'),
(39, 4, 'G003', 'Nintendo Switch', 'Hybrid gaming console with detachable Joy-Con.', 299.99, 5.0, '99', 'nintendo-switch.jpg'),
(40, 4, 'G004', 'VR Headset', 'The PlayStation VR2 offers 4K HDR virtual reality visuals for a detailed and realistic 110-degree field-of-view, with fast and high-end graphic rendering capabilities for a truly immersive experience. Setup is as easy as plugging one cable into the PlayStation 5 console. With eye-tracking, 3D audio, and intuitive controls, you will be immersed in the ultimate gaming experience.', 399.99, 10.0, '50', 'vr-headset.jpeg'),
(50, 3, 'TV02', '4K ULTRA HD LG SmartTV', 'Great tv', 1200.00, 20.0, '30', 'tv.webp'),
(51, 4, 'GA1001', 'Play Station 5', 'Next-gen gaming console with 825GB SSD.', 599.50, 35.0, '16', 'Gaming-Consoles1.jpg'),
(52, 1, 'A001', 'Insignia 18 Cu. Ft. Top Freezer Refrigerator', 'Transform your kitchen into a sleek and stylish one with this bundle from Insignia. It includes the Insignia  18 cu. ft. top freezer refrigerator,5.0 cu. ft. freestanding electric range, and built-in dishwasher with stainless steel tub. Plus, you get the Meyer Nouvelle ten-piece cookware set.', 1899.99, 25.0, '10', 'kitchen.jpg'),
(53, 1, 'APPL105', 'wash/dryer', 'State of art washer and dryer.', 1398.00, 10.0, '7', 'Front-load_washing_machine.png'),
(54, 9, 'FRN101', 'Charcoal Grey Fabric Sofa with Two Accent Pillows', 'This Sawyer sofa is ready to bring a contemporary flair to any room in your home. Linen-look fabric cloaks this couch in a dark grey hue – perfect for pairing with other decor choices to create a space all your own. Track armrests and fabric piping underscore the furniture&#39;s clean lines, while tapered plastic feet offer support without clashing against the upholstery. Inside the cushions, high-density foam is wrapped with fibre to keep your lounging comfortable. Make this Sawyer sofa the place for the whole family to relax.', 659.95, 20.0, '5', 'couch.webp');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `shipmentID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `shippingDate` datetime DEFAULT current_timestamp(),
  `trackingNumber` varchar(255) DEFAULT NULL,
  `carrier` varchar(100) DEFAULT NULL,
  `status` enum('shipped','in_transit','delivered') DEFAULT 'shipped'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryCode`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `emailAddress` (`emailAddress`),
  ADD KEY `cartID` (`cartID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `productCode` (`productCode`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`shipmentID`),
  ADD KEY `orderID` (`orderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `shipmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
