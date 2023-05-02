<?php

/**
 * @package configuration
 * @version 1.0.0
 * @author pedro-azeredo <pedro.azeredo93@gmail.com>
 */

/**
 * @package configuration
 * @subpackage html
 */
define("TITTLE", "SoftExpert");
define("META", [
    "description" => "",
    "author" => "Pedro Azeredo",
    "icon" => "./app-assets/images/icon.ico",
]);

/**
 * @package configuration
 * @subpackage other
 */
define("PAGINATION", 50);

/**
 * @package configuration
 * @subpackage database
 * SET GLOBAL max_allowed_packet=16777216;
 */


define("DB_DATABASE", "softexpert");
define("DB_HOST", "localhost");
define("DB_USER", "postgres");
define("DB_PASSWORD", "3306");


/**
 * @package configuration
 * @subpackage email
 */
define("SMTP_HOST", "");
define("SMTP_PORT", "");
define("SMTP_USER", "");
define("SMTP_PASS", "");

/**
 * @package condiguration
 * @subpackage files
 */
define("PATH_UPLOADS", "./uploads/");
define("PATH_LOGS", "./logs/");
