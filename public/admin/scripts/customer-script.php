<?php

require_once("../includes/configuration/config.php");
require_once("../includes/configuration/functions.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
// die('script run');
$db = load_class('Database');

// Specify the CSV file path
$csvFilePath = 'Customer_2023-11-25.csv';

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
    echo '<pre>';
    print_r($data);

}
// Rewind the file pointer to the beginning of the file


// Close the file
fclose($file);
