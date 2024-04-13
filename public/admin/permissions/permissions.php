<?php
include("../includes/common-files.php");
$a->authenticate();
if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'add-permission') {

	$arr_role['role']  = $_REQUEST['name'];
	$arr_role['code']  = $_REQUEST['code'];
	$arr_role['description'] = $_REQUEST['description'];
	$arr_role['created_by'] = intval(getUserId());
	$arr_role['created_at'] = time();
	$role_id = $db->insert($arr_role, "roles");
	if ($role_id) {
		$pref = json_encode($_POST['pref']);
		$module = json_encode($_POST['module']);
		$arr_permission['permissions'] = $pref;
		$arr_permission['modules'] = $module;
		$arr_permission['created_by'] = getUserId();
		$arr_permission['company_id'] = getCompanyId();
		$arr_permission['created_by'] = getUserId();
		$arr_permission['created_at'] = time();
		$arr_permission['role_id'] = $role_id;
		$result = $db->insert($arr_permission, "permissions");

		//$array = array('permissions'=>$pref);
		//$result = $db->update($member_id,$array,"admin");
	}
	//$pref = json_encode($_POST['pref']);		
	//$array = array('permissions'=>$pref);
	//$result = $db->update($member_id,$array,"admin");
	if ($result) {
		$imsg->setMessage("Permissions Updated Successfully", 'success');
		header("Location:roles.php");
	} else {
		$imsg->setMessage("Please Try Again", 'error');
		header("Location:roles.php");
	}
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
									<input type="hidden" name="command" value="add-permission">
									<section class="container-fluid">
										<div class="row" style="margin-bottom:6px">
											<div class="col-sm-4">
												<label>Name</label>
												<input type="text" class="form-control" placeholder="Enter Item Name" name="name" value="<?php echo $role_row['role'] ?>" />
											</div>
											<div class="col-sm-4">
												<label>Code</label>
												<input type="text" class="form-control" placeholder="Enter Quantity" name="code" value="<?php echo $role_row['code'] ?>" />
											</div>
											<div class="col-sm-4">
												<label>Description</label>
												<textarea type="text" class="form-control " placeholder="Enter Value" name="description"><?php echo $role_row['description'] ?></textarea>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12">
												<h2>Permissions</h2>
												<ul id="tabsJustified" class="nav nav-tabs nav-fill">
													<li class="nav-item"><a href="" data-target="#tab1" data-toggle="tab" class="nav-link small text-uppercase active">Account Master</a></li>
													<li class="nav-item"><a href="" data-target="#tab2" data-toggle="tab" class="nav-link small text-uppercase ">Inventory Master</a></li>
													<li class="nav-item"><a href="" data-target="#tab3" data-toggle="tab" class="nav-link small text-uppercase">Accounting Voucher</a></li>
													<li class="nav-item"><a href="" data-target="#tab4" data-toggle="tab" class="nav-link small text-uppercase">Reports</a></li>
													<li class="nav-item"><a href="" data-target="#tab5" data-toggle="tab" class="nav-link small text-uppercase">Profile</a></li>
													<li class="nav-item"><a href="" data-target="#tab6" data-toggle="tab" class="nav-link small text-uppercase">Purchase</a></li>
													<li class="nav-item"><a href="" data-target="#tab7" data-toggle="tab" class="nav-link small text-uppercase">Sale</a></li>
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
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Ledger: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="ledger"> Select All</div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="simple-ledger.php?command=add"> Create </div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="simple-ledger.php"> View </div>
																		<div class="col-sm-12 ledger "><input type="checkbox" name="pref[acc_m][]" value="simple-ledger.php?command=edit"> Edit </div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div id="tab2" class="tab-pane fade ">
														<div class="container-fluid">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="inventory-master">&nbsp;&nbsp; Inventory Master </h1>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Products: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="item"> Select All</div>
																		<div class="col-sm-12 item"><input type="checkbox" name="pref[inv_m][]" value="list-products.php?command=add"> Create </div>
																		<div class="col-sm-12 item "><input type="checkbox" name="pref[inv_m][]" value="list-products.php"> View </div>
																		<div class="col-sm-12 item "><input type="checkbox" name="pref[inv_m][]" value="list-products.php?command=edit">Edit </div>
																	</div>
																</div>
															</div>

														</div>
													</div>
													<div id="tab3" class="tab-pane fade">
														<div class="container">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="accounting-vouchers">&nbsp;&nbsp; Accounting Vouchers </h1>
															</div>

														</div>
													</div>
													<div id="tab4" class="tab-pane fade">
														<div class="container">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="report-master">&nbsp;&nbsp; Report Master </h1>
															</div>

														</div>
													</div>
													<div id="tab5" class="tab-pane fade">
														<div class="container">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="user-profile">&nbsp;&nbsp; User Profile</h1>
															</div>

														</div>
													</div>
													<div id="tab6" class="tab-pane fade">
														<div class="container-fluid">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="purchase-master">&nbsp;&nbsp; Purchase Master</h1>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Purchase Quotation: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="pQuotatoin"> Select All</div>
																		<div class="col-sm-12 pQuotatoin "><input type="checkbox" name="pref[pur][]" value="purchase-pos.php"> Create </div>
																		<div class="col-sm-12 pQuotatoin "><input type="checkbox" name="pref[pur][]" value="purchase-quotation.php"> View </div>
																		<div class="col-sm-12 pQuotatoin "><input type="checkbox" name="pref[acc_m][]" value="edit-purchase-pos.php"> Edit </div>
																	</div>
																</div>
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Purchase Invoice: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="pInvoice"> Select All</div>
																		<div class="col-sm-12 pInvoice "><input type="checkbox" name="pref[pur][]" value="add-purchase-invoice.php"> Create </div>
																		<div class="col-sm-12 pInvoice "><input type="checkbox" name="pref[pur][]" value="purchase-invoice.php"> View </div>
																		<div class="col-sm-12 pInvoice "><input type="checkbox" name="pref[acc_m][]" value="edit-purchase-invoice.php"> Edit </div>
																	</div>
																</div>
															</div>

														</div>
													</div>
													<div id="tab7" class="tab-pane fade">
														<div class="container-fluid">
															<div class="text-center">
																<h1 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"><input type="checkbox" name="module[]" value="sale"> &nbsp;&nbsp; Sale </h1>
															</div>
															<div class="row">
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Sale Quotation: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="sQuotatoin"> Select All</div>
																		<div class="col-sm-12 sQuotatoin "><input type="checkbox" name="pref[pur][]" value="sale-quotation.php"> Create </div>
																		<div class="col-sm-12 sQuotatoin "><input type="checkbox" name="pref[pur][]" value="sale-pos.php"> View </div>
																		<div class="col-sm-12 sQuotatoin "><input type="checkbox" name="pref[acc_m][]" value="edit-sale-pos.php"> Edit </div>
																	</div>
																</div>
																<div class="col-sm-3">
																	<h3 style="text-decoration: underline;text-decoration-color: #dd4b39;color:black"> Sale Invoice: </h3>
																	<div class="col-sm-12">
																		<div class="col-sm-12"> <input type="checkbox" id="sInvoice"> Select All</div>
																		<div class="col-sm-12 sInvoice "><input type="checkbox" name="pref[pur][]" value="add-sale-invoice.php"> Create </div>
																		<div class="col-sm-12 sInvoice "><input type="checkbox" name="pref[pur][]" value="sale-invoice.php"> View </div>
																		<div class="col-sm-12 sInvoice "><input type="checkbox" name="pref[acc_m][]" value="edit-sale-invoice.php"> Edit </div>
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
	</script>
</body>


</html>