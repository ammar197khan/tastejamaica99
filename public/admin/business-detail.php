<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);

$FILE_URL = '../outer_docx/';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$data_row = $db->fetch_array_by_query('select * from get_listed where id='.intval($_REQUEST['id']));
$multi_files = $db->fetch_array_by_query('select * from multi_files where detail_id='.intval($_REQUEST['id']));

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
					<h3 class="text-dark text-bold">Business Detail</h3>
					<!-- <div class="dash_text">
						<h5 class="text-dark">Dashboard / Administrators</h5>
					</div> -->
				</div>
				<div class="row px-4 pt-2 mt-4 main_row">
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Name Of Business</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['name']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Description Of Your Business</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['discription']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Type Of Business</label>
						</div>
						<?php $data_row['business_type'] = str_replace('_',' ', $data_row['business_type']); ?>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['business_type']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Do You Operate Remotely</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['remotely']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Do You Offer Services</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['delivery_services']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
								<label for="">Address</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['address']) ?></p>
						</div>
					</div>
					<?php $data_row['parish_type'] = str_replace('_',' ', $data_row['parish_type']); ?>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Parish</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['parish_type']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Phone No</label>
						</div>
						<div class="col-lg-9">
							<p><?= $data_row['phone_no'] ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Email Address</label>
						</div>
						<div class="col-lg-9">
							<p><?= $data_row['email'] ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Website</label>
						</div>
						<div class="col-lg-9">
							<p><?= $data_row['web_site'] ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Facebook</label>
						</div>
						<div class="col-lg-9">
							<p><?= $data_row['facebook'] ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Instagram</label>
						</div>
						<div class="col-lg-9">
							<p><?= $data_row['instagram'] ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Cuisines</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['cuisines']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Meal Type</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['meal']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-3">
							<label for="">Payment Method</label>
						</div>
						<div class="col-lg-9">
							<p><?= ucwords($data_row['payment_method']) ?></p>
						</div>
					</div>
					<div class="col-lg-12 d-flex">
						<div class="col-lg-4 d-flex">
							<div class="col-lg-8">
								<label for="">Public Health Certificate</label>
							</div>
							<div class="col-lg-4">
								<?php
								// echo 'here<br>';
								// print_r($data_row);
								if($data_row['health_certificate']!=''){
										$src = $FILE_URL.$data_row['health_certificate'];
										$extention = substr($data_row['health_certificate'], strpos($data_row['health_certificate'], ".") + 1);
										$file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
										if (in_array($extention, $file_formate)){
											$src = ADMIN_URL."80942.png";
								?>
									<a href="<?php echo $FILE_URL.$data_row['health_certificate'];?>" target="_blank">
										<img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src;?>" alt="health_certificate"  width="40" height="40">
									</a>
								<?php }else{?>
									<a href="<?= $FILE_URL.$data_row["health_certificate"];?>" target="_blank">
										<img style="width: 40px;height:40px;margin-bottom: 3px;" src="<?= $FILE_URL.$data_row["health_certificate"];?>"  alt="health_certificate">
									</a>
								<?php }}?>
							</div>
						</div>
						<div class="col-lg-4 d-flex">
							<div class="col-lg-8">
								<label for="">Food Handlers Certificate</label>
							</div>
							<div class="col-lg-4">
								<?php
								if(!empty($data_row['handlers_permit'])){
										$src = $FILE_URL.$data_row['handlers_permit'];
										$extention = substr($data_row['handlers_permit'], strpos($data_row['handlers_permit'], ".") + 1);
										$file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
										if (in_array($extention, $file_formate)){
											$src = ADMIN_URL."80942.png";
								?>
									<a href="<?php echo $FILE_URL.$data_row['handlers_permit'];?>" target="_blank">
										<img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src;?>" alt="handlers_permit"  width="40" height="40">
									</a>
								<?php }else{?>
									<a href="<?= $FILE_URL.$data_row["handlers_permit"];?>" target="_blank">
										<img style="width: 40px;height:40px;margin-bottom: 3px;" src="<?= $FILE_URL.$data_row["handlers_permit"];?>"  alt="handlers_permit">
									</a>
								<?php }}?>
							</div>
						</div>
					</div>
					<div class="col-lg-12" style="margin-top:30px">
						<div class="col-lg-6">
							<h4>Business Hours</h4>
							<table class="table">
								<thead>
									<tr>
										<th>Day</th>
										<th>Status</th>
										<th>Open Time</th>
										<th>Close Time</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$db->select('select * from business_hours where detail_id='.intval($_REQUEST['id']));
										$rows = $db->fetch_all();
										foreach($rows as $row){
									?>
										<tr>
											<?php 
											if($row['day']=='thuesday' || $row['day']==''){
												$row['day']='Tuesday';
											}
											?>
											<td><?= ucwords($row['day']) ?></td>
											<td><?= ucwords($row['status']) ?></td>
											<td>
											<?php $openTime = DateTime::createFromFormat('H:i', $row['open_time']); ?>	
											<?=  $openTime->format('h:i A'); ?></td>
											<td>
											<?php $closeTime = DateTime::createFromFormat('H:i', $row['close_time']); ?>	
												
											<?= $closeTime->format('h:i A'); ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-lg-12 d-flex" style="margin-top:30px;margin-bottom: 200px;">
						<div class="col-md-4">
							<div class="col-lg-4">
								<h4>photos</h4>
							</div>
							<div class="clearfix"></div>
							<div class="col-lg-12 d-flex">
								<?php
								// echo '<pre>';
								// print_r($multi_files);
								// die();
									$exp_multis = explode(',',$multi_files['files']);
									$count=1;
									$menu_link='';
									// echo '<pre>';
									// print_r($exp_multis);

									foreach($exp_multis as  $exp_multi){
										// if($count > 1){
										// 	continue;
										// }
										// $count++;

								?>
									<div class="col-lg-2">
										<?php
											if(!empty($exp_multi)){
												$src = $FILE_URL.$exp_multi;
												$extention = substr($exp_multi, strpos($exp_multi, ".") + 1);
												$file_formate = array('doc','docm','docx','xltx','xlsx','pdf');
												if (in_array($extention, $file_formate)){
													$src = ADMIN_URL."80942.png";
										?>
											<a href="<?php echo $FILE_URL.$exp_multi;?>" target="_blank">
												<img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src;?>" alt="handlers_permit"  width="40" height="40">
											</a>
										<?php }else{?>
											<a href="<?= BASE_URL.'outer_docx/'.$exp_multi;?>" target="_blank">
												<img style="width: 40px;height:40px;margin-bottom: 3px;" src="<?php echo  $FILE_URL.$exp_multi;?>"  alt="handlers_permit">
											</a>
										<?php }}?>
									</div>
								<?php } ?>
							
							</div>
						</div>
						<div class="col-md-4">
							<div class="col-lg-4">
								<h4>Menu</h4>
							</div>
							<div class="col-lg-12 d-flex">
							<a href="<?= $multi_files['link_to_menu'] ?> " target="_blank">
												<?= $multi_files['link_to_menu']; ?>
											</a>
							</div>
						</div>
					</div>
					<!-- <div class="col-lg-12 d-flex" style="margin-top:30px;margin-bottom: 200px;">
					<a class="btn btn-primary" href="<?php echo  BASE_URL.'signup_2.php?cmd=admin_auth&id='.$data_row['id'] ?>" target="_blank">Edit</a>
					</div> -->
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
		<script>
			// $("input").prop('required',true);
		</script>
	
</body>

</html>