<?php
include("../includes/common-files.php");
$a->authenticate();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING);

if (isset($_REQUEST['sub_loc_id'])  && $_REQUEST['command'] == 'subhead') {

	$subloc_id = implode(',', $_REQUEST['sub_loc_id']);


	$db->select("select * from hr_subhead where sub_loc_id IN(" . $subloc_id . ")");
	$subhead_data = $db->fetch_all();
	foreach ($subhead_data as $subhead_datas) {


		$dep_name = $db->fetch_array_by_query('select name from hr_department where id=' . $subhead_datas['department_id']);

		echo "<option value='" . $subhead_datas['department_id'] . "'>" . $dep_name['name'] . "</option>";
	}

	exit();
}
if (isset($_REQUEST['ajaxlocat_id'])  && $_REQUEST['command'] == 'head') {
	$loc_id = implode(',', $_REQUEST['ajaxlocat_id']);



	$db->select("select * from item_sublocation where location_id IN(" . $loc_id . ")");
	$head_datas = $db->fetch_all();
	foreach ($head_datas as $head_data) {
		echo "<option value='" . $head_data['id'] . "'>" . $head_data['name'] . "</option>";
	}
	exit();
}

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'update-permission') {

	$id = intval($_REQUEST['id']);
	$arr_role['role']  = $_REQUEST['name'];
	$arr_role['code']  = $_REQUEST['code'];
	$arr_role['description'] = $_REQUEST['description'];
	$arr_role['created_by'] = intval(getUserId());
	$arr_role['created_at'] = time();
	$r_result = $db->update($id, $arr_role, "roles");
	if ($r_result) {
		// echo 'herer<pre>';
		// print_r($_POST);
		// die();
		$pref = json_encode($_POST['pref']);
		$module = json_encode($_POST['module']);
		$arr_permission['permissions'] = $pref;
		$arr_permission['modules'] = $module;
		$emp = json_encode($_POST['emp']);
		$arr_permission['emp_att_pre'] = $emp;
		$arr_permission['created_by'] = getUserId();
		$arr_permission['company_id'] = getCompanyId();
		$arr_permission['created_by'] = getUserId();
		$arr_permission['created_at'] = time();
		$arr_permission['role_id'] = $id;
		$pr_row = $db->fetch_array_by_query("select * from permissions where role_id=" . $id);
		if ($pr_row) {
			$result = $db->update($pr_row['id'], $arr_permission, "permissions");
		} else {
			$result = $db->insert($arr_permission, "permissions");
		}
	}
	if ($result) {
		$imsg->setMessage("Permissions Updated Successfully", 'success');
		header("Location:roles.php");
	} else {
		$imsg->setMessage("Please Try Again", 'error');
		header("Location:roles.php");
	}
}

if (isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
	$permission_row = $db->fetch_array_by_query("select * from permissions where role_id=" . $_REQUEST['id']);
	$attends_permission = json_decode($permission_row['emp_att_pre'], true);
	//print_r($attends_permission);die();
	if ($attends_permission == '') {
		$attends_permission['emp_location'][0] = 0;
		$attends_permission['emp_sublocation'][0] = 0;
		$attends_permission['emp_department'][0] = 0;
	}
	//print_r($attends_permission);
	$role_row = $db->fetch_array_by_query("select * from roles where id=" . $_REQUEST['id']);
}
$page_title = " Permission Accounts ";
?>
<!DOCTYPE html>
<html>

<head>
	<?php include('../includes/site-master.php') ?>
	<style type="text/css">
		body {
			font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
		}

		#wrapper #content-wrapper {
			background-color: #f8f9fe !important;
		}

		.manage_user {
			color: #777;
			font-size: 14px !important;
		}

		.text_sup {
			color: #32325d;
			font-size: 22px;
			font-weight: 600;
		}

		.exp_card {
			padding: 15px;
			background-color: #fff;
			border-top: 3px solid #3c8dbc;
			border-radius: 6px;
		}

		.btn_add {
			background-color: #1367d1;
			color: #fff;
			border-color: #1367d1;
		}

		.border_th>th {
			color: #525f7f;
			font-size: 16px;
			border: 1px solid #e3e6f0;
		}

		.td_colour>td {
			color: #525f7f;
			font-size: 17px;
			border: 1px solid #e3e6f0;
		}

		.btn_close_modal {
			background-color: #ede9e9;
			border-color: #ede9e9;
		}

		.btn_save_modal {
			background-color: #1367d1;
			border-color: #1367d1;
			color: #fff;
		}

		.btn_default {
			background-color: #f4f4f4;
			color: #444;
			border: 1px solid #ddd;
			font-size: 12px;
		}

		.label_all {
			color: #525f7f;
			font-weight: 700;
			font-size: 18px;
		}

		.page-item.active .page-link {
			z-index: 1;
			color: #fff;
			background-color: #337ab7;
			border-color: #337ab7;
		}

		.dataTables_info {
			color: #525f7f;
		}

		.all_supp {
			font-size: 17px;
			font-weight: 600;
			color: #32325d;
			letter-spacing: 1px;
		}

		.label-danger {
			background-color: #d9534f;
			color: #fff;
			border-radius: 5px;
			font-size: 13px;
		}

		.label-success {
			background-color: #5cb85c;
			color: #fff;
			border-radius: 5px;
			font-size: 13px;
		}

		#tabsJustified .nav-tabs .nav-item.show .nav-link,
		.nav-tabs .nav-link.active {
			color: #2dce89 !important;
		}

		#tabsJustified .nav-tabs .nav-item .nav-link {
			color: #000 !important;
		}

		.col-sm-3 {
			color: black !important;
		}

		.active {}
	</style>
