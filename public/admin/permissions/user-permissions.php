<?php
	include("includes/common-files.php");
	$a->authenticate();
	
	if(isset($_REQUEST['id']) && intval($_REQUEST['id'])>0){
		$id = intval($_REQUEST['id']);
		$admin_row = $db->fetch_array_by_query("select * from admin where id=".$id);
		$permissions= json_decode($admin_row['reports_permissions'],true);
		//print_r($permissions); 
	}
	if(isset($_REQUEST['command']) && $_REQUEST['command']=='permissions' ){
		$db->select("select * from ledger where under_group=".intval($_REQUEST['group']));
		$ledgers = $db->fetch_all();
		//$html.="<option value='0'>Select All Ledgers</option>";
		foreach($ledgers as $ledger){
			$html.="<option value='".$ledger['id']."'>".$ledger['name']."</option>";
		}
		echo json_encode(array("html"=>$html));
		exit();
	}
	if(isset($_REQUEST['command']) && $_REQUEST['command']=='update-permission'){
		$id = $_REQUEST['id'];
		unset($_REQUEST['id']);
		unset($_REQUEST['command']);
		$json_array['reports_permissions'] = json_encode($_REQUEST);
		
		$result = $db->update($id,$json_array,"admin");
		if($result){
			$obj_msg = load_class('InfoMessages');
			$obj_msg->setMessage('Added Successfully!');
			redirect_header(ADMIN_URL.'user-permissions.php?id='.$id);	
		}else{
			$obj_msg = load_class('InfoMessages');
			$obj_imsg->setMessage('Error Occur. Please try again later.', 'error');
			redirect_header(ADMIN_URL.'user-permissions.php?id='.$id);
		}
		
		

	}

	$page_title = " Permission Accounts ";
?>
<!DOCTYPE html>
<html>
<head>
<?php include("includes/common-header.php"); ?>
<link href="<?php echo BASE_URL.'js/sumoselect.min.css' ?>" rel="stylesheet" type="text/css" />
<link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet">
<style type="text/css">
	.ms-parent ul li label span{
		margin-left: 10px;
	}
.pointer { cursor: pointer; }
.tab-bt{
	padding: 8px 14px !important;
}
.custom-drop {
    font-size: 16px;
    background-color: #00a65a;
    color: #fff;
}

