<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);





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
			background-color: white;
			height: 50px;
		}

		.position_set {
			position: relative;
			top: -120px;
		}

		.select2-container--default .select2-results__option--highlighted[aria-selected] {
			background-color: #525f7f !important;
			color: white;
		}

		.select2-container .select2-selection--single {
			box-sizing: border-box;
			cursor: pointer;
			display: block;
			height: 32px !important;
			user-select: none;
			-webkit-user-select: none;
		}

		.select2-container--default .select2-selection--single {
			background-color: #fff;
			border: 1px solid #e9dddd !important;
			border-radius: 0px !important;
		}

		.select2-container {
			width: 100% !important;
		}

		.icon_dashboard {
			width: 80px;
			height: 80px;
			position: relative;
		}

		.icon_dashboard i {
			position: absolute;
			right: 34%;
			top: 33%;
			color: #fff;
			font-size: 25px;
		}

		.info-box-text {
			font-size: 16px;
			font-weight: 600;
			color: #8898aa;
		}

		.info-text-color1 {
			background-color: #11cdef;
		}

		.info-text-color2 {
			background-color: #2dce89;
		}

		.info-text-color3 {
			background-color: #ffad46;
		}

		.info-text-color4 {
			background-color: #f5365c;
		}

		.info-box-number {
			font-size: 20px;
			font-weight: 600;
			color: #525f7f;
		}

		.exp_card {
			padding: 15px;
			background-color: #fff;
			border-top: 3px solid #f39c12;
			border-radius: 6px;
		}

		.btn_add {
			background-color: #1367d1;
			color: #fff;
			border-color: #1367d1;
		}

		.border_th>th {
			color: #525f7f;
			font-size: 18px;
		}

		.td_colour>td {
			color: #525f7f;
			font-size: 17px;
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

		.btn_default {
			background-color: #f4f4f4;
			color: #444;
			border: 1px solid #ddd;
			font-size: 12px;
		}

		.text-yellow {
			color: #f39c12;
		}

		.sale_pay {
			color: #21243d;
			font-size: 20px;
		}

		.sale_pay_order {
			font-size: 18px;
			font-weight: 600;
		}

		.shipment_ul>li>a {
			color: #777;
		}

		.shipment_ul>li>a:hover {
			color: #fff;
			text-decoration: none;
		}

		.shiping_status {
			color: #fff;
			background-color: #ffad46;
			border: 1px solid #ffad46;
			border-radius: 5px;
		}

		.shiping_status: hover {
			color: #fff;
			text-decoration: none;
		}

		.paid_status {
			color: #fff;
			background-color: #98d973;
			border: 1px solid #98d973;
			border-radius: 5px;
		}

		.paid_status:hover {
			color: #fff;
			text-decoration: none;
		}

		.total_visters {
			display: flex;
		}

		.bg-primary {
			background-color: #ffffff !important;
		}

		.block {
			color: white;
			width: 40px;
			position: absolute;
			top: -15px;
			right: -10px;
			text-align: center;
			background: #3f51b5;
			border-radius: 46%;
			bottom: 39px;
			padding-top: 8px;
			height: 40px;
			font-weight: 600;
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

				<!-- Container Fluid-->
				<div class="dashboard_head px-4 pt-2">
					<h4 class="h4 text-dark">Welcome <?php echo $auth_row['name'] ?>,</h4>
				
				</div>
				<!-- Footer -->
				<?php include('includes/footer.php') ?>
				<!-- Footer -->
			</div>
		</div>

		<!-- Scroll to top -->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

		<?php include('includes/commonjs.php') ?>
	
</body>

</html>