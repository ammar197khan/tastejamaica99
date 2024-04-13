<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'add_data') {
	$arr = array();
	$arr['business_name'] = $_REQUEST['business_name'];
	$arr['address'] = $_REQUEST['address'];
	$arr['parish'] = $_REQUEST['parish'];
	$arr['registraion_date'] = strtotime($_REQUEST['registration_date']);
	$arr['status'] = $_REQUEST['status'];
	$arr['created_at'] = time();
	$inserted_id = $db->insert($arr, 'get_listed_profile');
	if ($inserted_id > 0) {
		$imsg->setMessage('Get Listed Profile Added Successfully!');
		redirect_header('get-listed-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('get-listed-profile.php');
	}
}

$notifications_arr = array('signup' => 
array(
    'file' => '../notifications/signup-notification.php', 
    'subject' => 'Welcome to Taste Jamaica '
),
 'personalSignup' => array(
    'file' => '../notifications/personal-profile-notification.php', 
    'subject' => 'Welcome to Taste Jamaica - Your Culinary Adventure Begins!'
 ),
 'getListed' => array(
    'file' => '../notifications/getlisted-notification.php', 
    'subject' => 'Restaurant Listing Submission Received - Taste Jamaica'
 ),
 'forget_password' => array(
    'file' => '../notifications/forget-notification.php', 
    'subject' => 'Taste Jamaica Password Reset Request'
 ),
 'business_approved' => array(
    'file' => '../notifications/business-approval-notification.php', 
    'subject' => 'Congratulations! Your Restaurant Listing is Approved on Taste Jamaica'
)
);
function send_notification($type, $arr)
{
    global $notifications_arr, $domain,$db;
    $notification_file = $notifications_arr[$type]['file'];
    $notification_subject = $notifications_arr[$type]['subject'];
    $user_name = $arr['f_name'] . ' ' . $arr['l_name'];
    $to = $arr['email'];
    if($type=='forget_password'){
        $otp_row=$db->fetch_array_by_query('select * from forget_passwords where user_id ='.intval($arr['id']).' order by id desc');
    }
    if($type=='business_approved'){
        $business_row=$db->fetch_array_by_query('select * from get_listed where user_id ='.intval($arr['id']).' order by id desc');
    }
    // include '../hostinger-email.php';
    include '../taste-jamaica-smtp.php';

    return true;
}


if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'edit_data') {
	$arr = array();

	if($_REQUEST['edit_status']=='approve'){
		$arr['approve']='yes';
	}else{
		$arr['approve']='no';

	}
	// $arr['status'] = $_REQUEST['edit_status'];
	// $arr['created_at'] = time();
	$arr['updated_at'] = time();
	$inserted_id = $db->update($_REQUEST['hidden_profile_id'], $arr, 'get_listed');
	if ($inserted_id > 0) {
		$listed_row =$db->fetch_array_by_query('select * from get_listed where id='.intval($_REQUEST['hidden_profile_id']));
		$listed_user =$db->fetch_array_by_query('select * from user_profile where id='.intval($listed_row['user_id']));
		send_notification('business_approved',$listed_user);
		$imsg->setMessage('Get Listed Profile Updated Successfully!');
		redirect_header('get-listed-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('get-listed-profile.php');
	}
}

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete' && isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
	// echo '<pre>';
	// print_r($_REQUEST);
	// die();
	// $result = $db->query("delete from get_listed_profile where id=" . intval($_REQUEST['id']));
	$result = $db->delete(intval($_REQUEST['id']),'get_listed');
	if ($result) {
		$imsg->setMessage('Get Listed Profile Deleted Successfully!');
		redirect_header('get-listed-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('get-listed-profile.php');
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
			display: flex;
		}

		.dash_text {
			justify-content: end;
		}

		.main_row {
			background: white;
			color: black
		}

		.modal-header {
			background: #1572e8;
			color: white
		}
		footer{
			z-index: 999 !important;
		}
		.table-bordered td, .table-bordered th {
			padding: 4px !important;
		}
	</style>
	<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php include('includes/sidebar.php') ?>
		<!-- Sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" style="height: 600px;overflow:scroll;">
				<!-- TopBar -->
				<?php include('includes/header.php') ?>
				<!-- Topbar -->

				<div class="col-lg-12 clearfix">
					<div class="span12"> <?php echo $imsg->getMessage(); ?></div>
				</div>
				<!-- Container Fluid-->
				<div class="dashboard_head px-4 pt-2" >
					<h4 class="h4 text-dark">Get Listed Profiles</h4>
					<!-- <div class="dash_text">
						<h5 class="text-dark">Dashboard / Administrators</h5>
					</div> -->
				</div>
				<div class="row px-4 pt-2 mt-4 main_row" style="height: 600px;overflow:scroll">
					<div class="col-lg-12" style="display:flex;margin-bottom:15px;display:none" >
						<div class="col-lg-4"></div>
						<form method="post" class="col-lg-6" style="display:flex;margin-bottom:15px">
							<div class="col-lg-6 datepicker">
								<label for="">Filter By Date</label>
								<input type="date" name="search_date" class="form-control">
							</div>
							<div class="col-lg-6">
								<label for="">Search</label>
								<div class="input-group">
									<input class="form-control border-end-0 border" name="search" type="text" value="<?= $_REQUEST['search'] ?>" id="example-search-input" placeholder="search">
									<span class="input-group-append">
										<button class="btn btn-default">
											<i class="fa fa-search"></i>
										</button>
									</span>
								</div>
							</div>
						</form>
						<div class="col-lg-2" style="padding-top: 30px;">
							<button class="btn btn-primary btn-sm"><i class="fa fa-download" aria-hidden="true" style="font-size: 18px;"></i></button>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_modal"><i class="fa fa-plus" aria-hidden="true" style="font-size: 18px;"></i></button>
						</div>
					</div>
					<div class="col-lg-12" >
						<table class="table table-bordered data-table-1">
							<thead>
								<tr>
									<th>#</th>
									<th>Application no#</th>
									<th>Business Name</th>
									<th>Address</th>
									<th>Parish</th>
									<th>Registration Date</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// $sql = 'select * from get_listed_profile where 1=1';
								$sql = 'SELECT * FROM `get_listed`   ';
								if (!empty($_REQUEST['search'])) {
									$sql .= ' and business_name like "%' . $_REQUEST['search'] . '%" or address like "%' . $_REQUEST['search'] . '%" or parish like "%' . $_REQUEST['search'] . '%" or status like "%' . $_REQUEST['search'] . '%"';
								}
								if (!empty($_REQUEST['search_date'])) {
									$sql .= ' and DATE_FORMAT( DATE_ADD(DATE_FORMAT(FROM_UNIXTIME(registration_date), "%Y-%m-%d %H:%i:%s"), INTERVAL 5 HOUR), "%m/%d/%Y") = "' . $_REQUEST["search_date"] . '"';
								}
								$sql .= ' order by id desc';
								$db->select($sql);
								$rows = $db->fetch_all();
								$i = 0;
								if ($rows) {
									foreach ($rows as $row) {
										// $business=$db->fetch_array_by_query('select * from user_profile where user_id='.intval($row['user_id']));
								?>
										<tr>
											<td><?= ++$i ?></td>
											<td><?= '00-'.$row['id']; ?></td>
											<td><?= ucwords($row['name']) ?></td>
											<td><?= ucwords($row['address']) ?></td>
											<td><?= ucwords($row['parish_type']) ?></td>
											<td><?= date('Y-m-d', $row['created_at']) ?></td>
											<td><?= $row['approve'] == 'yes' ? '<span class="badge badge-success">Approve</span>' : '<span class="badge badge-danger">Pending</span>' ?></td>
											<td>
												<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_modal<?= $i ?>"><i class="fa-solid fa-pen-to-square"></i></a>
												<a href="<?= ADMIN_URL . 'business-detail.php' ?>?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<a href="<?php echo 'get-listed-profile.php?command=delete&id=' . $row['id']; ?>" onClick="return confirm('Are you sure? You want to Delete This Record?')" class="btn btn-danger btn-sm"><i class="fa-sharp fa-solid fa-trash"></i></a>

												<!--Edit The Modal Start-->
												<form method="post">
													<div class="modal fade" id="edit_modal<?= $i ?>">
														<div class="modal-dialog modal-md">
															<div class="modal-content">

																<!-- Modal Header -->
																<div class="modal-header">
																	<h4 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Edit</h4>
																	<button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
																</div>

																<!-- Modal body -->
																<div class="modal-body">
															
																	<div class="row" style="margin-bottom: 15px;">
																	<input type="hidden" name="hidden_profile_id" value="<?= $row['id'] ?>">
																		<div class="col-lg-6">
																			<label for="">Status</label>
																			<select name="edit_status" class="form-control">
																				<option value="">select option</option>
																				<option <?= $row['status'] == 'pending' ? 'selected' : '' ?> value="pending">Pending</option>
																				<option <?= $row['status'] == 'approve' ? 'selected' : '' ?> value="approve">Approve</option>
																			</select>
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
									<?php }
								} else { ?>
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
			<form method="post">
				<div class="modal fade" id="add_modal">
					<div class="modal-dialog modal-md">
						<div class="modal-content">

							<!-- Modal Header -->
							<div class="modal-header">
								<h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="font-size: 18px;"></i> Add</h4>
								<button type="button" class="close" data-dismiss="modal" style="color:white">&times;</button>
							</div>

							<!-- Modal body -->
							<div class="modal-body">
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-lg-6">
										<label for="">Business Name</label>
										<input type="text" name="business_name" class="form-control" placeholder="Enter First Name">
									</div>
									<div class="col-lg-6">
										<label for="">Address</label>
										<textarea name="address" id="" class="form-control" cols="10" rows="1" placeholder="Enter Adress"></textarea>
									</div>
								</div>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-lg-6">
										<label for="">Parish</label>
										<textarea name="parish" id="" class="form-control" cols="10" rows="1" placeholder="Enter Parish"></textarea>
									</div>
									<div class="col-lg-6 datepicker">
										<label for="">Registration Date</label>
										<input type="date" name="registration_date" class="form-control">
									</div>
								</div>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-lg-6">
										<label for="">Status</label>
										<select name="status" class="form-control">
											<option value="">select option</option>
											<option value="pending">Pending</option>
											<option value="approve">Approve</option>
										</select>
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
		<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
				<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
		<script>
			// $("input").prop('required',true);
			$('.data-table-1').DataTable();
			
		</script>

</body>

</html>