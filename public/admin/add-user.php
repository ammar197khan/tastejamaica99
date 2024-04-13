<?php
include 'includes/common-files.php';
$a->authenticate();
$auth_row = $a->auth_row($db);
$ledger_class = load_class('Ledger');


if(isset($_POST['command']) && $_POST['command']=='submit'){
    // echo '<pre>';
    // print_r($_POST);
    // die();
    $_POST['date_birth']=$_POST['date_ledger'];
    $_POST['mob_no']=$_POST['mobile_number'];
    $_POST['contact_type']='simple';
    $ledger_res=$ledger_class->addRecord($_POST);
    if($ledger_res){
    $arr=array();
    $arr['name']=$_POST['first_name'].' '.$_POST['last_name'];
    $arr['email']=$_POST['email'];
    $arr['allow_login']=$_POST['allow_login'];
    $arr['ip']=$_SERVER['REMOTE_ADDR'];
    $arr['last_visit']=time();
    $arr['ledger_id']=$ledger_res;
    $arr['role_id']=$_POST['role'];
    $arr['head_id']=implode(',',$_POST['locs']);
    if($_POST['allow_login']=='yes'){
        if($_POST['user_name']!=''){
            $arr['username']=$_POST['user_name'];
        }else{
            $arr['username']=$_POST['first_name'];
        }

        if($_POST['password']!=''){
            $arr['password']=md5($_POST['password']);
            $arr['hint']=$_POST['password'];
        }else{
            $rand=rand(000000,999999);
            $arr['password']=md5($rand);
            $arr['hint']=$rand;
        }
    }
    $arr['created_at']=time();
    $arr['updated_at']=time();
    $res=$db->insert($arr,'admin');
   
    if($res){
        $user_detail=array();
        $user_detail['blood_group']=$_POST['blood_group'];
        $user_detail['contact']=$_POST['mobile_number'];
        $user_detail['alternative_contact']=$_POST['alter_number'];
        $user_detail['family_contact']=$_POST['family_contact_number'];
        $user_detail['fb_link']=$_POST['facebook_link'];
        $user_detail['twitter_link']=$_POST['twitter_link'];
        $user_detail['gardian_name']=$_POST['guardian_name'];
        $user_detail['id_proof_name']=$_POST['id_proof_name'];
        $user_detail['id_proof_number']=$_POST['id_proof_number'];
        $user_detail['permanant_address']=$_POST['permanent_address'];
        $user_detail['current_address']=$_POST['current_address'];
        $user_detail['account_holder_name']=$_POST['account_holder_name'];
        $user_detail['account_number']=$_POST['account_number'];
        $user_detail['bank_name']=$_POST['bank_name'];
        $user_detail['bank_id_code']=$_POST['bank_identifer_code'];
        $user_detail['branch_id']=$_POST['bank_branch'];
        $user_detail['tax_payer_id']=$_POST['tax_payer_id'];
        $user_detail['created_at']=time();
        $user_detail['updated_at']=time();
        $user_detail['user_id']=intval($res);
        $detail_result=$db->insert($user_detail,'user_detail');
        if($detail_result){
            $imsg->setMessage("Successfully");
        }else{
        $imsg->setMessage("error","Error while making Ledger");
        }
    }else{
        $imsg->setMessage("error","Error while making user");
    }
}
    redirect_header('user.php');

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
            background-color: #f8f9fe !important;
        }

        .manage_user {
            color: #777;
        }

        .text_sup {
            color: #32325d;
            font-size: 22px;
            font-weight: 600;
        }

        .exp_card {
            background-color: #fff;
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
            font-weight: 600;
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

        .form_height {
            height: 34px !important;
        }

        .date_tax_app {
            height: 34px;
            background-color: #eee;
            opacity: 1;
        }

        .all_supp {
            font-size: 17px;
            font-weight: 600;
            color: #32325d;
            letter-spacing: 1px;
        }

        .span_checkbox {
            padding-left: 11px;
            margin-top: 35px;
            position: absolute;
            font-size: 15px;
            font-weight: 600;
            color: #525f7f;
        }

        .input_checkbox {
            width: 20px;
            height: 20px;
            margin-top: 19px;
        }

        .span_checkbox1 {
            padding-left: 11px;
            margin-top: 25px;
            position: absolute;
            font-size: 15px;
            font-weight: 600;
            color: #525f7f;
        }

        .input_checkbox1 {
            width: 20px;
            height: 20px;
        }

        .span_checkbox2 {
            padding-left: 11px;
            margin-top: 21px;
            position: absolute;
            font-size: 15px;
            font-weight: 400;
            color: #525f7f;
            letter-spacing: 1px;
        }

        .input_checkbox2 {
            width: 20px;
            height: 20px;
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

        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #433c3c;
        }

        .submit_user_button {
            font-size: 20px;
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
                <div class="container-fluid" id="container-wrapper">
                    <form action="" method="post">
                        <h1 class="h3 mb-0 text_sup mb-3">Add User</h1>
                        <div class="exp_card card px-4 py-4 mb-4">
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Prefix:</label>
                                        <input type="text" class="form-control form_height" name="prefix" id="" placeholder="Mr.Mrs">
                                       
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">First Name:</label>
                                        <input type="text" class="form-control form_height" name="first_name" id="" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Last Name:</label>
                                        <input type="text" class="form-control form_height" name="last_name" id="" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Email:</label>
                                        <input type="text" class="form-control form_height" name="email" id="" placeholder="Email Name">
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12 col-12 mb-md-0 mb-sm-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="active" class="form-check-input input_checkbox" value="yes" checked="checked">
                                        </label>
                                        <span class="span_checkbox">Is Active</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="exp_card card px-4 py-4 mb-4">
                            <p class="label_all mb-4">Roll And Permissions</p>
                            <div class="row">
                                <div class="col-md-12 col-12 mb-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input input_checkbox1 business_check" name="allow_login" value="yes" checked="checked">
                                        </label>
                                        <span class="span_checkbox1">Allow Login</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12 ">
                                    <div class="form-group mb-1">
                                        <label for="exampleInputEmail1" class="label_all">User name:</label>
                                        <input type="text" class="form-control form_height" name="user_name" id="" placeholder="Admin">
                                    </div>
                                    <span class="help-block" style="color: #777;">Leave blank to auto generate username</span>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12 ">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Password:</label>
                                        <input type="password" class="form-control form_height" name="password" id="" placeholder="00000000">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Confirm Password:</label>
                                        <input type="text" class="form-control form_height" name="confirm_password" id="" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12 col-12 mt-3 mb-3">
                                    <div class="form-group">
                                        <label for="select2Single" class="label_all">Role:*</label>
                                        <select class="choosen-index form-control" name="role" id="">
                                            <option value="0">Admin</option>
                                            <?php 
                                            $db->select('select * from roles order by id desc');
                                            $roles=$db->fetch_all();
                                            foreach($roles as $role){
                                            ?>
                                            <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7 col-12"></div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <h4 class="label_all">Access locations <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Choose all locations this role can access. All data for the selected location will only be displayed to the user.<br/><br/><small>For Example: You can use this to define <i>Store Manager / Cashier / Stock manager / Branch Manager, </i>of particular Location.</small>" data-html="true" data-trigger="hover"></i></h4>
                                </div>
                                <div class="col-md-6 col-sm-12 col-12">
                                <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input input_checkbox2" name="locs[]" value="0" checked >
                                        </label>
                                        <span class="span_checkbox2">All Locations</span>
                                    </div>
                                    <?php 
                                    $db->select('select * from business_locations order by id desc');
                                    $locations=$db->fetch_all();
                                    foreach($locations as $location){
                                    ?>
                                    <div class="form-check mb-3">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input input_checkbox2" name="locs[]" value="<?= $location['id']; ?>" >
                                        </label>
                                        <span class="span_checkbox2"><?= $location['name'] ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="exp_card card px-4 py-4 mb-4 d-none">
                            <p class="label_all mb-4">Sales</p>
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Sales Commission Percentage (%):</label>
                                        <input type="text" class="form-control form_height" name="sale_commission" id="" placeholder="Sale Commission">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Max sales discount percent:</label>
                                        <input type="text" class="form-control form_height" name="sale_discount" id="" placeholder="Sale Discount">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-12"></div>
                                <div class="col-md-4 col-sm-12 col-12 mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input input_checkbox1" value="">
                                        </label>
                                        <span class="span_checkbox1"> Allow Selected Contacts <span><i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Only allow access to selected contacts in sells/purchase customer/supplier search box" data-html="true" data-trigger="hover"></i></span></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="exp_card card px-4 py-4 mb-4">
                            <p class="mb-4 label_all">More Information</p>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group" id="simple-date1">
                                        <label for="simpleDataInput" class="label_all">Date Of Birth:*</label>
                                        <input type="text" name="date_ledger" class="form-control date_tax_app" value="01/06/2020" id="simpleDataInput">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="select2Single" class="label_all">Gender:*</label>
                                        <select class=" form-control form_height" name="gender" id="">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="select2Single" class="label_all">Martial Status:*</label>
                                        <select class=" form-control form_height" name="martial_status" id="">
                                            <option value="married">Married</option>
                                            <option value="unmarrried">Unmarried</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6  col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Blood Group</label>
                                        <input type="text" class="form-control form_height" name="blood_group" id="" placeholder="Bolood Group">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Mobile Number:</label>
                                        <input type="text" class="form-control form_height" name="mobile_number" id="" placeholder="Mobile Number">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Alter Native Contact:</label>
                                        <input type="text" class="form-control form_height" name="alter_number" id="" placeholder="Alter Number">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Family Contact Number:</label>
                                        <input type="text" class="form-control form_height" name="family_contact_number" id="" placeholder="Family Number">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Facebook Link:</label>
                                        <input type="text" class="form-control form_height" name="facebook_link" id="" placeholder="Facebook Link">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Twitter:</label>
                                        <input type="text" class="form-control form_height" name="twitter_link" id="" placeholder="Twitter">
                                    </div>
                                </div>
                           
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Guardian Name:</label>
                                        <input type="text" class="form-control form_height" name="guardian_name" id="" placeholder="Guardian Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">ID Proof Name:</label>
                                        <input type="text" class="form-control form_height" name="id_proof_name" id="" placeholder="ID Proof Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">ID Proof Number:</label>
                                        <input type="number" class="form-control form_height" name="id_proof_number" id="" placeholder="ID Proof Number">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 ">
                                    <div class="form-group ">
                                        <label for="permanent_address" class="label_all">Permanent Address:</label>
                                        <textarea class="form-control" placeholder="Permanent Address" rows="4" name="permanent_address" cols="50" id=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="permanent_address" class="label_all">Current Address:</label>
                                        <textarea class="form-control" placeholder="Current Address" rows="4" name="current_address" cols="50" id=""></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <hr>
                                    <h4 class="label_all">Bank Details:</h4>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Account Holder's Name:</label>
                                        <input type="text" class="form-control form_height" name="account_holder_name" id="" placeholder="Account Holder Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Account Number:</label>
                                        <input type="text" class="form-control form_height" name="account_number" id="" placeholder="Account Number">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Bank Name:</label>
                                        <input type="text" class="form-control form_height" name="bank_name" id="" placeholder="Bank Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Bank Identifier Code:</label>
                                        <input type="text" class="form-control form_height" name="bank_identifer_code" id="" placeholder="Bank Identifier Code">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Branch:</label>
                                        <input type="text" class="form-control form_height" name="bank_branch" id="" placeholder="Branch Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1" class="label_all">Tax Payer ID:</label>
                                        <input type="text" class="form-control form_height" name="tax_payer_id" id="" placeholder="Tax Payed ID">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12 col-12 text-center">
                                <button type="submit" name="command" value="submit" class="btn btn-primary btn-big submit_user_button px-4" id="">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <?php include('includes/footer.php') ?>
            <!-- Footer -->
        </div>
    </div>

    <?php include('includes/commonjs.php') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.choosen-index').select2();
            $('.choosen-index').width('100%');

        });
    </script>
</body>

</html>