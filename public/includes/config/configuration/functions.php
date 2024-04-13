<?php
function load_class($class)
{
	static $_class = array();
	if (isset($_class[$class])) {
		$obj = $_class[$class];
	} else {
		// echo get_directory_path();
		$directoryPath=str_replace("includes\config","admin\includes",get_directory_path());
		// $directoryPath=str_replace("includes/config","admin/includes",get_directory_path());
		// echo $directoryPath;
		// die();
		if (file_exists($directoryPath . '/classes/' . strtolower($class) . '.php')) {
			include_once($directoryPath . '/classes/' . strtolower($class) . '.php');
			$_class[$class] = new $class();
			$obj = $_class[$class];
		} else {
			echo 'Class : ' . $class . ' does not exist in given directory';
			die();
		}
	}

	return $obj;
}

function getUSerId()
{
	return $_SESSION['user_id'];
	//return 1;	
}










setlocale(LC_MONETARY, "en_IN");


