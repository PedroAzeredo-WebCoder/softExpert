<?php

/**
 * @package connection
 * @version 1.0.0
 * @author mmileski <michel.mileski@gmail.com.br>
 */

$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD) or print($conn->errorInfo());
