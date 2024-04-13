<?php
function load_class($class)
{
	static $_class = array();
	if (isset($_class[$class])) {
		$obj = $_class[$class];
	} else {

		if (file_exists(get_directory_path() . '/classes/' . strtolower($class) . '.php')) {
			include_once(get_directory_path() . '/classes/' . strtolower($class) . '.php');
			$_class[$class] = new $class();
			$obj = $_class[$class];
		} else {
			echo 'Class : ' . $class . ' does not exist in given directory';
			die();
		}
	}

	return $obj;
}
function getCompanyId()
{
	$compnay_id = $_SESSION['company_id'];
	return intval($compnay_id);
	//return 1;
}

function getUSerId()
{
	return $_SESSION['a_ch'];
	//return 1;	
}





function  made_user($ledger_id, $post)
{
	global $db;
	$arr = array();
	$arr['name'] = $post['first_name'];
	$arr['email'] = $post['email'];
	$arr['ledger_id'] = $ledger_id;
	$arr['role_id'] = intval(1);
	$arr['created_at'] = time();
	$arr['updated_at'] = time();
	// echo '<pre>';
	// print_r($arr);
	// die('jhsdg');
	$res = $db->insert($arr, 'admin');
	return $res;
}









setlocale(LC_MONETARY, "en_IN");

function CheckModules($module){
	return true;
	global $db,$auth_id;
	$authRow =  $db->fetch_array_by_query('select * from admin where id = '.$auth_id);
	$modules = $db->fetch_array_by_query("select modules from permissions where role_id = ".$authRow['role_id']);

	$modules = json_decode($modules['modules'],true);

	$access = false;
	if($authRow['super_admin'] == 'yes'){
		$access = true;
	}else{
		foreach($modules as $mod){

			if($mod == $module){
				$access = true;
				break;
			}
		}
	}

	return $access;
}




function check_permission($filename)
{
	global $db, $auth_id;
	$authRow =  $db->fetch_array_by_query('select * from admin where id = ' . $auth_id);
	$permissions = $db->fetch_array_by_query("select permissions from permissions where role_id = " . $authRow['role_id']);
	$permissions = json_decode($permissions['permissions'], true);
	$access = false;
	if ($authRow['super_admin'] == 'no') {
		foreach ($permissions as $p) {
			foreach ($p as 	$permission) {
				if ($filename == $permission) {
					$access = true;
					break;
				}
			}
		}
	} else {
		$access = true;
	}
	return $access;
}

