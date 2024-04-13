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
			// echo $getHighestRow;
			// die();

			for ($i = 0; $i <= $getHighestRow; $i++) {
				// echo 'here';
				$loc_name = $sheet->getCellByColumnAndRow(1, $i)->getValue();

				// $current_stock = $sheet->getCellByColumnAndRow(5, $i)->getValue();
				$cat_name = $sheet->getCellByColumnAndRow(3, $i)->getValue();
				$sub_cat_name = $sheet->getCellByColumnAndRow(4, $i)->getValue();

				$cat_exist = find_in('categories', $cat_name);


				// $note = str_replace("'", "", $note);
				$name = str_replace("'", "", $name);
				$parent_cat='no';
				if(intval($cat_exist)>0){
					$parent_cat='yes';
				}
				$ins_arr = array();
				$ins_arr['name'] = $sub_cat_name;
				$ins_arr['category'] = $parent_cat;
				$ins_arr['category_id'] = intval($cat_exist);
				$ins_arr['created_at'] = time();
				$ins_arr['updated_at'] = time();
				// echo "<pre>";
				// print_r($ins_arr);
				// continue;
				if ($i >= 3 && ($sub_cat_name != '')) {
					$exist = find_in('sub_categories', $sub_cat_name);
					// $exist=0;
					if (intval($exist) > 0) {
						echo 'here';
					} else {
						// echo "<pre>";
						// print_r($ins_arr);
						// continue;
						$inse = insert_in($ins_arr, 'sub_categories');
					}
			
				} else {
					if ($i >= 5) {
						echo "<pre>";
						print_r($ins_arr);
						die();
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