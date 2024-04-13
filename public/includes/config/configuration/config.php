<?php

session_start();

date_default_timezone_set("Asia/Karachi");

//https://localhost/ http://inventory.devproedge.net/admin/login.php?redirect_url=index.php
// define('BASE_URL', "http://tastejamica.devproedge.com/");
// define('BASE_URL', "18.232.137.53");
define('BASE_URL', "https://tastejamaica.com/");





ini_set('display_errors', 0);

error_reporting(E_ALL);



define("DB_SERVER", "localhost");

define("DB_USER", "root");

define("DB_PASS", 'Love2bank123');

define("DB_NAME", "tastejamaica_new");



$default_date = date('Y M', time());

$default_months = ' <option value="2020 Jan">January (2020)</option>

				<option value="2020 Feb">February (2020)</option>

				<option value="2020 Mar">March (2020)</option>

				<option value="2020 Apr">April (2020)</option>

				<option value="2020 May">May (2020)</option>

				<option value="2020 Jun" >June (2020)</option>

				<option value="2020 Jul" >July (2020)</option>

				<option value="2020 Aug" >Aug (2020)</option>

				<option value="2020 Sep" >September (2020)</option>

				<option value="2020 Oct" >October (2020)</option>

				<option value="2020 Nov" >November (2020)</option>

				<option value="2020 Dec" >December (2020)</option>

				<option value="2021 Jan" >January (2021)</option>

				<option value="2021 Feb" >February (2021)</option>

				<option value="2021 Mar" >March (2021)</option>

				<option value="2021 Apr" >April (2021)</option>

				<option value="2021 May" >May (2021)</option>

				<option value="2021 Jun" >June (2021)</option>

				<option value="2021 Jul" >July (2021)</option>

				<option value="2021 Aug" >August (2021)</option>

				<option value="2021 Sep" >September (2021)</option>

				<option value="2021 Oct" >October (2021)</option>

				<option value="2021 Nov" >November (2021)</option>

				<option value="2021 Dec" >December (2021)</option>

				<option value="2022 Jan" >January (2022)</option>

				<option value="2022 Feb" >February (2022)</option>

				<option value="2022 Mar" >March (2022)</option>

				<option value="2022 Apr" >April (2022)</option>

				<option value="2022 May" >May (2022)</option>

				<option value="2022 Jun" >June (2022)</option>

				<option value="2022 Jul" >July (2022)</option>

				<option value="2022 Aug" >August (2022)</option>

				<option value="2022 Sep" >September (2022)</option>

				<option value="2022 Oct" >October (2022)</option>

				<option value="2022 Nov" >November (2022)</option>

				<option value="2022 Dec" >December (2022)</option>

				';





function makeRoman($no)
{

	$arr = array('(I)', '(II)', '(III)', '(IV)', '(V)');

	$var_return = "";

	for ($i = 0; $i < count($arr); $i++) {

		if (($no - 1) == $i) {

			$var_return = $arr[$i];

			break;
		}
	}

	return $var_return;
}

function get_directory_path()
{

	return dirname(__DIR__);
}

function redirect_header($page)
{
	header("location:$page");
	exit();
}


// Email configuration settings
function getEmailSmtp(){
return [
    'SMTPDebug' => 0,
    'isSMTP' => true,
    'Host' => 'smtp.hostinger.com',
    'SMTPAuth' => true,
    'Username' => 'info@tastejamica.devproedge.com',
    'Password' => '@1Tastejamica.devproedge.com',
    'SMTPSecure' => 'tls',
    'Port' => 587,
];
}