@media only screen and (max-width:480px) {
	button.databt { width: 100%; display:block; }
}
</style>
</head>
<body class="skin-green-light sidebar-mini">
<div class="wrapper">
	<?php include("includes/header.php");?>
	<div class="content-wrapper">
		<section class="content-header">
			<h1> <?php echo $page_title;?> </h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo ADMIN_URL;?>"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><?php echo $page_title;?></li>
			</ol>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-lg-12">
					<div class="row clearfix">
						<div class="span12"> <?php echo $imsg->getMessage();?> </div>
					</div>
					<form method="post" enctype="multipart/form-data" id='form1' name="frm">
						<input type="hidden" name="id" value="<?php echo intval($_REQUEST['id']) ?>">
						<input type="hidden" name="command" value="update-permission">
						<div class="box box-danger">
							<div class="box-header">
								<h3 class="box-title pull-left"><?php echo $page_title;?></h3>
								<a onclick="goBack()" class="btn btn-default pull-right">Go Back</a>
							</div>
							<?php 
									$db->select("select * from ledger_group where parent_id=1 and ledger_type='sub_group'");
									$asset_groups = $db->fetch_all();
									$db->select("select * from ledger_group where parent_id=2 and ledger_type='sub_group'");
									$liab_groups = $db->fetch_all();
									$db->select("select * from ledger_group where parent_id=3 and ledger_type='sub_group'");
									$income_groups = $db->fetch_all();
									$db->select("select * from ledger_group where parent_id=4 and ledger_type='sub_group'");
									$expense_groups = $db->fetch_all();


								?>
							<div class="box-body">
								<div class="row clone-div" style="margin-bottom:6px">
									<?php
										if(isset($permissions['ledgerGroup']) && count($permissions['ledgerGroup'])>0){ 
										foreach($permissions['ledgerGroup'] as $index =>$permission){  ?>
												<div class="col-sm-12 clone">
													<div class="col-md-3 col-xs-12">
															<div class="form-group">
																<label> Nature: </label>
																<select name="nature" class="form-control">
																	<?php

																		$db->select("SELECT * FROM `nature_groups`");
																		$natures = $db->fetch_all();

																		foreach($natures as $nature){
																	?>
																			<option value="<?php echo $nature['id']?>"><?php echo $nature['name']?></option>
																	<?php 		
																		} 
																	?>
																	
																</select>
															</div>

													</div>			

																
												<div class="col-md-3 col-xs-12 under_g">
														<div class="form-group">
															<label> UnderGroup: </label>
															
															<select name="ledgerGroup[]" class="form-control" onclick="getGroupLedger(this)">
																<option value="all"<?php if('all'==$permission){ ?> selected<?php } ?>>All Groups</option>
																<option value="" disabled class="custom-drop"><h3 class="custom_drop">Assets</h3></option>
																<?php foreach($asset_groups as $nature_group){
																	$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																	$sub_groups = $db->fetch_all();
																	foreach($sub_groups as $sub_g){
																		//echo $sub_g['id']."==".$permission;
																		//echo $permission;
																	?>
																	<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){ ?> selected<?php } ?>><?php echo $sub_g['name'] ?></option>
																	<?php }  ?>
																	<option value="<?php echo $nature_group['id']?>" <?php if($nature_group['id']==$permission){ ?> selected <?php } ?>> <?php echo $nature_group['name']?> </option>
																<?php } ?>
																<option value="" disabled class="custom-drop"><h3 class="custom_drop">Liabilities</h3></option>
																<?php foreach($liab_groups as $nature_group){ ?>
																	<?php $db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																		$sub_groups = $db->fetch_all();
																		foreach($sub_groups as $sub_g){?>
																		<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected<?php } ?>><?php echo $sub_g['name']  ?></option>
																	<?php }  ?>
																		<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
																<?php } ?>
																		<option value="" disabled class="custom-drop"><h3 class="custom_drop">Income</h3></option>
																<?php foreach($income_groups as $nature_group){ ?>
																	<?php
																		$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																		$sub_groups = $db->fetch_all();
																		foreach($sub_groups as $sub_g){?>
																			<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $sub_g['name']  ?></option>
																			<?php 
																		}?>
																		<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
																<?php } ?>
																<option value="" disabled class="custom-drop"><h3 class="custom_drop">Expense</h3></option>
																<?php 
																	foreach($expense_groups as $nature_group){  
																		$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																		$sub_groups = $db->fetch_all();
																		foreach($sub_groups as $sub_g){?>
																			<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $sub_g['name']  ?></option>
																<?php 
																		} 
																?>
																		<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
																<?php 
																	} 
																?>
															</select>
														</div>
												</div>
												<div class="col-md-3 col-sm-12 col-xs-12 ledger">
													<label>Ledger:</label>
													<select name="ledger<?php echo $index?>[]"   multiple="multiple" class="multiple_ledger ledgers" multiple="">

														<?php
															//echo "select * from ledgers where id in (".implode(",",$permissions['ledger'.$index]).")";

															if(isset($permissions['ledger'.$index])){
																$db->select("select * from ledger where id in (".implode(",",$permissions['ledger'.$index]).")");
																$ledgers_p = $db->fetch_all();	
															}else{
																$ledgers_p = array();
															}
															 
															foreach($ledgers_p as $per_ledger){ ?>
																	<option value="<?php echo $per_ledger['id']?>" selected><?php echo $per_ledger['name']; ?></option>
															}
														<?php } ?>
														<?php
															//echo "select * from ledgers where id in (".implode(",",$permissions['ledger'.$index]).")";
														if(isset($permissions['ledger'.$index])){

															$db->select("select * from ledger where id not in (".implode(",",$permissions['ledger'.$index]).") and under_group=".$permission);
															$ledgers_p = $db->fetch_all(); 
														}else{
															$ledgers_p = array();
														}	
															foreach($ledgers_p as $per_ledger){ ?>
																	<option value="<?php echo $per_ledger['id']?>" ><?php echo $per_ledger['name']; ?></option>
														<?php } ?>




													</select>
													

												</div>
										
										<div class="col-md-3 col-sm-12 col-xs-12 permission">
											<label>Permissions:</label><br>
											<input type="radio"  id="allowed" name="allow<?php echo $index?>" value="allow" <?php if($permissions['allow'.$index]=='allow'){ ?> checked <?php } ?>>
											<label for="allowed">Allow</label>
											<input type="radio" id="not_allow" name="allow<?php echo $index?>" value="not_allow" <?php if($permissions['allow'.$index]=='not_allow'){ ?> checked <?php } ?>>
											<label for="female">Not Allow</label><br>
										</div>
										<div class="col-md-3 col-sm-12 col-xs-12">
											<button onclick="cloneRow()" type="button">+</button>
											<button type="button" onclick="removeRow(this)">-</button>
										</div>
										
										
										
									</div>
									<?php }

									}else{ ?>
										
									
										<div class="col-sm-12 clone">
											<div class="col-md-3 col-sm-12 col-xs-12">
												<?php 
													$db->select('SELECT * FROM `nature_groups`');
													$nature_groups = $db->fetch_all();
												?>
												<label>Nature:</label>
												<select name="ledger[]"    class="form-control" >
													<?php
														foreach($nature_groups as $ntg){ ?>
																<option value="<?php echo $ntg['id']?>" selected><?php echo $ntg['name']; ?></option>
														
													<?php }  ?>
													




												</select>
											

											</div>
										<div class="col-md-3 col-xs-12 under_g">
												<div class="form-group">
													<label> UnderGroup: </label>
													
													<select name="ledgerGroup[]" class="form-control" onclick="getGroupLedger(this)">
														<option value="001">All Groups</option>
														<option value="" disabled class="custom-drop"><h3 class="custom_drop">Assets</h3></option>
														<?php foreach($asset_groups as $nature_group){
															$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
															$sub_groups = $db->fetch_all();
															foreach($sub_groups as $sub_g){
																//echo $sub_g['id']."==".$permission;
															?>
															<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){ ?> selected<?php } ?>><?php echo $sub_g['name'] ?></option>
															<?php }  ?>
															<option value="<?php echo $nature_group['id']?>" <?php if($nature_group['id']==$permission){ ?> selected <?php } ?>> <?php echo $nature_group['name']?> </option>
														<?php } ?>
														<option value="" disabled class="custom-drop"><h3 class="custom_drop">Liabilities</h3></option>
														<?php foreach($liab_groups as $nature_group){ ?>
															<?php $db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																$sub_groups = $db->fetch_all();
																foreach($sub_groups as $sub_g){?>
																<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected<?php } ?>><?php echo $sub_g['name']  ?></option>
															<?php }  ?>
																<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
														<?php } ?>
																<option value="" disabled class="custom-drop"><h3 class="custom_drop">Income</h3></option>
														<?php foreach($income_groups as $nature_group){ ?>
															<?php
																$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																$sub_groups = $db->fetch_all();
																foreach($sub_groups as $sub_g){?>
																	<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $sub_g['name']  ?></option>
																	<?php 
																}?>
																<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
														<?php } ?>
														<option value="" disabled class="custom-drop"><h3 class="custom_drop">Expense</h3></option>
														<?php 
															foreach($expense_groups as $nature_group){  
																$db->select("select * from ledger_group where parent_id=".$nature_group['id']." and ledger_type='ledger_group'");
																$sub_groups = $db->fetch_all();
																foreach($sub_groups as $sub_g){?>
																	<option value="<?php echo $sub_g['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $sub_g['name']  ?></option>
														<?php 
																} 
														?>
																<option value="<?php echo $nature_group['id']?>" <?php if($sub_g['id']==$permission){?> selected <?php } ?>><?php echo $nature_group['name']?></option>
														<?php 
															} 
														?>
													</select>
												</div>
											</div>
											
										<div class="col-md-3 col-sm-12 col-xs-12 ledger">
											<?php  if(!isset($index) && $index==''){ $index=0; }?>	
											<label>Ledger:</label>
											<select name="ledger<?php echo $index?>[]"   multiple="multiple" class="multiple_ledger ledgers" multiple="">
												<?php
													//echo "select * from ledgers where id in (".implode(",",$permissions['ledger'.$index]).")";
													if(isset($permissions['ledger'.$index])){
														$db->select("select * from ledger where id in (".implode(",",$permissions['ledger'.$index]).")");
														$ledgers_p = $db->fetch_all();	
													}else{
														$ledgers_p = array();
													}
													 
													foreach($ledgers_p as $per_ledger){ ?>
															<option value="<?php echo $per_ledger['id']?>" selected><?php echo $per_ledger['name']; ?></option>
													}
												<?php } ?>
												<?php
													//echo "select * from ledgers where id in (".implode(",",$permissions['ledger'.$index]).")";
												if(isset($permissions['ledger'.$index])){
													$db->select("select * from ledger where id not in (".implode(",",$permissions['ledger'.$index]).") and under_group=".$permission);
													$ledgers_p = $db->fetch_all();	
												}else{
													$ledgers_p = array();
												}
													 
													foreach($ledgers_p as $per_ledger){ ?>
															<option value="<?php echo $per_ledger['id']?>" ><?php echo $per_ledger['name']; ?></option>
												<?php } ?>




											</select>
											

										</div>
										
										<div class="col-md-3 col-sm-12 col-xs-12 permission">
											<label>Permissions:</label><br>
											<input type="radio" id="allowed" name="allow<?php echo $index?>" value="allow" <?php if($permissions['allow'.$index]=='allow'){ ?> checked <?php } ?>>
											<label for="allowed">Allow</label>
											<input type="radio" id="not_allow" name="allow<?php echo $index?>" value="not_allow" <?php if($permissions['allow'.$index]=='not_allow'){ ?> checked <?php } ?>>
											<label for="female">Not Allow</label><br>
										</div>
										<div class="col-md-3 col-sm-12 col-xs-12">
											<button onclick="cloneRow()" type="button">+</button>
											<button type="button" onclick="removeRow(this)">-</button>
										</div>
										
										
										
										</div>
									<?php } ?>	
									
								</div>
							</div>
						</div>
						<button type="submit">Update Permission</button>
					</form>
				</div>
			</div>
		</section>
	</div>
	<?php include("includes/footer.php");?>
	<div class='control-sidebar-bg'></div>
