<?php
ini_set('max_execution_time', '0');
ini_set("display_errors",1);
error_reporting(E_ALL ^ E_WARNING); 
error_reporting(1);
$link = mysqli_connect('localhost', 'u588136108_alhamd', 'yO&0+z3/', 'u588136108_alhamd');
function find_in($table,$str){
	global $link;
	$search_query = "select * from " . $table . " where name ='" . $str . "' order by id asc";
	// echo $search_query."<br>";
	$row = mysqli_query($link, $search_query);
	// print_r($row);
	// if($row){
	$result = mysqli_fetch_assoc($row);
	return intval($result['id']);
	// }else{
	// 	return 0;
	// }
}

function startsWith ($string, $startString)
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
			$count=0;
			for ($i = 0; $i <= $getHighestRow; $i++) {
				// echo 'here<br>';
                // continue;
				$product_name = $sheet->getCellByColumnAndRow(0, $i)->getValue();
				
				$loc_name = $sheet->getCellByColumnAndRow(2, $i)->getValue();
				$purchase_price = $sheet->getCellByColumnAndRow(5, $i)->getValue();
				$selling_price = $sheet->getCellByColumnAndRow(6, $i)->getValue();
				$unit = $sheet->getCellByColumnAndRow(1, $i)->getValue();
				$category = $sheet->getCellByColumnAndRow(3, $i)->getValue();
				$sub_cat_name = $sheet->getCellByColumnAndRow(4, $i)->getValue();
				$sku = $sheet->getCellByColumnAndRow(7, $i)->getValue();
                //$stock=explode(' ',$current_stock);
                $qty=$stock[0];
                $stock_name=$stock[1];

                // if ($i >= 1 && ($sub_cat_name != '')) {
                if ($i >= 1) {
				$ins_arr = array();

                $exist=find_in('business_sublocations',$loc_name);
                if(intval($exist)>0){
                   $loc_name=intval($exist);
                }
                
                if($unit=='Pc(s)'){
                	$unit = 'Pieces';
                }elseif($unit=='FT'){
                	$unit='FEET';
                }else if($unit='DZN'){
                	$unit='DOZEN';
                }
                
                $exist=find_in('item_unit',$unit);
                if(intval($exist)>0){
                   $stock_name=intval($exist);
                }

                //categroy

                $exist=find_in('categories',$category);
                if(intval($exist)>0){
                    // echo 'here';
                    $category=intval($exist);
                }


                $exist=find_in('sub_categories',$sub_cat_name);
                if(intval($exist)>0){
                    // echo 'here';
                    $sub_cat_name=intval($exist);
                }

                $purchase_price=str_replace('₨','',$purchase_price);
                $selling_price=str_replace('₨','',$selling_price);
                $purchase_price=str_replace(',','',$purchase_price);
                $selling_price=str_replace(',','',$selling_price);
                $product_name=str_replace('"','',$product_name);
                $product_name=str_replace("'",'',$product_name);
                $product_name=str_replace('”','',$product_name);
                $sku=str_replace("'",'',$sku);
                $sku=str_replace('"','',$sku);




				$ins_arr['name'] = $product_name;
				$ins_arr['unit_id'] = intval($stock_name);
				$ins_arr['opening_stock'] = intval($qty);
				$ins_arr['product_locations'] = intval(1);
				$ins_arr['product_sublocations'] = intval($loc_name);
				$ins_arr['purchase_price_with_tax'] = intval($purchase_price);
				$ins_arr['purchase_price_without_tax'] = intval($purchase_price);
				$ins_arr['selling_price'] = intval($selling_price);
				$ins_arr['sub_category_id'] =intval($sub_cat_name);
				$ins_arr['category_id'] =intval($category);
				$ins_arr['sku'] =$sku;
				$ins_arr['created_at'] = time();
				$ins_arr['updated_at'] = time();
				
				$p_exist=find_in('products',$product_name);
					if(intval($p_exist)>0){
						$count = $count+1;
						echo $product_name.' exist '.$p_exist.' <br>';
						continue;
					}else{
						echo '<pre>';
						print_r($ins_arr);
						continue;
					}
                // echo '<pre>';
                // print_r($ins_arr);
                // continue;

				if(intval($loc_name)==0){
					// echo '<pre>';
					// print_r($ins_arr);
					// continue;
					$inse = insert_in($ins_arr, 'products');
				}else{
					
						// echo 'not exist';
						// continue;
						$inse = insert_in($ins_arr, 'products');
					
				}
                    // die();
					// 	continue;
						// die();
					// $inse = insert_in($ins_arr, 'publications');
					// if ($inse) {
					// 	echo "inserted<br>";
					// } else {
					// 	echo "error";
					// 	die();
					// }
				} else {
					
					// if ($i >= 5) {
					// 	echo "<pre>";
					// 	print_r($ins_arr);
					// 	die();
					// }
				}
			}
			echo $count;
		}
	} else {
		echo "Invalid file format";
	}
	echo "done";
}
?>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="doc" />
	<input type="submit" name="submit" />
</form>