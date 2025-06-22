-- Create the database
CREATE DATABASE IF NOT EXISTS `prime-ride` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `prime-ride`;

-- Drop tables if they exist to avoid conflicts
DROP TABLE IF EXISTS rental, offer_orders, offers, messages, gallery, staff, vehicles, clients;

-- Clients
CREATE TABLE `clients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL DEFAULT NULL,
  `profile_picture` VARCHAR(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Vehicles
CREATE TABLE `vehicles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `vehicle_name` VARCHAR(100) NOT NULL,
  `model` VARCHAR(50) NOT NULL,
  `seats` INT(11) NOT NULL,
  `fuel_type` VARCHAR(50) NOT NULL,
  `transmission` VARCHAR(50) NOT NULL,
  `license_plate` VARCHAR(20) NOT NULL UNIQUE,
  `price_perday` DECIMAL(10,2) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Gallery
CREATE TABLE `gallery` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Messages
CREATE TABLE `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `subject` VARCHAR(255) NOT NULL,
  `rental_type` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `mobile_number` VARCHAR(15) NOT NULL,
  `email_address` VARCHAR(100) NOT NULL,
  `date_range` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `privacy_policy` TINYINT(1) NOT NULL,
  `customer_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Offers
CREATE TABLE `offers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `original_price` DECIMAL(10,2) NOT NULL,
  `image_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Offer Orders
CREATE TABLE `offer_orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `offer_title` VARCHAR(255) NOT NULL,
  `offer_price` DECIMAL(10,2) NOT NULL,
  `offer_description` TEXT NOT NULL,
  `customer_username` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Staff
CREATE TABLE `staff` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Rental (after vehicles and clients)
CREATE TABLE `rental` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `rental_id` INT(11) NOT NULL,
  `vehicle_id` INT(11) NOT NULL,
  `client_id` INT(11) NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `rental_duration` INT(11) NOT NULL,
  `pickup_date` DATE NOT NULL,
  `dropoff_date` DATE NOT NULL,
  `rental_status` VARCHAR(50) NOT NULL,
  `receipt_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
