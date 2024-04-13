<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING);
$path_includes = str_replace("/includes", "", dirname(__FILE__)) . "/";

require_once($path_includes . "includes/configuration/config.php");
require_once($path_includes . "includes/configuration/functions.php");
$db = load_class('Database');
$imsg = load_class('InfoMessages');

$page_requested = $_SERVER['PHP_SELF'];
$page_requested = explode('/', $page_requested);
$page_size = sizeof($page_requested);
if ($page_size == 4) {
	$page = $page_requested[3];
} elseif ($page_size == 5) {
	$page = $page_requested[4];
} else {
	$page = $page_requested[2];
}

$super_admin = false;
$file_name = basename(parse_url(basename($_SERVER['REQUEST_URI']), PHP_URL_PATH));

