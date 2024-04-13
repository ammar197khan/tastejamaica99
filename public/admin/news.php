<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


define('FILE_URL',ADMIN_URL.'file_docx/');
define('FILE_DIR','file_docx/');

function check_image($ext){
    $image_formate = array('png','gif','jpg','jpeg','tiff','raw');
    $file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
    if (in_array($ext, $image_formate)){
        return 'pic';
    }else if(in_array($ext, $file_formate)){
        return 'file';
    }
}
function get_array($arr){
    foreach ($arr as $key => $all){
        foreach ($all as $i => $val){
            $new[$i][$key] = $val;
        }
    }
    return $new;
}

function getExtention($file_name) {
    $filename = $file_name['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return $ext;
}


if(isset($_REQUEST['command']) && $_REQUEST['command'] == 'add_data'){
	$arr = array();
	$arr['name'] = $_REQUEST['name'];
	$arr['url_path'] = $_REQUEST['url_path'];

	if ($_FILES['image']['name'][0] != ''){
        $file_format = check_image(getExtention($_FILES["image"]));
        $obj_upload = load_class('UploadImage');
        $uploadName = time() . rand();
        if($file_format == 'pic'){
            $resultFile = $obj_upload->upload_image_with_thumbnail($_FILES["image"], FILE_DIR, $uploadName, 300, 0, "width");
        }else if($file_format == 'file'){
            $resultFile = $obj_upload->upload_files($_FILES["image"], FILE_DIR, $uploadName);
        }
        if ($resultFile)
        {
            $doc_files_name = $obj_upload->get_image_name();
        }
		$arr['image'] = $doc_files_name;
    }

	$arr['content'] = $_REQUEST['content'];
	$arr['created_at'] = time();
	$inserted_id = $db->insert($arr, 'news');
	if($inserted_id > 0){
        $imsg->setMessage('News Added Successfully!');
        redirect_header('news.php');
    } else {
        $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('news.php');
    }
}


if(isset($_REQUEST['command']) && $_REQUEST['command'] == 'edit_data'){
	$arr = array();
	$arr['name'] = $_REQUEST['edit_name'];
	$arr['url_path'] = $_REQUEST['edit_url_path'];

	if ($_FILES['edit_image']['name'][0] != ''){
        $file_format = check_image(getExtention($_FILES["edit_image"]));
        $obj_upload = load_class('UploadImage');
        $uploadName = time() . rand();
        if($file_format == 'pic'){
            $resultFile = $obj_upload->upload_image_with_thumbnail($_FILES["edit_image"], FILE_DIR, $uploadName, 300, 0, "width");
        }else if($file_format == 'file'){
            $resultFile = $obj_upload->upload_files($_FILES["edit_image"], FILE_DIR, $uploadName);
        }
        if ($resultFile)
        {
            $doc_files_name = $obj_upload->get_image_name();
        }
		$arr['image'] = $doc_files_name;
    }

	$arr['content'] = $_REQUEST['edit_content'];
	$arr['created_at'] = time();
	$arr['updated_at'] = time();
	$inserted_id = $db->update($_REQUEST['hidden_id'],$arr, 'news');
	if($inserted_id > 0){
        $imsg->setMessage('News Updated Successfully!');
        redirect_header('news.php');
    } else {
        $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('news.php');
	}
    
}

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete' && isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
    $result = $db->query("delete from news where id=" . intval($_REQUEST['id']));
    if($result){
        $imsg->setMessage('News Deleted Successfully!');
        redirect_header('news.php');
    } else {
        $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('news.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/site-master.php') ?>

	<style type="text/css">
		body {
			font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
		}

		#wrapper #content-wrapper {
			background-color: #dae6f1;
		}

		.dashboard_head {
			display:flex;
		}
		.dash_text{
			justify-content: end;
		}
        .main_row{background:white;color:black}
		.modal-header{background:#1572e8;color:white}
		div.dataTables_wrapper div.dataTables_filter {
			float: inline-end !important;
		}
		footer{
			z-index: 999 !important;
		}
		.table-bordered td, .table-bordered th {
			padding: 4px !important;
		}
	</style>

</head>

<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php include('includes/sidebar.php') ?>
		<!-- Sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- TopBar -->
				<?php include('includes/header.php') ?>
				<!-- Topbar -->
				
				<div class="col-lg-12 clearfix">
					<div class="span12"> <?php echo $imsg->getMessage(); ?></div>
				</div>
				<!-- Container Fluid-->
				<div class="dashboard_head px-4 pt-2">
					<h4 class="h4 text-dark">News</h4>
					<!-- <div class="dash_text">
						<h5 class="text-dark">Dashboard / Administrators</h5>
					</div> -->
				</div>
				<div class="row px-4 pt-2 mt-4 main_row" style="height: 600px;overflow:scroll">
					<div class="col-lg-12" style="display:flex;margin-bottom:15px">
						<div class="col-lg-10"></div>
					
						<div class="col-lg-2" style="padding-top: 30px;">
							<button class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true" style="font-size: 18px;"></i></button>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus" aria-hidden="true" style="font-size: 18px;"></i></button>
						</div>
					</div>
					<div class="col-lg-12">
						<table class="table table-bordered" id="datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Url Path</th>
									<th>Image</th>
									<th>Content</th>
									<th>Date Created</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$sql = 'select * from news where 1=1';
									if(!empty($_REQUEST['search'])){
										$sql .= ' and name like "%'.$_REQUEST['search'].'%" or url_path like "%'.$_REQUEST['search'].'%" or content like "%'.$_REQUEST['search'].'%"';
									}
									// if(!empty($_REQUEST['search_date'])){
									// 	$sql .= ' and DATE_FORMAT( DATE_ADD(DATE_FORMAT(FROM_UNIXTIME(created_at), "%Y-%m-%d %H:%i:%s"), INTERVAL 5 HOUR), "%m/%d/%Y") = "'. $_REQUEST["search_date"] .'"';
									// }
									$sql .= ' order by id desc';
									$db->select($sql);
									$rows = $db->fetch_all();
									$i = 0;
                                    if($rows){
									    foreach($rows as $row){
								?>
									<tr>
										<td><?= ++$i ?></td>
										<td><?= ucwords($row['name']) ?></td>
										<td><?= ucwords($row['url_path']) ?></td>
										<td>
											<?php
												if(!empty($row['image'])){
													$src = FILE_URL.$row['image'];
													$extention = substr($row['image'], strpos($row['image'], ".") + 1);
													$file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
													if (in_array($extention, $file_formate)){
														$src = ADMIN_URL."80942.png";
											?>
												<a href="<?php echo FILE_URL.$row['image'];?>" target="_blank">
													<img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src;?>" alt="image"  width="40" height="40">
												</a>
											<?php }else{?>
												<a href="<?= FILE_URL.$row["image"];?>" download target="_blank">
													<img style="width: 40px;height:40px;margin-bottom: 3px;" src="<?= FILE_URL.$row["image"];?>"  alt="image">
												</a>
											<?php }}?>
										</td>
										<td><?= ucwords($row['content']); ?></td>
										<td><?= date('Y-M-d', $row['created_at'])?></td>
										<td>
											<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_modal<?= $i ?>"><i class="fa-solid fa-pen-to-square"></i></a>
											<a href="<?php echo 'news.php?command=delete&id='.$row['id']; ?>" onClick="return confirm('Are you sure? You want to Delete This Record?')" class="btn btn-danger btn-sm"><i class="fa-sharp fa-solid fa-trash"></i></a>

											<!--Edit The Modal Start-->
											<form enctype='multipart/form-data' method="post">
												<div class="modal fade" id="edit_modal<?= $i ?>">
													<div class="modal-dialog modal-md">
													<div class="modal-content">
													
														<!-- Modal Header -->
														<div class="modal-header">
															<h4 class="modal-title"><i class="fa-solid fa-pen-to-square"></i>  Edit</h4>
															<button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
														</div>
														
														<!-- Modal body -->
														<div class="modal-body">
															<div class="row" style="margin-bottom: 15px;">
																<input type="hidden" name="hidden_id" value="<?= $row['id'] ?>">
																<div class="col-lg-12" style="margin-bottom: 19px;">
																	<label for="">Name</label>
																	<input type="text" name="edit_name" class="form-control" value="<?= $row['name'] ?>" placeholder="Enter Name">
																</div>
																<div class="col-lg-12" style="margin-bottom: 19px;">
																	<label for="">Url Path</label>
																	<input type="text" name="edit_url_path" class="form-control" value="<?= $row['url_path'] ?>" placeholder="Enter Url Path">
																</div>
                                                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                                                    <label for="">Content</label>
                                                                    <input type="text" name="edit_content" class="form-control" value="<?= $row['content'] ?>" placeholder="Enter Web Site">
                                                                </div>
                                                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                                                    <label for="">Image</label>
                                                                    <input type="file" name="edit_image" class="form-control">
                                                                    <?php
                                                                        if(!empty($row['image'])){
                                                                            $src = FILE_URL.$row['image'];
                                                                            $extention = substr($row['image'], strpos($row['image'], ".") + 1);
                                                                            $file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
                                                                            if (in_array($extention, $file_formate)){
                                                                                $src = ADMIN_URL."80942.png";
                                                                    ?>
                                                                        <a href="<?php echo FILE_URL.$row['image'];?>" target="_blank">
                                                                            <img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src;?>" alt="image"  width="60" height="60">
                                                                        </a>
                                                                    <?php }else{?>
                                                                        <a href="<?= FILE_URL.$row["image"];?>" download target="_blank">
                                                                            <img style="width: 60px;height:60px;margin-bottom: 3px;" src="<?= FILE_URL.$row["image"];?>"  alt="image">
                                                                        </a>
                                                                    <?php }}?>
                                                                </div>
															</div>
														</div>
														
														<!-- Modal footer -->
														<div class="modal-footer">
														<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
														<button class="btn btn-sm btn-primary" name="command" value="edit_data">Update</button>
														</div>
														
													</div>
													</div>
												</div>
											</form>
											<!--Edit The Modal End-->



										</td>
									</tr>
								<?php }}else{ ?>
                                    <tr>
                                        <td colspan="7" style="text-decoration:underline;text-align:center;font-size:16px;">Sorry! No Record Found!</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
						</table>
					</div>
				</div>
				<!-- Footer -->
				<?php include('includes/footer.php') ?>
				<!-- Footer -->
			</div>




			<!--Add The Modal Start-->
			<form enctype='multipart/form-data' method="post">
				<div class="modal fade" id="add_modal">
					<div class="modal-dialog modal-md">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="font-size: 18px;"></i>  Add</h4>
							<button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
						</div>
						
						<!-- Modal body -->
						<div class="modal-body">
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                    <label for="">Url Path</label>
                                    <input type="text" name="url_path" class="form-control" placeholder="Enter Url Path">
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                    <label for="">Content</label>
                                    <textarea name="content" class="form-control" placeholder="Enter Content" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 19px;">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
						</div>
						
						<!-- Modal footer -->
						<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
						<button class="btn btn-sm btn-primary" name="command" value="add_data">Save</button>
						</div>
						
					</div>
					</div>
				</div>
			</form>
			<!--Add The Modal End-->




		</div>

		<!-- Scroll to top -->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

		<?php include('includes/commonjs.php') ?>
		<script>
			// $("input").prop('required',true);
			$(document).ready(function () {
				$('#datatable').DataTable();
			});
		</script>
	
</body>

</html>