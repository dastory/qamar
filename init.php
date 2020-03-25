<?php
/**
 * Get page name from url and assign the name into
 * $pageName variable
 * This variable is responsible to load script to
 * respective page and page name is the file name
 * only. (ie: main page means main.php)
 */
$pageName = rtrim(ltrim($_SERVER['SCRIPT_NAME'], "/"), ".php");

/**
 * Set time/zone from default to BD time/zone (* if needed at php end)
 */
date_default_timezone_set('Asia/Dhaka');
