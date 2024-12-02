<?php
require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();


#Connection to database


$conn = mysqli_connect("serwer1704623.home.pl", "25262152_duda", getenv('KEY'), "25262152_duda", "3380");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";