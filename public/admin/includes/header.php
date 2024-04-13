
<style type="text/css">
    .span_navbar{padding: 3px 11px 2px 11px;}
    .font_navbar_icon {font-size: 16px;}
    .font_weight {font-weight: 500}
    .navbar-expand .navbar-nav .nav-link {padding-right: .4rem;padding-left: 0.4rem;}
    .topbar #sidebarToggleTop {-webkit-box-shadow: 0 0!important;width: 45px;height: 70px;color:black}
    .btn-link fa-bars {font-size: 22px;}
    .btn-link:hover {color: #3c3c4e;text-decoration: underline;}
    .dropdown-menu-right {background-color: #3c3c4e;width: 20rem !important;padding: 10px 0px 0px 0px !important;}
    .dropdown-divider {margin: 0rem !important;}
    .btn_nav_user {background-color: #f4f4f4;border: 1px solid #ddd;color: #444;}
    .label_clock {color: #525f7f;font-weight: 600;font-size: 17px;}    
    .label_modal {color: #525f7f;font-weight: 700;font-size: 18px;}
    .label_note {color: #525f7f;font-weight: 600;font-size: 18px;}
    .card_shadow{box-shadow: 0 0 2rem 0 rgba(136,152,170,.15)!important;}
    .color_proft_sale {color: #525f7f;font-size: 17px;}
    .color_rs {color: #525f7f;font-size: 16px;}
    .color_sale_txt {font-size: 16px;font-weight: 700}
    .dropdown_header {color: #555;}                
</style>
<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-2 static-top pr-2 pl-0 px-0">
    <button id="sidebarToggleTop" class="btn btn-link mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-sm-auto">
 
   

     
        <li class="nav-item dropdown no-arrow d-none d-lg-inline">
            <a class="nav-link font_weight" href="#" id="" style="color:black !important">
                <!-- 25/03/2023 -->
                <?php echo  date('d/m/Y'); ?>
            </a>
        </li>
  
  
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <!-- <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 60px"> -->
        <span class="ml-2  text-white medium font_weight" style="color:black !important"><?= $auth_row['name']; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <div class="text-center mb-5">
            <img class="img-profile rounded-circle" src="img/boy.png" style="max-width: 40px">
            <p class="mt-2 text-white"><?= $auth_row['name']; ?></p>
        </div>
        <!-- <div class="dropdown-divider"></div> -->
        <div class="mt-4" style="background-color: #fff;">
            <div class="d-flex justify-content-between">
                <div class="p-2" >
                    <a href="<?= ADMIN_URL.'permissions/roles.php' ?>" class="btn btn_nav_user">Roles & Permissions</a>
                </div>
                <div class="p-2">
                    <button type="button" onclick="window.location.href='<?= ADMIN_URL ?>logout.php'" class="btn btn_nav_user">Logout</button>
                </div>
            </div>
        </div>
      </div>
    </li>
  </ul>
</nav>
<!-- Modal 1 click note -->
<div class="modal fade" id="clicknote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title label_clock" id="exampleModalLabel" >Clock In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <h4 class="h4 label_modal">IP Address: 115.186.161.20</h4>
                    <div class="form-group mt-4">
                        <label for="exampleFormControlSelect1" class="label_note">Clock In Note</label>
                        <textarea class="form-control" rows="3" name="clock_notes" cols="50" id="" placeholder="Clock In Note"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " style="background-color: #ededed;" data-dismiss="modal">Close</button>
                <button type="button" class="btn " style="background-color: #1367d1; border: 1px solid #1367d1;color: #fff">Save changes</button>
            </div>
        </div>
    </div>
</div>