</head>

<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php include('../includes/sidebar.php') ?>
		<!-- Sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- TopBar -->
				<?php include('../includes/header.php') ?>
				<!-- Topbar -->
				<!-- Container Fluid-->
				<div class="container-fluid" id="container-wrapper">
					<h1 class="h3 mb-0 text_sup mb-3"><span class="pl-2 manage_user">Role</span></h1>
					<div class="exp_card card">
						<div class="d-flex justify-content-between  mb-4">
							<div class="p-2 all_supp">Role</div>
							<div class="p-2">
								<!-- <a href="add-purchase-invoice.php" type="button" class="btn btn_add btn-sm" style="color: #fff;">
                                    <span class="pr-2"><i class="fa-solid fa-plus"></i></span>Add Invoice</a>
                                </a> -->
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="span12 setmessage"> <?php echo $imsg->getMessage(); ?> </div>
							</div>
							<div class="col-sm-12">
								<form method="post" enctype="multipart/form-data" id='form1'>
									<input type="hidden" name="id" value="<?php echo intval($_REQUEST['id']) ?>">
									<input type="hidden" name="command" value="update-permission">
									<section class="container-fluid">
										<div class="row" style="margin-bottom:6px">
											<div class="col-sm-4">
												<label>Name</label>
												<input type="text" class="form-control" placeholder="Enter Item Name" name="name" value="<?php echo $role_row['role'] ?>" />
											</div>
											
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12">
												<h2>Permissions</h2>
												<ul id="tabsJustified" class="nav nav-tabs nav-fill">
													<li class="nav-item"><a href="" data-target="#tab1" data-toggle="tab" class="nav-link small text-uppercase active">Account Master</a></li>
													
												</ul>
												<br>
												<div id="tabsJustifiedContent" class="tab-content">
													<div id="tab1" class="tab-pane fade active show">
														<div class="container-fluid">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="accounts-master">&nbsp;&nbsp;Accounts Master </h1>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Administrators: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="ledger"> Select All</div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="administrators.php?command=add"> Create </div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="administrators.php"> View </div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="administrators.php?command=edit"> Edit </div>
																	</div>
																</div>
															
															</div>
														</div>
													</div>
											
												</div>
											</div>
										</div>
										<div>
											<hr>
											<button type="submit" class="databt btn btn-primary pull-right" style="margin:20px 0px"> Save Permission </button>
										</div>
									</section>
								</form>

							</div>
						</div>

					</div>
				</div>
				<!---Container Fluid-->
			</div>
			<!-- Footer -->
			<?php include('../includes/footer.php') ?>
			<!-- Footer -->
		</div>
	</div>

	<?php include('../includes/commonjs.php') ?>
	<script type="text/javascript">
		//tab1
		$('#ledger').click(function() {
			if ($(this).prop("checked") == true) {
				$('.ledger input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.ledger input[type="checkbox"]').prop('checked', false);
			}
		});

		// tab2
		$('#item').click(function() {
			if ($(this).prop("checked") == true) {
				$('.item input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.item input[type="checkbox"]').prop('checked', false);
			}
		});


		// tab6
		$('#pInvoice').click(function() {
			if ($(this).prop("checked") == true) {
				$('.pInvoice input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.pInvoice input[type="checkbox"]').prop('checked', false);
			}
		});
		$('#pQuotatoin').click(function() {
			if ($(this).prop("checked") == true) {
				$('.pQuotatoin input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.pQuotatoin input[type="checkbox"]').prop('checked', false);
			}
		});

		$('#Categories').click(function() {
			if ($(this).prop("checked") == true) {
				$('.Categories input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.Categories input[type="checkbox"]').prop('checked', false);
			}
		});

		//tab 7
		$('#sInvoice').click(function() {
			if ($(this).prop("checked") == true) {
				$('.sInvoice input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.sInvoice input[type="checkbox"]').prop('checked', false);
			}
		});
		$('#sQuotatoin').click(function() {
			if ($(this).prop("checked") == true) {
				$('.sQuotatoin input[type="checkbox"]').prop('checked', true);
			} else if ($(this).prop("checked") == false) {
				$('.sQuotatoin input[type="checkbox"]').prop('checked', false);
			}
		});


		<?php
		$permissions = json_decode($permission_row['permissions'], true);
		foreach ($permissions as $per) {
			foreach ($per as $permission) { ?>
				$('input[value="<?php echo $permission ?>"]').prop('checked', true);
		<?php }
		} ?>

		<?php $modules_row = json_decode($permission_row['modules'], true);
		foreach ($modules_row as $mod) { ?>
			$('input[value="<?php echo $mod ?>"]').prop('checked', true);
		<?php }
		?>
	</script>
</body>

</html>