</div>
<?php include("includes/footer-jsfiles.php");?>
<script src='<?php echo BASE_URL."js/jquery.sumoselect.min.js"?>'></script>
<script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>
<script type="text/javascript">
	$('.select2').SumoSelect({ selectAll: true });
	var $select = $('.multiple_ledger');
	function getGroupLedger(val_this){
		 $.ajax({
		 	url: 'user-permissions.php',
		 	type: 'POST',
		 	data: {group: $(val_this).val(),command:"permissions"},
		 })
		 .done(function(response) {
		 	response = jQuery.parseJSON(response);
		 	 $(val_this).parent().parent().parent().find(".ledgers").multipleSelect('destroy');
		 	$(val_this).parent().parent().parent().find(".ledgers").html(response.html);
		 	 $(val_this).parent().parent().parent().find(".ledgers").multipleSelect({width:'100%'});
		 })
		 .fail(function() {
		 	console.log("error");
		 })
		 .always(function() {
		 	console.log("complete");
		 });

	}
	<?php if(isset($permissions['ledgerGroup']) && count($permissions['ledgerGroup'])>0){ ?>
			i=<?php echo count($permissions['ledgerGroup'])-1 ?>;
	<?php }else{ ?>
			i=0;
	<?php } ?>	
	function cloneRow(){
		i++;
		
		$(".clone-div").append($(".clone-div:first").clone());
		$(".clone:last").find("#allowed").attr("name",'allow'+i);
		$(".clone:last").find("#not_allow").attr("name",'allow'+i);
		$(".clone:last").find(".multiple_ledger").attr("name",'ledger'+i+'[]');
		$(".clone:last").find(".multiple_ledger").multipleSelect('destroy');
		$(".clone:last").find(".multiple_ledger").multipleSelect({width:'100%'});
		//$(".multiple_ledger").multipleSelect({width:'100%'});
	}

	function removeRow(val_this){
		i--;
		$(val_this).parent().remove();
	}

	$(function() {
		$select.multipleSelect();
	});

</script>
</body>
</html>
