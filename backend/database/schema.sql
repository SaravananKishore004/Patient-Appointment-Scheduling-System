CREATE DATABASE IF NOT EXISTS patient_scheduler
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE patient_scheduler;

CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  doctor VARCHAR(100) NOT NULL,
  reason TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
