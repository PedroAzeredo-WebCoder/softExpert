<?php

/**
 * @package connection
 * @version 1.0.0
 * @author pedro-azeredo <pedro.azeredo93@gmail.com>
 */

$conn = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD) or print($conn->errorInfo());
