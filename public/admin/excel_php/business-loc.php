<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(0);
$link = mysqli_connect('localhost', 'u588136108_alhamd', 'yO&0+z3/', 'u588136108_alhamd');

function find_in($table, $str)
{
	global $link;
	$search_query = "select * from " . $table . " where name ='" . $str . "' order by id asc";
	// echo $search_cat_query."<br>";
	$row = mysqli_query($link, $search_query);
	$result = mysqli_fetch_assoc($row);
	return intval($result['id']);
}

function startsWith($string, $startString)
{
	$len = strlen($startString);
	return (substr($string, 0, $len) === $startString);
}

function insert_in($arr, $table)
{
	global $link;
	$cols = implode(",", array_keys($arr));
	foreach ($arr as $key => $values) {

		$data[] = "'" . $values . "'";
	}
	$query = "insert into $table ($cols) values (" . implode(',', $data) . ")";
	// echo $query;
	// die();
	$res = mysqli_query($link, $query);
	if ($res) {
		return true;
	} else {
		echo $query;
		die();
		return false;
	}
}

if (isset($_POST['submit'])) {
	// die('submitted');
	$file = $_FILES['doc']['tmp_name'];

	$ext = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);
	if ($ext == 'xlsx') {
		require('PHPExcel/PHPExcel.php');
		require('PHPExcel/PHPExcel/IOFactory.php');


		$obj = PHPExcel_IOFactory::load($file);
		foreach ($obj->getWorksheetIterator() as $sheet) {
			$getHighestRow = $sheet->getHighestRow();
	
			for ($i = 0; $i <= $getHighestRow; $i++) {
				$loc_name = $sheet->getCellByColumnAndRow(2, $i)->getValue();


				$loc_name = str_replace("'", "", $loc_name);

				$ins_arr = array();
				$ins_arr['name'] = $loc_name;
				$ins_arr['location_id'] = intval(1);
				$ins_arr['created_at'] = time();
				$ins_arr['updated_at'] = time();
				// echo "<pre>";
				// print_r($ins_arr);
				// continue;
				if ($i >= 3 && ($loc_name != '')) {
					$exist = find_in('business_sublocations', $loc_name);
					// $exist=0;
					if (intval($exist) > 0) {
						echo 'here';
					} else {
						echo "<pre>";
						print_r($ins_arr);
						continue;
						$inse = insert_in($ins_arr, 'business_sublocations');
					}
			
				} else {
					if ($i >= 5) {
						echo "<pre>";
						print_r($ins_arr);
						// die();
					}
				}
			}
		}
	} else {
		echo "Invalid file format";
	}
	echo "done";
	die();
}
?>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="doc" />
	<input type="submit" name="submit" />
</form>