<style type="text/css">
  .sidebar .nav-item .nav-link span {
    font-size: 14px;
    font-weight: 400display: inline;
  }
  
  .sidebar-light .nav-item .nav-link:active i,
  .sidebar-light .nav-item .nav-link:focus i,
  .sidebar-light .nav-item .nav-link:hover i {
    color: #ffffff;
  }
  
  .sidebar-brand-text {
    font-weight: 600;
    font-size: 1.1rem;
  }
  
  .active {
    background:#1572e8 !important;
    color: white !important;
  }
</style>
<ul class="navbar-nav sidebar sidebar-light accordion pt-3" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= ADMIN_URL ?>index.php" style="margin-bottom: 50px !important;margin-top: 20px !important;">
    <!--  <div class="sidebar-brand-icon">
          <img src="img/logo/logo2.png">
        </div> -->
    <div class="sidebar-brand-text">
      <img src="<?php echo ADMIN_URL.'img/logo/Taste-Jamaica-Logo-Slogan 1.png'?>" alt="..logo" width="130px" height="150px">
      <!-- <span class="">
        <i style="color: #2dce89;font-size: 8px;margin-left: 4px;" class="fa-sharp fa-solid fa-circle"></i>
      </span> -->
    </div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item active">
    <a class="nav-link" href="<?= ADMIN_URL ?>index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Home</span></a>
  </li>
  <hr class="sidebar-divider">
  <!-- <div class="sidebar-heading">
        Features
      </div> -->
  <?php if (CheckModules('management-master') || CheckModules('inventory-master')) { ?>
    <li class="nav-item" style="display:none">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemanagment" aria-expanded="true" aria-controls="collapseBootstrap">
        <i class="far fa-fw fa-window-maximize"></i>
        <span>Management</span>
      </a>
      <?php $managment_arr = array('visitors.php'); ?>
      <div id="collapsemanagment" class="collapse <?php if (in_array($file_name, $managment_arr)) {  echo 'show'; } ?>" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

          <?php if(check_permission('visitors.php')){ ?>
          <a class="collapse-item <?php if ($file_name == 'visitors.php') { echo 'active'; } ?>" href="<?= ADMIN_URL ?>visitors.php"><i class="fa fa-long-arrow-right pr-2" aria-hidden="true"></i>visitors</a>
          <?php } ?>
         
       
        </div>
      </div>
    </li>
  <?php } ?>



  <?php if (CheckModules('user-master')) { ?>
  <li class="nav-item" style="display: none;">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user" aria-expanded="true" aria-controls="collapseBootstrap">
      <i class="far fa-fw fa-window-maximize"></i>
      <span>User</span>
    </a>
    <div id="user" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <?php if(check_permission('user.php')){ ?>
        <a class="collapse-item" href="<?= ADMIN_URL ?>user.php"><i class="fa fa-long-arrow-right pr-2" aria-hidden="true"></i>User</a>
        <?php } ?>
      </div>
    </div>
  </li>
  <?php } ?>



  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="<?= ADMIN_URL.'administrators.php'?>">
      <i class="fa fa-male" aria-hidden="true" style="font-size: 18px;"></i>
      <span style="margin-left: 11px;">Administrators</span>
    </a>
  </li>
  <?php } ?>
  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="<?= ADMIN_URL.'user-profile.php'?>">
    <i class="fa fa-user-plus" aria-hidden="true" style="font-size: 18px;"></i>
      <span>User Profile</span>
    </a>
  </li>
  <?php } ?>
  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="<?= ADMIN_URL.'get-listed-profile.php'?>">
    <i class="fa fa-th-list" aria-hidden="true" style="font-size: 18px;"></i>
      <span style="margin-left: 5px;">Get Listed Profile</span>
    </a>
  </li>
  <?php } ?>
  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="jamaica-products.php">
    <i class="fa fa-cutlery" aria-hidden="true" style="font-size: 18px;"></i>
      <span style="margin-left: 9px;font-size: 13px;">Made in Jamaica Products</span>
    </a>
  </li>
  <?php } ?>
  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="news.php">
    <i class="fa fa-file-text" aria-hidden="true" style="font-size: 18px;"></i>
      <span style="margin-left: 11px;">News</span>
    </a>
  </li>
  <?php } ?>
  <?php if (CheckModules('accounts-master')) { ?>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="jamaica-tv.php">
    <i class="fa fa-video-camera" aria-hidden="true" style="font-size: 18px;"></i>
      <span style="margin-left: 4px;">Taste Jamaica TV

      </span>
    </a>
  </li>
  <?php } ?>



</ul>