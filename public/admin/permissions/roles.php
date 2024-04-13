<?php
include '../includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL & ~E_WARNING);





?>
<!DOCTYPE html>
<html lang="en">

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
        .label-danger {background-color: #d9534f;color: #fff;border-radius: 5px;font-size: 13px;}
        .label-success {background-color: #5cb85c;color: #fff;border-radius: 5px;font-size: 13px;}
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
                    <h1 class="h3 mb-0 text_sup mb-3">Roles<span class="pl-2 manage_user">Roles</span></h1>
                    <div class="exp_card card">
                        <div class="d-flex justify-content-between  mb-4">
                            <div class="p-2 all_supp">Roles</div>
                            <div class="p-2">
                                <a href="<?= ADMIN_URL.'/permissions/permissions.php' ?>" type="button" class="btn btn_add btn-sm" style="color: #fff;">
                                    <span class="pr-2"><i class="fa-solid fa-plus"></i></span>Add Role</a>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="span12 setmessage"> <?php echo $imsg->getMessage();?> </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center  mb-3 pt-3">
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to CV</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-excel px-2"></i>Export to Excel</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-print px-2"></i>Print</div>
                            <div class="p-2 btn_default"> <i class="fa-regular fa-columns-3 px-2"></i>Coloumn Visibility</div>
                            <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to Pdf</div>
                        </div>
                        <div class="table-responsive p-3">
								<table class="table table-bordered table-striped" id="customers">
									<thead>
										<tr>
											<th>#</th>
											<th> Role </th>
											<th> Code </th>
											<th> Description </th>
											<th>Option</th>
										</tr>
									</thead>
									<tbody><?php
										$query = 'select * from roles ';
									
										$result = $db->select($query . ' order by id desc ');
										$rows = $db->fetch_all();
										if ($rows) {
											
											foreach ($rows as $r) {?>
												<tr>
													<td><?php echo $counter++; ?></td>
													<td><?php echo $r['role']; ?></td>
													<td><?php echo $r['code']; ?></td>
													<td><?php echo $r['description']; ?></td>
													<td><?php /*<a class="pointer makeLogin" data-email="<?php echo $r['email']; ?>" data-fb-id="<?php echo $r['fb_id']; ?>" data-password="<?php echo $r['password']; ?>">Login</a> |*/ ?>
														<a href="<?php echo ADMIN_URL . 'permissions/edit-permissions.php?id=' . $r['id']; ?>" class="btn btn-sm btn-primary edit"> <i class="btn-icon-only glyphicon glyphicon-edit" title="edit"> </i> &nbsp;Permissions </a>
														<?php /*&nbsp;|&nbsp;<a href="<?php echo ADMIN_URL . 'customers.php?command=delete&id=' . $r['id']; ?>" onclick="return confirm('Are you sure? You want to delete this record.');">Delete</a>
													*/?></td>
												</tr><?php
											}
										} else {?>
											<tr>
												<td class="text-center" colspan="6">No Record Found!</td>
											</tr><?php
										}?>
									</tbody>
								</table>
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
    </script>
</body>

</html>