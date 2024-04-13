<!DOCTYPE html>
<html lang="en">

<head>
<?php include('../includes/site-master.php') ?>
<style type="text/css">
 	body {font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;}
 	#wrapper #content-wrapper {background-color: #f8f9fe;}
	.exp_card {padding: 5px 10px;background-color: #fff;box-shadow: 0 0 2rem 0 rgba(136,152,170,.15)!important;}
	.text-gray-800 span {font-size: 16px;}
	.text-right {text-align: right;}
	.text-gray-800 {color: #32325d !important;}
	.Total_payments {background-color: #f5365c;}
	.color_white_icon {color: #fff;font-size: 6px;}
	.color_white {color: #fff;font-size: 17px;}
	.color_white: hover {color: #fff;text-decoration-color: #fff;}
	.nav-tabs .nav-link {border-top-left-radius: .0rem !important;border-top-right-radius: .0rem !important;}
	.tabs_a {font-size: 20px;font-weight: 700; color: #444444;}
	.tabs_a:hover{color: #444444;}
	input[type=text]:focus {border-color: #d2d6de !important;}
	.box_shadow {box-shadow:  0 0px 0px 0 rgba(0, 0, 0, 0.2), 0 0px 2px 0 rgba(0, 0, 0, 0.19);}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {color: #000000;}
	.nav-tabs {border-bottom: 0px solid #dddfeb !important; }
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {border-top: 3px solid #3c8dbc !important;}
	.nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {border-color: #3c8dbc;}
	.nav-tabs .nav-link:focus, .nav-tabs .nav-link {border-color: #fff #fff #fff !important;}
	.border_th>th{color: #525f7f;font-weight: 700;font-size: 16px;}
	.btn_default {    background-color: #f4f4f4;color: #444;border: 1px solid #ddd;font-size: 12px;}
	.label_modal_set {color: #525f7f;font-weight: 700;font-size: 18px;}
	.page-item.active .page-link {z-index: 1;color: #fff;background-color: #337ab7;border-color: #337ab7;}
	.dataTables_info {color: #525f7f !important;}
	.height_cntrl {height: 35px;}
	.btn-modal {padding: 3px 7px !important;font-size: 12px}
	 @media (min-width: 0px) and (max-width: 575.98px) {
	 	.text-right {text-align: center !important;}
	 }

	// Small devices (landscape phones, 576px and up)
	@media (min-width: 576px) and (max-width: 767.98px) {
		.text-right {text-align: center;}
	}

	// Medium devices (tablets, 768px and up) 
	@media (min-width: 768px) and (max-width: 991.98px) {
		.text-right {text-align: center;}
	}

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
        <div class="container-fluid mb-5" id="container-wrapper">
        	
            <form class="" action="" method="post">
                <div class="exp_card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                          <a class="nav-link active tabs_a" href="#account"><span class="px-3"><i class="fa-solid fa-file-invoice"></i></span>Accounts</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link tabs_a" href="#accounttype"><span class="px-3"><i class="fa-solid fa-file-invoice"></i></span>Account Type</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="account" class="tab-pane active"><br>
                          	<div class="p-4 mb-5 box_shadow">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group pr-3 mb-0">
                                            <select class="form-control form-control-sm" name="show_activity">
                                                <option value="active">Active</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-12 text-right mt-sm-0 mt-3">
                                       <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#accountexpense"id="#accountexpense">
                                       		<span style="padding-right: 5px;color: #fff;"><i class="fa-solid fa-plus"></i></span>Add
                                       	</button>
                                    </div>
                                </div>
                          	</div>
                            <div class="d-flex justify-content-center  mb-3 pt-3">
							    <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to CV</div>
							    <div class="p-2 btn_default"><i class="fa-solid fa-file-excel px-2"></i>Export to Excel</div>
							    <div class="p-2 btn_default"><i class="fa-solid fa-print px-2"></i>Print</div>
							    <div class="p-2 btn_default"><i class="fa fa-columns px-2" aria-hidden="true"></i>Coloumn Visibility</div>
							    <div class="p-2 btn_default"><i class="fa-solid fa-file-pdf px-2"></i>Export to Pdf</div>
						  	</div>
                          	<div class="table-responsive p-3">
		                        <table class="table align-items-center table-bordered account_table" id="dataTable">
		                            <thead class="">
		                                <tr class="border_th">
		                                  	<th>Name</th>
		                                  	<th>Account Type</th>
		                                  	<th>Account Sub Type</th>
		                                  	<th>Account Number</th>
		                                  	<th>Note</th>
		                                  	<th>Balance</th>
		                                  	<th>Accounts Detail</th>
		                                  	<th>Added By</th>
		                                  	<th>Action</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <tr>
			                                <td>Michael Bruce</td>
			                                <td>Javascript Developer</td>
			                                <td>Singapore</td>
			                                <td>29</td>
			                                <td>2011/06/27</td>
			                                <td>$183,000</td>
			                                <td>Javascript Developer</td>
			                                <td>Singapore</td>
		                                  	<td>
			                                  	<button data-href="" data-container="" class="btn btn-xs btn-primary btn-modal">
			                                  		<i class="glyphicon glyphicon-edit"></i> Edit
			                                  	</button>
                                				<a href="" class="btn btn-warning btn-xs btn-modal">
                                					<i class="fa fa-book"></i> Account Book
                                				</a>&nbsp;
                                                <button data-href="" class="btn btn-xs btn-info btn-modal" data-container=""><i class="fa fa-exchange"></i> Fund Transfer</button>
                                				<button data-href="" class="btn btn-xs btn-success btn-modal" data-container=""><i class="fas fa-money-bill-alt"></i> Deposit</button>
                                				<button data-url="" class="btn btn-xs btn-danger close_account btn-modal"><i class="fa fa-power-off"></i> Close</button>
                            				</td>
		                                </tr>
		                                <tr>
		                                  	<td>Michael Bruce</td>
		                                  	<td>Javascript Developer</td>
		                                  	<td>Singapore</td>
		                                  	<td>29</td>
		                                  	<td>2011/06/27</td>
		                                  	<td>$183,000</td>
		                                   	<td>Javascript Developer</td>
		                                  	<td>Singapore</td>
		                                  	<td>
			                                  	<button data-href="" data-container="" class="btn btn-xs btn-primary btn-modal">
			                                  		<i class="glyphicon glyphicon-edit"></i> Edit
			                                  	</button>
                                				<a href="" class="btn btn-warning btn-xs btn-modal">
                                					<i class="fa fa-book"></i> Account Book
                                				</a>&nbsp;
                                                <button data-href="" class="btn btn-xs btn-info btn-modal" data-container=""><i class="fa fa-exchange"></i> Fund Transfer</button>
                                				<button data-href="" class="btn btn-xs btn-success btn-modal" data-container=""><i class="fas fa-money-bill-alt"></i> Deposit</button>
                                				<button data-url="" class="btn btn-xs btn-danger close_account btn-modal"><i class="fa fa-power-off"></i> Close</button>
                            				</td>
		                                </tr>
		                            </tbody>
		                       	</table>
		                    </div>
                        </div>
                        <div id="accounttype" class="px-3 tab-pane fade"><br>
                        	<div style="text-align: right">
                        		<button type="button" class="btn btn-primary btn-sm mb-3" style="color: #fff;" data-toggle="modal" data-target="#acctypemodal" id="#acctypemodal">
                					<span style="padding-right: 5px;"><i class="fa-solid fa-plus"></i></span>Add
                				</button>
                        	</div>
                          	<table class="table table-hover table-bordered">
							    <thead>
							      	<tr>
							        	<th class="label_modal_set">Name</th>
							        	<th class="label_modal_set">Action</th>
							      	</tr>
							    </thead>
							    <tbody>

							    </tbody>
							</table>
                        </div>
                    </div>
                </div>  
            </form>            
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
     <?php include('../includes/footer.php') ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php include('../includes/commonjs.php') ?>
<script type="text/javascript">
    $(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
});
     
</script>
</body>

</html>