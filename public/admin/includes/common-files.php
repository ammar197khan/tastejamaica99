<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING);
$path_includes = str_replace("/includes", "", dirname(__FILE__)) . "/";

require_once($path_includes . "includes/configuration/config.php");
require_once($path_includes . "includes/configuration/functions.php");
$db = load_class('Database');
$imsg = load_class('InfoMessages');
$a = load_class('AdminAuth');
$auth_id = $a->get_session_id();
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
function checkPagePermission($redirect = true)
{
	global $db, $auth_id, $page, $path_includes, $auth_row1;
	unset($_SESSION['permissions']);

	$admin = $db->fetch_array_by_query("SELECT a.*,p.permissions , p.modules as modules from admin as a , permissions as p where a.id=" . $auth_id . " and p.role_id=a.role_id");
	if (!$admin) {
		$admin = $db->fetch_array_by_query('select * from admin where id=' . intval($auth_id));
		if ($admin['super_admin'] == 'yes') {
			$super_admin = true;
			// die('yes');
			return true;
			exit();
		}
	}
	$permissions = json_decode($admin['permissions'], true);
	$_SESSION['permissions'] =  $permissions;
	$_SESSION['modules'] = json_decode($admin['modules'], true);
	if ($admin['super_admin'] == 'yes' ||  $page == 'index.php' || $page == 'dashboard.php' || $page == 'logout.php' || $page == 'login.php') {
		$super_admin = true;
		// die('yes');
		return true;
		exit();
	}
	$access = false;
	foreach ($permissions as $permission) {
		foreach ($permission as $p) {
			if ($p == $page) {
				$access = true;
			}
		}
	}
	if (!$access && $redirect) {
		// echo $path_includes.'permissions/no-permission.php';
		include($path_includes . 'permissions/no-permission.php');
		exit();
	} else {
		return $access;
	}
}

checkPagePermission();
