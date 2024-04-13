<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'add_data') {
	$arr = array();
	$arr['f_name'] = $_REQUEST['f_name'];
	$arr['l_name'] = $_REQUEST['l_name'];
	$arr['email'] = $_REQUEST['email'];
	$arr['new_sietter'] = $_REQUEST['new_sietter'];
	$arr['user_profile'] = $_REQUEST['user_profile'];
	$arr['created_at'] = time();
	$inserted_id = $db->insert($arr, 'user_profile');
	if ($inserted_id > 0) {
		$imsg->setMessage('User Profile Added Successfully!');
		redirect_header('user-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('user-profile.php');
	}
}


if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'edit_data') {
	$arr = array();
	$arr['f_name'] = $_REQUEST['edit_f_name'];
	$arr['l_name'] = $_REQUEST['edit_l_name'];
	$arr['email'] = $_REQUEST['edit_email'];
	$arr['new_sietter'] = $_REQUEST['edit_new_sietter'];
	$arr['user_profile'] = $_REQUEST['edit_user_profile'];
	$arr['created_at'] = time();
	$arr['updated_at'] = time();
	$inserted_id = $db->update($_REQUEST['hidden_profile_id'], $arr, 'user_profile');
	if ($inserted_id > 0) {
		$imsg->setMessage('User Profile Updated Successfully!');
		redirect_header('user-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('user-profile.php');
	}
}

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete' && isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
	$result = $db->query("delete from user_profile where id=" . intval($_REQUEST['id']));
	if ($result) {
		$imsg->setMessage('User Profile Deleted Successfully!');
		redirect_header('user-profile.php');
	} else {
		$imsg->setMessage('Error Occure Try Again', 'error!');
		redirect_header('user-profile.php');
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

		div.dataTables_wrapper div.dataTables_filter {
			float: inline-end !important;
		}

		footer {
			z-index: 999 !important;
		}

		.table-bordered td,
		.table-bordered th {
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
					<h4 class="h4 text-dark">User Profile</h4>
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
									<th></th>
									<th>#</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>News Letter</th>
									<th>User Profile</th>
									<th>Date Created</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql = 'select * from user_profile where 1=1';
								if (!empty($_REQUEST['search'])) {
									$sql .= ' and f_name like "%' . $_REQUEST['search'] . '%" or l_name like "%' . $_REQUEST['search'] . '%" or email like "%' . $_REQUEST['search'] . '%" or new_sietter like "%' . $_REQUEST['search'] . '%" or user_profile like "%' . $_REQUEST['search'] . '%"';
								}
								// if(!empty($_REQUEST['search_date'])){
								// 	$sql .= ' and DATE_FORMAT( DATE_ADD(DATE_FORMAT(FROM_UNIXTIME(created_at), "%Y-%m-%d %H:%i:%s"), INTERVAL 5 HOUR), "%m/%d/%Y") = "'. $_REQUEST["search_date"] .'"';
								// }
								$sql .= ' order by id desc';
								$db->select($sql);
								$rows = $db->fetch_all();
								$i = 0;
								if ($rows) {
									foreach ($rows as $row) {
								?>
										<tr>
											<td></td>
											<td><?= ++$i ?></td>
											<td><?= ucwords($row['f_name']) ?></td>
											<td><?= ucwords($row['l_name']) ?></td>
											<td><?= $row['email'] ?></td>
											<td><?= $row['new_sietter'] == 'yes' ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' ?></td>
											<td>
												<?php
												$user_profile = $row['user_profile'];
												if ($user_profile == 'persional') {
													$user_profile = 'personal';
												}
												?>
												<?= ucwords($user_profile); ?></td>
											<td><?= date('d-M-Y', $row['created_at']) ?></td>
											<td>
												<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_modal<?= $i ?>"><i class="fa-solid fa-pen-to-square"></i></a>
												<a href="<?php echo 'user-profile.php?command=delete&id=' . $row['id']; ?>" onClick="return confirm('Are you sure? You want to Delete This Record?')" class="btn btn-danger btn-sm"><i class="fa-sharp fa-solid fa-trash"></i></a>

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
																			<label for="">First Name</label>
																			<input type="text" name="edit_f_name" class="form-control" value="<?= $row['f_name'] ?>" placeholder="Enter First Name">
																		</div>
																		<div class="col-lg-6">
																			<label for="">Last Name</label>
																			<input type="text" name="edit_l_name" class="form-control" value="<?= $row['l_name'] ?>" placeholder="Enter Last Name">
																		</div>
																	</div>
																	<div class="row" style="margin-bottom: 15px;">
																		<div class="col-lg-6">
																			<label for="">Email</label>
																			<input type="text" name="edit_email" class="form-control" value="<?= $row['email'] ?>" placeholder="Enter Email">
																		</div>
																		<div class="col-lg-6">
																			<label for="">News Letter</label>
																			<select name="edit_new_sietter" class="form-control">
																				<option value="">select option</option>
																				<option <?= $row['new_sietter'] == 'yes' ? 'selected' : '' ?> value="yes">Yes</option>
																				<option <?= $row['new_sietter'] == 'no' ? 'selected' : '' ?> value="no">No</option>
																			</select>
																		</div>
																	</div>
																	<div class="row" style="margin-bottom: 15px;">
																		<div class="col-lg-6">
																			<label for="">User Profile</label>
																			<!-- <input type="text" name="edit_user_profile" class="form-control" value="<?php // $row['user_profile'] 
																																							?>" placeholder="Enter User Profile"> -->
																			<select name="user_profile" class="form-control">
																				<option value="business" <?php if ($row['user_profile'] == 'business') {
																												echo 'selected';
																											} ?>>Business</option>
																				<option value="persional" <?php if ($row['user_profile'] == 'persional') {
																												echo 'selected';
																											} ?>>Personal</option>

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
										<td colspan="9" style="text-decoration:underline;text-align:center;font-size:16px;">Sorry! No Record Found!</td>
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
										<label for="">First Name</label>
										<input type="text" name="f_name" class="form-control" placeholder="Enter First Name">
									</div>
									<div class="col-lg-6">
										<label for="">Last Name</label>
										<input type="text" name="l_name" class="form-control" placeholder="Enter Last Name">
									</div>
								</div>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-lg-6">
										<label for="">Email</label>
										<input type="text" name="email" class="form-control" placeholder="Enter Email">
									</div>
									<div class="col-lg-6">
										<label for="">News Letter</label>
										<select name="new_sietter" class="form-control">
											<option value="">select option</option>
											<option value="yes">Yes</option>
											<option value="no">No</option>
										</select>
									</div>
								</div>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-lg-6">
										<label for="">User Profile</label>
										<!-- <input type="text" name="user_profile" class="form-control" placeholder="Enter User Profile"> -->
										<select name="user_profile" class="form-control">
											<option value="business">Business</option>
											<option value="persional">Personal</option>

										</select>
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
			$(document).ready(function() {
				$('#datatable').DataTable();
			});
		</script>

</body>

</html>