<?php
// die('run');
require_once("../includes/configuration/config.php");
require_once("../includes/configuration/functions.php");
ini_set('display_errors',1);
error_reporting(E_ALL);

die('script run');
$db = load_class('Database');
// $db->query('delete from user_profile where id >142');
// die();
// Specify the CSV file path
$csvFilePath = 'business-script.csv';

// Open the CSV file
$file = fopen($csvFilePath, 'r');

// Read the header row to get column names
$headers = fgetcsv($file);

// Process the remaining rows
$total_amount = 0;
// Calculate the total in the first loop
while (($row = fgetcsv($file)) !== false) {
    // Create an associative array using headers as keys
    $data = array_combine($headers, $row);
    $email_exp = explode('@', $data['E-mail']);
    // print_r($data);

    if($data['E-mail'] != ''){
        $arr = array();
        $arr['f_name'] = $email_exp[0];
        $arr['l_name'] = $email_exp[0];
        $arr['username'] = $email_exp[0];
        $arr['email'] = $data['E-mail'];
        $arr['password'] = md5($data['Password']);
        $arr['pass_hint'] = $data['Password'];
        $arr['user_profile']='business';
        // echo '<pre>';
        // print_r($arr);
        // $inserted_id = $db->insert($arr, 'user_profile');
        // var_dump($inserted_id);
    }else{
        echo 'empty email';
    }
}
// Rewind the file pointer to the beginning of the file


// Close the file
fclose($file);
