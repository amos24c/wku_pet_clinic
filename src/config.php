<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pet_clinic';

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
